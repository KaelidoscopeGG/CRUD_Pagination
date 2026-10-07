<?php
namespace App\Controllers;

use App\Models\CustomerAccountModel;

class Dashboard extends BaseController
{
    protected $customerModel;

    public function __construct()
    {
        $this->customerModel = new CustomerAccountModel();
    }

    public function index()
    {
        // Block dashboard access until the user logs in.
        if (session()->get('isLogged') !== true) {
            return redirect()->to('/login')
                ->with('error', 'Please log in to access the dashboard.');
        }

        $keyword = $this->request->getGet('search');
        $status  = $this->request->getGet('status');
        $type    = $this->request->getGet('type');

        $perPage = 10;

        if ($keyword) {
            $accounts = $this->customerModel->searchAccounts($keyword, $perPage);
        } elseif ($status) {
            $accounts = $this->customerModel->getAccountsByStatus($status, $perPage);
        } elseif ($type) {
            $accounts = $this->customerModel->getAccountsByType($type, $perPage);
        } else {
            $accounts = $this->customerModel->getAccountsPaginated($perPage);
        }

        $data = [
            'accounts'           => $accounts,
            'pager'              => $this->customerModel->pager,
            'total_accounts'     => $this->customerModel->getTotalAccounts(),
            'active_accounts'    => $this->customerModel->getCountByStatus('active'),
            'inactive_accounts'  => $this->customerModel->getCountByStatus('inactive'),
            'suspended_accounts' => $this->customerModel->getCountByStatus('suspended'),
            'current_page'       => $this->request->getGet('page') ?? 1,
            'search_keyword'     => $keyword,
            'filter_status'      => $status,
            'filter_type'        => $type,
            'title'              => 'Dashboard - Puihaha Electric',
            'username'           => session()->get('username'),
        ];

        return view('dashboard/dashboard', $data);
    }

    public function viewAccount($id)
    {
        if (session()->get('isLogged') !== true) {
            return redirect()->to('/login')
                ->with('error', 'Please log in to access the dashboard.');
        }

        $account = $this->customerModel->find($id);

        if (! $account) {
            return redirect()->to('/dashboard')
                ->with('error', 'Account not found.');
        }

        return view('dashboard/view_account', [
            'account' => $account,
        ]);
    }

    public function create()
    {
        if (session()->get('isLogged') !== true) {
            return redirect()->to('/login');
        }

        return view('dashboard/create_account');
    }

    public function store()
    {
        if (session()->get('isLogged') !== true) {
            return redirect()->to('/login');
        }

        $rules = [
            'customer_name'   => 'required|max_length[150]',
            'address'         => 'required|max_length[255]',
            'phone'           => 'required|max_length[30]',
            'email'           => 'required|valid_email|max_length[150]',
            'meter_number'    => 'required|max_length[50]',
            'connection_type' => 'required|in_list[residential,commercial,industrial]',
            'status'          => 'required|in_list[active,inactive,suspended]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->customerModel->insert([
            'account_number' => $this->generateAccountNumber(),
            'customer_name'   => $this->request->getPost('customer_name'),
            'address'         => $this->request->getPost('address'),
            'phone'           => $this->request->getPost('phone'),
            'email'           => $this->request->getPost('email'),
            'meter_number'    => $this->request->getPost('meter_number'),
            'connection_type' => $this->request->getPost('connection_type'),
            'status'          => $this->request->getPost('status'),
        ]);

        return redirect()->to('/dashboard')
            ->with('success', 'Customer account created successfully.');
    }

    public function edit($id)
    {
        if (session()->get('isLogged') !== true) {
            return redirect()->to('/login');
        }

        $account = $this->customerModel->find($id);

        if (! $account) {
            return redirect()->to('/dashboard')
                ->with('error', 'Account not found.');
        }

        return view('dashboard/edit_account', [
            'account' => $account,
        ]);
    }

    public function update($id)
    {
        if (session()->get('isLogged') !== true) {
            return redirect()->to('/login');
        }

        $account = $this->customerModel->find($id);

        if (! $account) {
            return redirect()->to('/dashboard')
                ->with('error', 'Account not found.');
        }

        $rules = [
            'customer_name'   => 'required|max_length[150]',
            'address'         => 'required|max_length[255]',
            'phone'           => 'required|max_length[30]',
            'email'           => 'required|valid_email|max_length[150]',
            'meter_number'    => 'required|max_length[50]',
            'connection_type' => 'required|in_list[residential,commercial,industrial]',
            'status'          => 'required|in_list[active,inactive,suspended]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->customerModel->update($id, [
            'customer_name'   => $this->request->getPost('customer_name'),
            'address'         => $this->request->getPost('address'),
            'phone'           => $this->request->getPost('phone'),
            'email'           => $this->request->getPost('email'),
            'meter_number'    => $this->request->getPost('meter_number'),
            'connection_type' => $this->request->getPost('connection_type'),
            'status'          => $this->request->getPost('status'),
        ]);

        return redirect()->to('/dashboard')
            ->with('success', 'Customer account updated successfully.');
    }

    public function delete($id)
    {
        if (session()->get('isLogged') !== true) {
            return redirect()->to('/login');
        }

        $account = $this->customerModel->find($id);

        if (! $account) {
            return redirect()->to('/dashboard')
                ->with('error', 'Account not found.');
        }

        $this->customerModel->delete($id);

        return redirect()->to('/dashboard')
            ->with('success', 'Customer account deleted successfully.');
    }

    private function generateAccountNumber(): string
    {
        $latestAccount = $this->customerModel
            ->orderBy('id', 'DESC')
            ->first();

        $lastNumber = 0;

        if ($latestAccount && preg_match('/(\d+)$/', $latestAccount['account_number'], $matches)) {
            $lastNumber = (int) $matches[1];
        }

        $nextNumber = $lastNumber + 1;

        return 'EC-' . date('Y') . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }
}
