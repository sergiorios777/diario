<?= $this->extend('layouts/app_layout') ?> <?= '' // Asume que tienes un layout base 'default.php' ?>

<?= $this->section('title') ?>
<?= esc($title ?? 'Proveedores') ?>
<?= $this->endSection() ?>

<?= $this->section('pageStyles') ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1><?= esc($title ?? 'Gestión de Proveedores') ?></h1>
        <a href="<?= site_url('suppliers/new') ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Registrar Proveedor
        </a>
    </div>

    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('message') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table id="suppliersTable" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre/Razón Social</th>
                    <th>RUC</th>
                    <th>Creado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($suppliers) && is_array($suppliers)): ?>
                    <?php foreach ($suppliers as $supplier): ?>
                    <tr>
                        <td><?= esc($supplier->id) ?></td>
                        <td><?= esc($supplier->name) ?></td>
                        <td><?= esc($supplier->ruc ?? 'N/A') ?></td>
                        <td><?= esc( (new \CodeIgniter\I18n\Time($supplier->created_at))->toLocalizedString('dd MMM, yyyy HH:mm') ) ?></td>
                        <td>
                            <a href="<?= site_url('suppliers/' . $supplier->id . '/edit') ?>" class="btn btn-sm btn-warning" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="<?= site_url('suppliers/' . $supplier->id) ?>" method="post" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este proveedor?');">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No hay proveedores registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if (isset($pager) && $pager): ?>
        <?= $pager->links('default', 'bootstrap_pager') // Usar un template de paginación para Bootstrap ?>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
<script>
    $(document).ready(function() {
        $('#suppliersTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json" // URL para español de DataTables
            }
            // Puedes añadir más opciones de DataTables aquí si es necesario
            "paging": <?= isset($pager) && $pager ? 'false' : 'true' ?>, // Deshabilitar paginación de DataTables si usas la del servidor
        });
    });
</script>
<?= $this->endSection() ?>
