<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a BizDaily - Gestión Simplificada</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .hero-section {
            background-color: #f8f9fa; /* Un gris claro o tu color primario suave */
            padding: 6rem 0;
        }
        .login-card {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,.15);
        }
        .footer {
            background-color: #343a40;
            color: white;
            padding: 2rem 0;
            font-size: 0.9em;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="#">
                BizDaily
            </a>
            </div>
    </nav>

    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 mb-4 mb-lg-0">
                    <h1 class="display-4 fw-bold text-primary">Bienvenido a BizDaily</h1>
                    <p class="lead my-4 text-muted">
                        Simplifica la gestión diaria de tu negocio. Controla tus productos, ventas, compras y gastos de manera eficiente y centralizada.
                    </p>
                    <p class="text-muted">
                        Accede a tu cuenta para empezar a organizar tu información.
                    </p>
                    <a href="<?= site_url('login') ?>" class="btn btn-outline-primary btn-lg">Ir a Iniciar Sesión</a> 
                </div>

                <div class="col-lg-5" id="loginCard">
                    <div class="card login-card">
                        <div class="card-body p-4 p-lg-5">
                            <h2 class="card-title text-center h4 mb-4">Accede a tu Cuenta</h2>
                            
                            <form action="<?= site_url('login') ?>" method="post">
                                <?= csrf_field() ?>

                                <?php if (session('error')) : ?>
                                    <div class="alert alert-danger"><?= session('error') ?></div>
                                <?php endif ?>
                                <?php if (session('message')) : ?>
                                    <div class="alert alert-success"><?= session('message') ?></div>
                                <?php endif ?>

                                <div class="mb-3">
                                    <label for="login" class="form-label">Correo Electrónico o Usuario</label>
                                    <input type="text" class="form-control" id="login" name="login" value="<?= old('login') ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Contraseña</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>

                                <?php if (setting('Auth.allowRemembering')): ?>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="remember" name="remember" <?= old('remember') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="remember">Recordarme</label>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg">Ingresar</button>
                                </div>
                            </form>
                            <hr class="my-4">
                            <div class="text-center">
                                <?php if (setting('Auth.allowRegistration')) : ?>
                                    <p class="mb-1"><a href="<?= site_url('register') ?>">¿No tienes una cuenta? Regístrate</a></p>
                                <?php endif; ?>
                                <?php if (setting('Auth.activeResetter')): ?>
                                    <p class="mb-0"><a href="<?= site_url('forgot') ?>">¿Olvidaste tu contraseña?</a></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer text-center">
        <div class="container">
            <p>&copy; <?= date('Y') ?> BizDaily. Todos los derechos reservados.</p>
            </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>