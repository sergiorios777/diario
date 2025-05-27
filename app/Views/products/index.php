<?= $this->extend('layouts/app_layout') ?>

<?= $this->section('title') ?>
    Gestión de Productos
<?= $this->endSection() ?>

<?= $this->section('pageStyles') ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Productos</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="<?= site_url('products/new') ?>" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-plus-circle"></i> Nuevo Producto
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table id="productsTable" class="table table-striped table-hover table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>U. Medida</th>
                    <th>P. Venta</th>
                    <th>Costo</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= esc($product['code']) ?></td>
                            <td><?= esc($product['name']) ?></td>
                            <td><?= esc($product['category_name'] ?? ($product['category_id'] ?? 'N/A')) ?></td>
                            <td><?= esc($product['unit_of_measure']) ?></td>
                            <td>S/ <?= esc(number_format($product['sale_price'], 2)) ?></td>
                            <td>S/ <?= esc(number_format($product['cost_price'], 2)) ?></td>
                            <td><?= esc($product['stock_quantity']) ?></td>
                            <td>
                                <a href="<?= site_url('products/edit/' . $product['id']) ?>" class="btn btn-sm btn-outline-warning" title="Editar"><i class="bi bi-pencil-square"></i></a>
                                <a href="<?= site_url('products/delete/' . $product['id']) ?>" class="btn btn-sm btn-outline-danger" title="Eliminar" onclick="return confirm('¿Estás seguro de querer eliminar este producto? Se moverá a la papelera.');"><i class="bi bi-trash3"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">No hay productos registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script> <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#productsTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json', // Traducción a español
                },
                // "processing": true, // Descomentar si usas server-side
                // "serverSide": true, // Descomentar si usas server-side
                // "ajax": "<?= site_url('products/ajaxProducts') ?>", // Descomentar si usas server-side
                "responsive": true, // Para hacerlo responsivo
            });
        });
    </script>
<?= $this->endSection() ?>
