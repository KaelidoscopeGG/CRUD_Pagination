<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Dashboard') ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px 0;
        }

        .main-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin: 20px auto;
        }

        .header-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .header-section h1 {
            color: #667eea;
            font-weight: bold;
        }

        .stats-card {
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            color: white;
        }

        .stats-card h3 {
            font-size: 2rem;
            font-weight: bold;
            margin: 0;
        }

        .stats-card p {
            margin: 5px 0 0;
            opacity: 0.9;
        }

        .card-total {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .card-active {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }

        .card-inactive {
            background: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%);
        }

        .card-suspended {
            background: linear-gradient(135deg, #fc4a1a 0%, #f7b733 100%);
        }

        .search-filter-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .table-container {
            overflow-x: auto;
        }

        .badge-active {
            background-color: #28a745;
        }

        .badge-inactive {
            background-color: #dc3545;
        }

        .badge-suspended {
            background-color: #ffc107;
            color: #000;
        }

        .pagination {
            margin-top: 20px;
        }

        .pagination a,
        .pagination span {
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="main-container">
            <div class="header-section">
                <h1>
                    <i class="bi bi-lightning-charge-fill text-warning"></i>
                    Puihaha Electric Company
                </h1>

                <p class="text-muted">Customer Account Management System</p>

                <p class="mb-0">
                    Welcome, <strong><?= esc($username) ?></strong>.
                </p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger" role="alert">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success" role="alert">
                    <?= esc(session()->getFlashdata('success')) ?>
                </div>
            <?php endif; ?>

            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="stats-card card-total">
                        <h3><?= esc($total_accounts) ?></h3>
                        <p>Total Accounts</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stats-card card-active">
                        <h3><?= esc($active_accounts) ?></h3>
                        <p>Active Accounts</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stats-card card-inactive">
                        <h3><?= esc($inactive_accounts) ?></h3>
                        <p>Inactive Accounts</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stats-card card-suspended">
                        <h3><?= esc($suspended_accounts) ?></h3>
                        <p>Suspended Accounts</p>
                    </div>
                </div>
            </div>

            <div class="mb-3 text-end">
                <a href="<?= base_url('dashboard/create') ?>" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i> Add Customer Account
                </a>
            </div>

            <div class="search-filter-section">
                <form method="GET" action="<?= base_url('dashboard') ?>">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <input
                                type="text"
                                class="form-control"
                                name="search"
                                placeholder="Search by name, account, email, phone..."
                                value="<?= esc($search_keyword ?? '') ?>"
                            >
                        </div>

                        <div class="col-md-3">
                            <select class="form-select" name="status">
                                <option value="">All Status</option>
                                <option value="active" <?= ($filter_status ?? '') === 'active' ? 'selected' : '' ?>>
                                    Active
                                </option>
                                <option value="inactive" <?= ($filter_status ?? '') === 'inactive' ? 'selected' : '' ?>>
                                    Inactive
                                </option>
                                <option value="suspended" <?= ($filter_status ?? '') === 'suspended' ? 'selected' : '' ?>>
                                    Suspended
                                </option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <select class="form-select" name="type">
                                <option value="">All Types</option>
                                <option value="residential" <?= ($filter_type ?? '') === 'residential' ? 'selected' : '' ?>>
                                    Residential
                                </option>
                                <option value="commercial" <?= ($filter_type ?? '') === 'commercial' ? 'selected' : '' ?>>
                                    Commercial
                                </option>
                                <option value="industrial" <?= ($filter_type ?? '') === 'industrial' ? 'selected' : '' ?>>
                                    Industrial
                                </option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search"></i> Search
                            </button>
                        </div>
                    </div>
                </form>

                <?php if ($search_keyword || $filter_status || $filter_type): ?>
                    <div class="mt-2">
                        <a href="<?= base_url('dashboard') ?>" class="btn btn-sm btn-secondary">
                            <i class="bi bi-x-circle"></i> Clear Filters
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <div class="table-container">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Account Number</th>
                            <th>Customer Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Connection Type</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (empty($accounts)): ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    No accounts found.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($accounts as $account): ?>
                                <tr>
                                    <td>
                                        <strong><?= esc($account['account_number']) ?></strong>
                                    </td>

                                    <td><?= esc($account['customer_name']) ?></td>
                                    <td><?= esc($account['email']) ?></td>
                                    <td><?= esc($account['phone']) ?></td>

                                    <td>
                                        <span class="badge bg-info">
                                            <?= ucfirst(esc($account['connection_type'])) ?>
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge badge-<?= esc($account['status']) ?>">
                                            <?= ucfirst(esc($account['status'])) ?>
                                        </span>
                                    </td>

                                    <td class="text-nowrap">
                                        <a
                                            href="<?= base_url('dashboard/account/' . $account['id']) ?>"
                                            class="btn btn-sm btn-outline-primary"
                                        >
                                            <i class="bi bi-eye"></i> View
                                        </a>

                                        <a
                                            href="<?= base_url('dashboard/account/' . $account['id'] . '/edit') ?>"
                                            class="btn btn-sm btn-outline-warning"
                                        >
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>

                                        <form
                                            action="<?= base_url('dashboard/account/' . $account['id'] . '/delete') ?>"
                                            method="post"
                                            class="d-inline"
                                            onsubmit="return confirm('Delete this customer account?');"
                                        >
                                            <?= csrf_field() ?>

                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if ($pager): ?>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        Showing page <?= esc($current_page) ?>
                        of <?= esc($pager->getPageCount()) ?>
                    </div>

                    <div>
                        <?= $pager->links() ?>
                    </div>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('logout') ?>" method="post" class="mt-4 text-center">
                <?= csrf_field() ?>

                <button type="submit" class="btn btn-outline-secondary">
                    <i class="bi bi-box-arrow-right"></i> Log Out
                </button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>