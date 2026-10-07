<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<section class="bg-light-custom section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-5">
                <div class="card shadow">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <i class="fas fa-bolt fa-3x text-warning mb-3"></i>
                            <h1 class="h2 text-primary-custom">Log In</h1>
                            <p class="text-muted">Access your Puihaha Electric account.</p>
                        </div>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger" role="alert">
                                <?= esc(session()->getFlashdata('error')) ?>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success" role="status">
                                <?= esc(session()->getFlashdata('success')) ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('login') ?>" method="POST">
                            <?= csrf_field() ?>

                            <div class="mb-3">
                                <label for="username" class="form-label fw-semibold">
                                    Username
                                </label>

                                <input
                                    type="text"
                                    class="form-control form-control-lg"
                                    name="username"
                                    id="username"
                                    value="<?= esc(old('username')) ?>"
                                    required
                                    autofocus
                                >
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold">
                                    Password
                                </label>

                                <div class="input-group">
                                    <input
                                        type="password"
                                        class="form-control form-control-lg"
                                        name="password"
                                        id="password"
                                        required
                                    >

                                    <button
                                        class="btn btn-outline-secondary"
                                        type="button"
                                        id="togglePassword"
                                        aria-label="Show or hide password"
                                    >
                                        <i class="fa-solid fa-eye-slash"></i>
                                    </button>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-sign-in-alt me-2"></i>Log In
                            </button>
                        </form>

                        <p class="text-center text-muted mt-4 mb-0">
                            No account yet?
                            <a href="<?= base_url('register') ?>">Register here</a>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    const password = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');
    const icon = togglePassword.querySelector('i');

    togglePassword.addEventListener('click', () => {
        const isHidden = password.type === 'password';

        password.type = isHidden ? 'text' : 'password';
        icon.classList.toggle('fa-eye', isHidden);
        icon.classList.toggle('fa-eye-slash', !isHidden);
    });
</script>

<?= $this->endSection() ?>