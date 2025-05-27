<?= $this->extend('layouts/app_layout') ?>

<?= $this->section('title') ?>
    Dashboard - BizDaily
<?= $this->endSection() ?>

<?= $this->section('pageStyles') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        </div>

    <p>Bienvenido al panel de control de BizDaily.</p>

    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3">¡Bienvenido, [Nombre de Usuario/Negocio]!</h1>
            <p class="lead">Aquí tienes un resumen de la actividad reciente de tu negocio.</p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card text-center h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-box-seam-fill me-2"></i> Total de Productos
                    </h5>
                    <p class="card-text fs-2 fw-bold" id="totalProductos">Cargando...</p>
                    <a href="[URL_A_PRODUCTOS]" class="btn btn-outline-primary btn-sm">Gestionar Productos</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card text-center h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-cart-check-fill me-2"></i> Ventas de Hoy
                    </h5>
                    <p class="card-text fs-2 fw-bold" id="ventasHoyMonto">S/ 0.00</p>
                    <span class="text-muted" id="ventasHoyCantidad">(0 ventas)</span><br><br>
                    <a href="[URL_A_VENTAS]" class="btn btn-outline-success btn-sm mt-2">Ver Ventas</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card text-center h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-truck me-2"></i> Compras de Hoy
                    </h5>
                    <p class="card-text fs-2 fw-bold" id="comprasHoyMonto">S/ 0.00</p>
                    <span class="text-muted" id="comprasHoyCantidad">(0 compras)</span><br><br>
                    <a href="[URL_A_COMPRAS]" class="btn btn-outline-info btn-sm mt-2">Ver Compras</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-12">
            <h2 class="h4 mb-3">Acciones Rápidas</h2>
        </div>
        <div class="col-md-4 mb-2">
            <a href="[URL_NUEVA_VENTA]" class="btn btn-success btn-lg w-100">
                <i class="bi bi-plus-circle-fill me-2"></i>Nueva Venta
            </a>
        </div>
        <div class="col-md-4 mb-2">
            <a href="[URL_NUEVA_COMPRA]" class="btn btn-info btn-lg w-100">
                <i class="bi bi-plus-circle-fill me-2"></i>Nueva Compra
            </a>
        </div>
        <div class="col-md-4 mb-2">
            <a href="[URL_NUEVO_PRODUCTO]" class="btn btn-primary btn-lg w-100">
                <i class="bi bi-plus-circle-fill me-2"></i>Nuevo Producto
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <h2 class="h4 mb-3">Últimas Ventas</h2>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-sm">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Total</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody id="tablaUltimasVentas">
                        <tr><td colspan="4" class="text-center">No hay ventas recientes.</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <h2 class="h4 mb-3">Últimas Compras</h2>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-sm">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Proveedor</th>
                            <th>Total</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody id="tablaUltimasCompras">
                        <tr><td colspan="4" class="text-center">No hay compras recientes.</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?><?= $this->endSection() ?>