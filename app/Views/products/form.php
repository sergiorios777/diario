<?= $this->extend('layouts/app_layout') ?>

<?= $this->section('title') ?>
    <?= isset($product) ? 'Editar Producto' : 'Registrar Nuevo Producto' ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"><?= isset($product) ? 'Editar Producto: ' . esc($product['name']) : 'Registrar Nuevo Producto' ?></h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="<?= site_url('products') ?>" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left-circle"></i> Volver a Productos
            </a>
        </div>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
            <?php if (session()->get('errors')): ?>
                <ul>
                    <?php foreach (session()->get('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    <?php endif; ?>


    <form action="<?= isset($product) ? site_url('products/update/' . $product['id']) : site_url('products/create') ?>" method="post">
        <?= csrf_field() ?>
        <?php if (isset($product)): ?>
            <input type="hidden" name="_method" value="POST"> <?php endif; ?>

        <div class="row g-3">
            <div class="col-md-6">
                <label for="code" class="form-label">Código del Producto <span class="text-danger">*</span></label>
                <input type="text" class="form-control <?= (isset(session('errors')['code'])) ? 'is-invalid' : '' ?>" id="code" name="code" value="<?= old('code', $product['code'] ?? '') ?>" required>
                <?php if (isset(session('errors')['code'])): ?>
                    <div class="invalid-feedback"><?= esc(session('errors')['code']) ?></div>
                <?php endif; ?>
            </div>

            <div class="col-md-6">
                <label for="name" class="form-label">Nombre del Producto <span class="text-danger">*</span></label>
                <input type="text" class="form-control <?= (isset(session('errors')['name'])) ? 'is-invalid' : '' ?>" id="name" name="name" value="<?= old('name', $product['name'] ?? '') ?>" required>
                <?php if (isset(session('errors')['name'])): ?>
                    <div class="invalid-feedback"><?= esc(session('errors')['name']) ?></div>
                <?php endif; ?>
            </div>

            <div class="col-12">
                <label for="description" class="form-label">Descripción</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?= old('description', $product['description'] ?? '') ?></textarea>
            </div>

            <div class="col-md-6">
                <label for="unit_of_measure" class="form-label">Unidad de Medida <span class="text-danger">*</span></label>
                <input type="text" class="form-control <?= (isset(session('errors')['unit_of_measure'])) ? 'is-invalid' : '' ?>" id="unit_of_measure" name="unit_of_measure" value="<?= old('unit_of_measure', $product['unit_of_measure'] ?? 'Unidad') ?>" required list="unitsList">
                <datalist id="unitsList">
                    <option value="Unidad">
                    <option value="Caja">
                    <option value="Paquete">
                    <option value="Kg">
                    <option value="Lt">
                    <option value="Metro">
                </datalist>
                <?php if (isset(session('errors')['unit_of_measure'])): ?>
                    <div class="invalid-feedback"><?= esc(session('errors')['unit_of_measure']) ?></div>
                <?php endif; ?>
            </div>

            <div class="col-md-6">
                <label for="category_name" class="form-label">Categoría</label>
                <input type="text" class="form-control <?= (isset(session('errors')['category_name'])) ? 'is-invalid' : '' ?>" id="category_name" name="category_name" value="<?= old('category_name', $product['category_name'] ?? '') ?>">
                <?php if (isset(session('errors')['category_name'])): ?>
                    <div class="invalid-feedback"><?= esc(session('errors')['category_name']) ?></div>
                <?php endif; ?>
            </div>

            <div class="col-md-6">
                <label for="sale_price" class="form-label">Precio Venta Estándar <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text">S/</span>
                    <input type="number" step="0.01" class="form-control <?= (isset(session('errors')['sale_price'])) ? 'is-invalid' : '' ?>" id="sale_price" name="sale_price" value="<?= old('sale_price', $product['sale_price'] ?? '0.00') ?>" required>
                </div>
                 <?php if (isset(session('errors')['sale_price'])): ?>
                    <div class="invalid-feedback d-block"><?= esc(session('errors')['sale_price']) ?></div>
                <?php endif; ?>
            </div>

            <div class="col-md-6">
                <label for="cost_price" class="form-label">Costo Unitario Estándar <span class="text-danger">*</span></label>
                 <div class="input-group">
                    <span class="input-group-text">S/</span>
                    <input type="number" step="0.01" class="form-control <?= (isset(session('errors')['cost_price'])) ? 'is-invalid' : '' ?>" id="cost_price" name="cost_price" value="<?= old('cost_price', $product['cost_price'] ?? '0.00') ?>" required>
                </div>
                <?php if (isset(session('errors')['cost_price'])): ?>
                    <div class="invalid-feedback d-block"><?= esc(session('errors')['cost_price']) ?></div>
                <?php endif; ?>
            </div>

            <div class="col-md-6">
                <label for="initial_lot" class="form-label">Lote Inicial (Informativo)</label>
                <input type="text" class="form-control" id="initial_lot" name="initial_lot" value="<?= old('initial_lot', $product['initial_lot'] ?? '') ?>">
            </div>

            </div>

        <hr class="my-4">

        <button class="btn btn-primary btn-lg" type="submit"><?= isset($product) ? 'Actualizar Producto' : 'Guardar Producto' ?></button>
    </form>

<?= $this->endSection() ?>
