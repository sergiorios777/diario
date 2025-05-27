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
        var productsData = <?= json_encode($products ?? []) ?>; // Pasar datos PHP a JS

        $('#productsTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
                emptyTable: "No hay productos registrados para mostrar." // Mensaje para tabla vacía
            },
            data: productsData, // Usar los datos pasados
            columns: [
                { data: 'code' },
                { data: 'name' },
                { data: 'category_name', defaultContent: 'N/A' }, // o category_id
                { data: 'unit_of_measure' },
                { 
                    data: 'sale_price',
                    render: function(data, type, row) {
                        return 'S/ ' + parseFloat(data).toFixed(2);
                    }
                },
                { 
                    data: 'cost_price',
                    render: function(data, type, row) {
                        return 'S/ ' + parseFloat(data).toFixed(2);
                    }
                },
                { data: 'stock_quantity' },
                {
                    data: 'id', // Usamos el ID para generar los enlaces de acción
                    render: function(data, type, row) {
                        let editUrl = '<?= site_url('products/edit/') ?>' + data;
                        let deleteUrl = '<?= site_url('products/delete/') ?>' + data;
                        return `
                            <a href="${editUrl}" class="btn btn-sm btn-outline-warning" title="Editar"><i class="bi bi-pencil-square"></i></a>
                            <a href="${deleteUrl}" class="btn btn-sm btn-outline-danger" title="Eliminar" onclick="return confirm('¿Estás seguro de querer eliminar este producto? Se moverá a la papelera.');"><i class="bi bi-trash3"></i></a>
                        `;
                    },
                    orderable: false, // La columna de acciones no se ordena
                    searchable: false // La columna de acciones no se busca
                }
            ],
            "responsive": true, // Opcional
        });
        });
    </script>
<?= $this->endSection() ?>
