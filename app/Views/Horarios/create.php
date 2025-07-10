<?php echo $this->extend('Layouts/dashboard') ?>
<?php echo $this->section('header') ?>
<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

<?php echo $this->endSection() ?>
<?php echo $this->section('contenido') ?>
<?php echo view('partials/_form-error') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif ?>

<form action="<?= base_url('horarios/create/' . $odontologos->id) ?>" method="post">
    <?= csrf_field() ?>


    <input type="hidden" name="odontologo_id" value="<?= $odontologos->id ?>">

    <div class="mb-3 d-flex align-items-center">
        <label class="form-label mb-0 me-2">Odontólogo:</label>
        <span><?= esc($odontologos->nombre . ' ' . $odontologos->apellido) ?></span>
    </div>
    <!-- <select name="dia" id="dia" class="form-control" required>
        <option value="">Seleccione un día</option>
        <option value="lunes" <?= old('dia') == 'lunes' ? 'selected' : '' ?>>Lunes</option>
        <option value="martes" <?= old('dia') == 'martes' ? 'selected' : '' ?>>Martes</option>
        <option value="miércoles" <?= old('dia') == 'miércoles' ? 'selected' : '' ?>>Miércoles</option>
        <option value="jueves" <?= old('dia') == 'jueves' ? 'selected' : '' ?>>Jueves</option>
        <option value="viernes" <?= old('dia') == 'viernes' ? 'selected' : '' ?>>Viernes</option>
        <option value="sábado" <?= old('dia') == 'sábado' ? 'selected' : '' ?>>Sábado</option>
        <option value="domingo" <?= old('dia') == 'domingo' ? 'selected' : '' ?>>Domingo</option>
    </select> -->


    <div class="mb-3">
        <label for="dia_semana" class="form-label">Día de la semana</label>
        <select name="dia_semana" id="dia_semana" class="form-control" required>
            <option value="">Seleccione un día</option>
            <?php

            foreach ($dias as $d):  $ocupado = in_array($d, $diasOcupados);
            ?>

                <option value="<?= $d ?>" <?= old('dia_semana') == $d ? 'selected' : '' ?>
                    <?= $ocupado ? 'disabled' : '' ?>>
                    <?= ucfirst($d) . ($ocupado ? ' (ocupado)' : ' (disponible)') ?>
                </option>
            <?php endforeach ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="hora_inicio" class="form-label">Hora de inicio</label>
        <select name="hora_inicio" id="hora_inicio" class="form-control" required>
            <option value="">Selecciona hora</option>
            <?php foreach ($horas as $valor => $texto): ?>
                <option value="<?= $valor ?>" <?= old('hora_inicio') === $valor ? 'selected' : '' ?>><?= $texto ?></option>
            <?php endforeach ?>
        </select>
    </div>


    <div class="mb-3">
        <label for="hora_fin" class="form-label">Hora de fin</label>
        <select name="hora_fin" id="hora_fin" class="form-control" required>
            <option value="">Selecciona hora</option>
            <?php foreach ($horas as $valor => $texto): ?>
                <option value="<?= $valor ?>" <?= old('hora_fin') === $valor ? 'selected' : '' ?>><?= $texto ?></option>
            <?php endforeach ?>
        </select>
    </div>



    <a href="<?= base_url('horarios/odontologo/' . $odontologos->id) ?>" class="btn btn-sm btn-primary">
        <i class="fas fa-edit">Volver</i>
    </a>

    <button class="btn btn-primary" type="submit">Guardar Horario</button>
</form>
<?php echo $this->endSection() ?>