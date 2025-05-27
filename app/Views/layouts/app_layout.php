<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title', 'BizDaily - Aplicación') ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="<?= base_url('assets/css/app_layout_style.css') ?>"> <?= $this->renderSection('pageStyles') ?> </head>
<body>

    <div class="d-flex" id="wrapper">

        <aside class="border-end shadow-sm" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-3 fs-4 fw-bold text-primary border-bottom">
                <a href="<?= site_url('dashboard') ?>" class="text-decoration-none text-primary">
                    BizDaily
                </a>
            </div>
            <div class="list-group list-group-flush mt-2">
                <a href="<?= site_url('dashboard') ?>" class="list-group-item list-group-item-action <?= (url_is('dashboard*')) ? 'active' : '' ?>">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </a>
                <a href="<?= site_url('products') ?>" class="list-group-item list-group-item-action <?= (url_is('products*')) ? 'active' : '' ?>">
                    <i class="bi bi-box-seam me-2"></i>Productos
                </a>
                <a href="<?= site_url('sales') ?>" class="list-group-item list-group-item-action <?= (url_is('sales*')) ? 'active' : '' ?>">
                    <i class="bi bi-cart4 me-2"></i>Ventas
                </a>
                <a href="<?= site_url('purchases') ?>" class="list-group-item list-group-item-action <?= (url_is('purchases*')) ? 'active' : '' ?>">
                    <i class="bi bi-truck me-2"></i>Compras
                </a>
                <a href="<?= site_url('customers') ?>" class="list-group-item list-group-item-action <?= (url_is('customers*')) ? 'active' : '' ?>">
                    <i class="bi bi-people me-2"></i>Clientes
                </a>
                <a href="<?= site_url('suppliers') ?>" class="list-group-item list-group-item-action <?= (url_is('suppliers*')) ? 'active' : '' ?>">
                    <i class="bi bi-person-lines-fill me-2"></i>Proveedores
                </a>
                <a href="<?= site_url('expenses') ?>" class="list-group-item list-group-item-action <?= (url_is('expenses*')) ? 'active' : '' ?>">
                    <i class="bi bi-wallet2 me-2"></i>Gastos
                </a>
                </div>
        </aside>
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
                <div class="container-fluid">
                    <button class="btn btn-sm btn-outline-primary" id="sidebarToggle"><i class="bi bi-list fs-5"></i></button>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mt-2 mt-lg-0 align-items-center">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarUserDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle fs-5 me-1"></i>
                                    <?= auth()->user()->username ?? 'Usuario' ?>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarUserDropdown">
                                    <li><a class="dropdown-item" href="#!"><i class="bi bi-person-fill me-2"></i>Mi Perfil (Próximamente)</a></li>
                                    <li><a class="dropdown-item" href="#!"><i class="bi bi-gear-fill me-2"></i>Configuración (Próximamente)</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="<?= site_url('logout') ?>"><i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <main class="container-fluid p-4">
                <?php if (session()->getFlashdata('success')) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <?= $this->renderSection('content') ?>
            </main>
            <footer class="py-3 mt-auto bg-light border-top">
                <div class="container-fluid text-center">
                    <small class="text-muted">&copy; <?= date('Y') ?> BizDaily. Todos los derechos reservados. Ver. MVP Core</small>
                </div>
            </footer>
        </div>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/js/app_layout_script.js') ?>"></script> <?= $this->renderSection('pageScripts') ?> </body>
</html>