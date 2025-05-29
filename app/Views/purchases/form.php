<?= $this->extend('layouts/app_layout') ?>

<?= $this->section('title') ?>
    Registrar Nueva Compra
<?= $this->endSection() ?>

<?= $this->section('pageStyles') ?>
<style>
    .item-row { margin-bottom: 10px; }
    .item-row .btn-danger { margin-top: 32px; } /* Alinea botón de eliminar */
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Registrar Nueva Compra</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="<?= site_url('purchases') ?>" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left-circle"></i> Volver a Compras
            </a>
        </div>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <?php if (session()->get('errors')): ?>
                <ul>
                    <?php foreach (session()->get('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form action="<?= site_url('purchases/create') ?>" method="post" id="purchaseForm">
        <?= csrf_field() ?>
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label for="purchase_date" class="form-label">Fecha de Compra <span class="text-danger">*</span></label>
                <input type="date" class="form-control <?= (isset(session('errors')['purchase_date'])) ? 'is-invalid' : '' ?>" id="purchase_date" name="purchase_date" value="<?= old('purchase_date', date('Y-m-d')) ?>" required>
                <?php if (isset(session('errors')['purchase_date'])): ?><div class="invalid-feedback"><?= esc(session('errors')['purchase_date']) ?></div><?php endif; ?>
            </div>
            <div class="col-md-4">
                <label for="supplier_id" class="form-label">Proveedor (Lista)</label>
                <select class="form-select" id="supplier_id" name="supplier_id">
                    <option value="">Seleccionar Proveedor</option>
                    <?php if (!empty($suppliers)): ?>
                        <?php foreach ($suppliers as $supplier): ?>
                            <option value="<?= $supplier['id'] ?>" <?= old('supplier_id') == $supplier['id'] ? 'selected' : '' ?>><?= esc($supplier['name']) ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
             <div class="col-md-4">
                <label for="supplier_name_text" class="form-label">O Proveedor (Manual) <span id="supplier_manual_required_indicator" class="text-danger" style="display:none;">*</span></label>
                <input type="text" class="form-control <?= (isset(session('errors')['supplier_name_text'])) ? 'is-invalid' : '' ?>" id="supplier_name_text" name="supplier_name_text" value="<?= old('supplier_name_text') ?>">
                 <?php if (isset(session('errors')['supplier_name_text'])): ?><div class="invalid-feedback"><?= esc(session('errors')['supplier_name_text']) ?></div><?php endif; ?>
            </div>
            <div class="col-md-4">
                <label for="reference_no" class="form-label">N° Referencia (Factura/Guía)</label>
                <input type="text" class="form-control" id="reference_no" name="reference_no" value="<?= old('reference_no') ?>">
            </div>
        </div>

        <h4 class="mt-4 mb-3">Productos Comprados</h4>
        <div id="purchaseItemsContainer">
            </div>

        <button type="button" class="btn btn-success mb-3" id="addItemBtn"><i class="bi bi-plus-lg"></i> Añadir Producto</button>

        <div class="row mt-3">
            <div class="col-md-8">
                <label for="notes" class="form-label">Notas Adicionales</label>
                <textarea class="form-control" id="notes" name="notes" rows="3"><?= old('notes') ?></textarea>
            </div>
            <div class="col-md-4 text-end">
                <h3>Total Compra: S/ <span id="grandTotal">0.00</span></h3>
            </div>
        </div>

        <hr class="my-4">
        <button class="btn btn-primary btn-lg" type="submit">Guardar Compra</button>
    </form>

    <div id="itemTemplate" style="display: none;">
        <div class="row g-3 align-items-center item-row border p-2 mb-2">
            <div class="col-md-4">
                <label class="form-label">Producto <span class="text-danger">*</span></label>
                <select class="form-select product-select" name="items[][product_id]" required>
                    <option value="">Seleccionar Producto...</option>
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <option value="<?= $product['id'] ?>" data-cost="<?= esc($product['cost_price']) ?>"><?= esc($product['name']) ?> (<?= esc($product['code']) ?>)</option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Cantidad <span class="text-danger">*</span></label>
                <input type="number" class="form-control quantity-input" name="items[][quantity]" value="1" step="0.01" min="0.01" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Costo Unit. <span class="text-danger">*</span></label>
                <input type="number" class="form-control unitcost-input" name="items[][unit_cost]" value="0.00" step="0.01" min="0" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Subtotal</label>
                <input type="text" class="form-control subtotal-display" readonly value="S/ 0.00">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger removeItemBtn w-100"><i class="bi bi-trash3"></i> Quitar</button>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const itemsContainer = document.getElementById('purchaseItemsContainer');
        const addItemBtn = document.getElementById('addItemBtn');
        const itemTemplate = document.getElementById('itemTemplate').innerHTML; // Obtener el HTML de la plantilla
        const grandTotalSpan = document.getElementById('grandTotal');
        const supplierIdSelect = document.getElementById('supplier_id');
        const supplierNameText = document.getElementById('supplier_name_text');
        const supplierManualRequiredIndicator = document.getElementById('supplier_manual_required_indicator');

        function updateSupplierRequiredIndicator() {
            if (supplierIdSelect.value === '' && supplierNameText.value.trim() === '') {
                supplierManualRequiredIndicator.style.display = 'inline'; // Muestra * si ambos están vacíos
            } else if (supplierIdSelect.value !== '') {
                 supplierManualRequiredIndicator.style.display = 'none'; // Oculta si se selecciona de la lista
            } else {
                 supplierManualRequiredIndicator.style.display = 'none'; // Oculta si se escribe manualmente
            }
        }
        supplierIdSelect.addEventListener('change', updateSupplierRequiredIndicator);
        supplierNameText.addEventListener('input', updateSupplierRequiredIndicator);
        updateSupplierRequiredIndicator(); // Estado inicial


        let itemIndex = 0;

        function addNewItem() {
            const newItemRow = document.createElement('div');
            // Reemplazar placeholders en la plantilla para los nombres de array correctos
            newItemRow.innerHTML = itemTemplate.replace(/items\[\]/g, 'items[' + itemIndex + ']');
            itemsContainer.appendChild(newItemRow.firstElementChild); // Añade el div.row, no el div wrapper de la plantilla
            itemIndex++;
            attachEventListenersToLastRow();
            updateGrandTotal();
        }

        function calculateSubtotal(row) {
            const quantityInput = row.querySelector('.quantity-input');
            const unitCostInput = row.querySelector('.unitcost-input');
            const subtotalDisplay = row.querySelector('.subtotal-display');

            const quantity = parseFloat(quantityInput.value) || 0;
            const unitCost = parseFloat(unitCostInput.value) || 0;
            const subtotal = quantity * unitCost;

            subtotalDisplay.value = 'S/ ' + subtotal.toFixed(2);
            updateGrandTotal();
        }

        function updateGrandTotal() {
            let total = 0;
            itemsContainer.querySelectorAll('.item-row').forEach(function(row) {
                const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
                const unitCost = parseFloat(row.querySelector('.unitcost-input').value) || 0;
                total += quantity * unitCost;
            });
            grandTotalSpan.textContent = total.toFixed(2);
        }

        function attachEventListenersToLastRow() {
            const lastRow = itemsContainer.querySelector('.item-row:last-child');
            if (!lastRow) return;

            const productSelect = lastRow.querySelector('.product-select');
            const quantityInput = lastRow.querySelector('.quantity-input');
            const unitCostInput = lastRow.querySelector('.unitcost-input');
            const removeItemBtn = lastRow.querySelector('.removeItemBtn');

            productSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const cost = selectedOption.dataset.cost || '0.00';
                unitCostInput.value = parseFloat(cost).toFixed(2);
                calculateSubtotal(lastRow);
            });

            quantityInput.addEventListener('input', function() {
                calculateSubtotal(lastRow);
            });
            unitCostInput.addEventListener('input', function() {
                calculateSubtotal(lastRow);
            });
            removeItemBtn.addEventListener('click', function() {
                this.closest('.item-row').remove();
                updateGrandTotal();
            });
        }

        addItemBtn.addEventListener('click', addNewItem);

        // Añadir al menos una fila al cargar la página
        addNewItem(); 
    });
</script>
<?= $this->endSection() ?>
