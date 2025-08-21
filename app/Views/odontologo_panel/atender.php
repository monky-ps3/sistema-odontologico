
<?= $this->extend('Layouts/dashboard') ?>

<?= $this->section('contenido') ?>
<div class="container-fluid">


    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif ?>



<div class="card mb-3">
    <div class="card-body">
          <h4>Atender Cita</h4>
        <p><strong>Paciente:</strong> <?= esc($cita->nombre_paciente) ?></p>
        <p><strong>Fecha:</strong> <?= esc($cita->fecha) ?> <?= esc($cita->hora) ?></p>
        <p><strong>Motivo:</strong> <?= esc($cita->motivo) ?></p>
    </div>
</div>
<form action="<?= site_url('citas/guardarAtencion/' . $cita->id) ?>" method="post">
    <?= csrf_field() ?>

    <!-- Historial clínico -->
    <div class="mb-3">
        <label for="diagnostico" class="form-label">Diagnóstico</label>
        <textarea name="diagnostico" id="diagnostico" class="form-control" rows="3" required></textarea>
    </div>

    <div class="mb-3">
        <label for="tratamiento" class="form-label">Tratamiento realizado</label>
        <textarea name="tratamiento" id="tratamiento" class="form-control" rows="3" required></textarea>
    </div>

    <!-- Receta opcional -->
    <div class="mb-3">
        <label class="form-label">¿Desea registrar receta?</label>
        <small class="text-muted d-block">Si no se llena, no se guardará receta.</small>
    </div>

    <div class="mb-3">
        <label for="medicamento" class="form-label">Medicamento</label>
        <input type="text" name="medicamento" id="medicamento" class="form-control" placeholder="Nombre del medicamento">
    </div>

    <div class="mb-3">
        <label for="dosis" class="form-label">Dosis</label>
        <input type="text" name="dosis" id="dosis" class="form-control" placeholder="Ej: 1 tableta cada 8 horas">
    </div>

    <button type="submit" class="btn btn-primary">Guardar atención</button>
    <a href="<?= site_url('citas') ?>" class="btn btn-secondary">Cancelar</a>
</form>

<?= $this->endSection() ?>