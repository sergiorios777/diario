<?= $this->extend('layouts/app_layout') ?>

<?= $this->section('title') ?>
<?= esc($title ?? 'Formulario de Proveedor') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h1><?= esc($title ?? 'Formulario de Proveedor') ?></h1>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($validation) && $validation->getErrors()): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Por favor, corrige los siguientes errores:</strong>
            <ul>
            <?php foreach ($validation->getErrors() as $error) : ?>
                <li><?= esc($error) ?></li>
            <?php endforeach ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form action="<?= ($supplier->id ?? null) ? site_url('suppliers/' . $supplier->id) : site_url('suppliers') ?>" method="post">
        <?= csrf_field() ?>

        <?php if ($supplier->id ?? null): ?>
            <input type="hidden" name="_method" value="PUT"> <!-- Para simular PUT con resource routes -->
        <?php endif; ?>

        <div class="mb-3">
            <label for="name" class="form-label">Nombre/Razón Social <span class="text-danger">*</span></label>
            <input type="text" class="form-control <?= (isset($validation) && $validation->hasError('name')) ? 'is-invalid' : '' ?>"
                   id="name" name="name" value="<?= old('name', esc($supplier->name ?? '')) ?>" required>
            <?php if (isset($validation) && $validation->hasError('name')): ?>
                <div class="invalid-feedback">
                    <?= $validation->getError('name') ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="ruc" class="form-label">RUC (opcional)</label>
            <input type="text" class="form-control <?= (isset($validation) && $validation->hasError('ruc')) ? 'is-invalid' : '' ?>"
                   id="ruc" name="ruc" value="<?= old('ruc', esc($supplier->ruc ?? '')) ?>">
            <?php if (isset($validation) && $validation->hasError('ruc')): ?>
                <div class="invalid-feedback">
                    <?= $validation->getError('ruc') ?>
                </div>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> <?= ($supplier->id ?? null) ? 'Actualizar' : 'Guardar' ?> Proveedor</button>
        <a href="<?= site_url('suppliers') ?>" class="btn btn-secondary"><i class="fas fa-times"></i> Cancelar</a>
    </form>
</div>
<?= $this->endSection() ?>
