<?php echo $this->extend('Layouts/dashboard') ?>
<?php echo $this->section('header') ?>
<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

<?php echo $this->endSection() ?>
<?php echo $this->section('contenido') ?>
<?php echo view('partials/_form-error') ?>
<form action="<?= base_url('citas/update/' . $cita->id) ?>" method="post">
    <?= csrf_field() ?>

    <div class="mb-3">
        <label for="paciente_id" class="form-label">Paciente</label>
        <select name="paciente_id" id="paciente_id" class="form-select" required>
            <option value="">Seleccionar...</option>
            <?php foreach ($pacientes as $p): ?>
                <option value="<?= $p->id ?>" <?= old('paciente_id', $cita->paciente_id) == $p->id ? 'selected' : '' ?>>
                    <?= esc($p->nombre . ' ' . $p->apellido) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="odontologo_id" class="form-label">Odontólogo</label>
        <select name="odontologo_id" id="odontologo_id" class="form-select" required>
            <option value="">Seleccionar...</option>
            <?php foreach ($odontologos as $o): ?>
                <option value="<?= $o->id ?>" <?= old('odontologo_id', $cita->odontologo_id) == $o->id ? 'selected' : '' ?>>
                    <?= esc($o->nombre . ' ' . $o->apellido) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="fecha" class="form-label">Fecha</label>
        <input type="date" name="fecha" id="fecha" class="form-control"
            value="<?= old('fecha', $cita->fecha) ?>" required>
    </div>

    <div class="mb-3">
        <label for="hora" class="form-label">Hora</label>
        <input type="time" name="hora" id="hora" class="form-control"
            value="<?= old('hora', $cita->hora) ?>" required>
    </div>

    <div class="mb-3">
        <label for="motivo" class="form-label">Motivo</label>
        <textarea name="motivo" id="motivo" class="form-control" rows="3"><?= old('motivo', $cita->motivo) ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Actualizar cita</button>
    <a href="<?= base_url('citas') ?>" class="btn btn-secondary">Cancelar</a>
</form>
<?php echo $this->endSection() ?>