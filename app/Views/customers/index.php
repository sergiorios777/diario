<?= $this->extend('layouts/app_layout') ?>

<?= $this->section('title') ?>
    Gestión de Clientes
<?= $this->endSection() ?>

<?= $this->section('pageStyles') ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Clientes</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="<?= site_url('customers/new') ?>" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-plus-circle"></i> Nuevo Cliente
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table id="customersTable" class="table table-striped table-hover table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre / Razón Social</th>
                    <th>DNI/RUC</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                </tbody>
        </table>
    </div>
<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            var customersData = <?= json_encode($customers ?? []) ?>;
            $('#customersTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
                    emptyTable: "No hay clientes registrados."
                },
                data: customersData,
                columns: [
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'document_number', defaultContent: '-' },
                    { data: 'email', defaultContent: '-' },
                    { data: 'phone', defaultContent: '-' },
                    {
                        data: 'id',
                        render: function(data, type, row) {
                            let editUrl = '<?= site_url('customers/edit/') ?>' + data;
                            let deleteUrl = '<?= site_url('customers/delete/') ?>' + data;
                            return `
                                    <a href="${editUrl}" class="btn btn-sm btn-outline-warning" title="Editar"><i class="bi bi-pencil-square"></i></a>
                                    <a href="${deleteUrl}" class="btn btn-sm btn-outline-danger ms-1" title="Eliminar" onclick="return confirm('¿Estás seguro de querer eliminar este cliente?');"><i class="bi bi-trash3"></i></a>
                            `;
                        },
                    orderable: false,
                    searchable: false
                    }
                ],
                order: [[1, 'asc']] // Ordenar por nombre ascendente
            });
        });
</script>
<?= $this->endSection() ?>
