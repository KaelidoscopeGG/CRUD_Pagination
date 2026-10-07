<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Customer Account</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow mx-auto" style="max-width: 800px;">
            <div class="card-body p-4">
                <h1 class="h3 mb-4">Edit Customer Account</h1>

                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('dashboard/account/' . $account['id'] . '/update') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Meter Number</label>
                            <input type="text" name="meter_number" class="form-control"
                                   value="<?= esc(old('meter_number', $account['meter_number'])) ?>" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Customer Name</label>
                            <input type="text" name="customer_name" class="form-control"
                                   value="<?= esc(old('customer_name', $account['customer_name'])) ?>" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" class="form-control"
                                   value="<?= esc(old('address', $account['address'])) ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control"
                                   value="<?= esc(old('email', $account['email'])) ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control"
                                   value="<?= esc(old('phone', $account['phone'])) ?>" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Connection Type</label>
                            <select name="connection_type" class="form-select" required>
                                <option value="">Choose a type</option>
                                <option value="residential" <?= $account['connection_type'] === 'residential' ? 'selected' : '' ?>>Residential</option>
                                <option value="commercial" <?= $account['connection_type'] === 'commercial' ? 'selected' : '' ?>>Commercial</option>
                                <option value="industrial" <?= $account['connection_type'] === 'industrial' ? 'selected' : '' ?>>Industrial</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="active" <?= $account['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                                <option value="inactive" <?= $account['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                <option value="suspended" <?= $account['status'] === 'suspended' ? 'selected' : '' ?>>Suspended</option>
                            </select>
                        </div>

                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-success">Edit Account</button>
                        <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>