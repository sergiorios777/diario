<?= $this->extend('layouts/app_layout') ?>

<?= $this->section('title') ?>
    <?= isset($customer) ? 'Editar Cliente' : 'Registrar Nuevo Cliente' ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"><?= isset($customer) ? 'Editar Cliente: ' . esc($customer['name']) : 'Registrar Nuevo Cliente' ?></h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="<?= site_url('customers') ?>" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left-circle"></i> Volver a Clientes
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

    <form action="<?= isset($customer) ? site_url('customers/update/' . $customer['id']) : site_url('customers/create') ?>" method="post">
        <?= csrf_field() ?>
        <?php if (isset($customer)): ?>
            <?php endif; ?>

        <div class="row g-3">
            <div class="col-md-12">
                <label for="name" class="form-label">Nombre / Razón Social <span class="text-danger">*</span></label>
                <input type="text" class="form-control <?= session('errors.name') ? 'is-invalid' : '' ?>" id="name" name="name" value="<?= old('name', $customer['name'] ?? '') ?>" required>
                <?php if (session('errors.name')): ?>
                    <div class="invalid-feedback"><?= esc(session('errors.name')) ?></div>
                <?php endif; ?>
            </div>

            <div class="col-md-6">
                <label for="document_number" class="form-label">DNI / RUC (Opcional)</label>
                <input type="text" class="form-control <?= session('errors.document_number') ? 'is-invalid' : '' ?>" id="document_number" name="document_number" value="<?= old('document_number', $customer['document_number'] ?? '') ?>">
                <?php if (session('errors.document_number')): ?>
                    <div class="invalid-feedback"><?= esc(session('errors.document_number')) ?></div>
                <?php endif; ?>
            </div>

            <div class="col-md-6">
                <label for="email" class="form-label">Correo Electrónico (Opcional)</label>
                <input type="email" class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>" id="email" name="email" value="<?= old('email', $customer['email'] ?? '') ?>">
                 <?php if (session('errors.email')): ?>
                    <div class="invalid-feedback"><?= esc(session('errors.email')) ?></div>
                <?php endif; ?>
            </div>

            <div class="col-md-6">
                <label for="phone" class="form-label">Teléfono (Opcional)</label>
                <input type="tel" class="form-control <?= session('errors.phone') ? 'is-invalid' : '' ?>" id="phone" name="phone" value="<?= old('phone', $customer['phone'] ?? '') ?>">
                <?php if (session('errors.phone')): ?>
                    <div class="invalid-feedback"><?= esc(session('errors.phone')) ?></div>
                <?php endif; ?>
            </div>

            <div class="col-12">
                <label for="address" class="form-label">Dirección (Opcional)</label>
                <textarea class="form-control" id="address" name="address" rows="3"><?= old('address', $customer['address'] ?? '') ?></textarea>
            </div>
        </div>

        <hr class="my-4">

        <button class="btn btn-primary btn-lg" type="submit"><?= isset($customer) ? 'Actualizar Cliente' : 'Guardar Cliente' ?></button>
    </form>

<?= $this->endSection() ?>
