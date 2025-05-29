<?= $this->extend('layouts/app_layout') ?>

<?= $this->section('title') ?>
    Gestión de Compras
<?= $this->endSection() ?>

<?= $this->section('pageStyles') ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Compras Registradas</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="<?= site_url('purchases/new') ?>" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-plus-circle"></i> Registrar Nueva Compra
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table id="purchasesTable" class="table table-striped table-hover table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Proveedor</th>
                    <th>Referencia</th>
                    <th>Monto Total</th>
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
            var purchasesData = <?= json_encode($purchases ?? []) ?>;
            $('#purchasesTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
                    emptyTable: "No hay compras registradas."
                },
                data: purchasesData,
                columns: [
                    { data: 'id' },
                    { data: 'purchase_date' },
                    { data: 'supplier_name', defaultContent: function(data, type, row) { return row.supplier_name_text || 'N/A'; } },
                    { data: 'reference_no', defaultContent: '-' },
                    { 
                        data: 'total_amount',
                        render: function(data, type, row) {
                            return 'S/ ' + parseFloat(data).toFixed(2);
                        }
                    },
                    {
                        data: 'id',
                        render: function(data, type, row) {
                            let showUrl = '<?= site_url('purchases/show/') ?>' + data;
                            return `<a href="${showUrl}" class="btn btn-sm btn-outline-info" title="Ver Detalle"><i class="bi bi-eye"></i></a>`;
                        },
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [[1, 'desc']] // Ordenar por fecha descendente por defecto
            });
        });
    </script>
<?= $this->endSection() ?>
