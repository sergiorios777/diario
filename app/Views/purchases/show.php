<?= $this->extend('layouts/app_layout') ?>

<?= $this->section('title') ?>
    Detalle de Compra #<?= esc($purchase['id']) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Detalle de Compra #<?= esc($purchase['id']) ?></h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="<?= site_url('purchases') ?>" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left-circle"></i> Volver a Compras
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <h4>Información General</h4>
            <p><strong>Fecha:</strong> <?= esc(date('d/m/Y', strtotime($purchase['purchase_date']))) ?></p>
            <p><strong>Proveedor:</strong> <?= esc($purchase['supplier_name'] ?? ($purchase['supplier_name_text'] ?? 'N/A')) ?></p>
            <p><strong>Referencia:</strong> <?= esc($purchase['reference_no'] ?? '-') ?></p>
            <p><strong>Notas:</strong> <?= nl2br(esc($purchase['notes'] ?? '-')) ?></p>
            <p><strong>Monto Total:</strong> S/ <?= esc(number_format($purchase['total_amount'], 2)) ?></p>
        </div>
    </div>

    <h4 class="mt-4">Productos Comprados</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>Código Producto</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Costo Unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($items)): ?>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?= esc($item['product_code']) ?></td>
                            <td><?= esc($item['product_name']) ?></td>
                            <td><?= esc(number_format($item['quantity'], 2)) ?></td>
                            <td>S/ <?= esc(number_format($item['unit_cost'], 2)) ?></td>
                            <td>S/ <?= esc(number_format($item['subtotal'], 2)) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No hay productos en esta compra.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?= $this->endSection() ?>
