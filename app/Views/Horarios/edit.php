<?php echo $this->extend('Layouts/dashboard') ?>
<?php echo $this->section('header') ?>
<h2 class="h3 mb-4 text-gray-800"><?= $title ?></h2>

<?php echo $this->endSection() ?>
<?php echo $this->section('contenido') ?>
<?php echo view('partials/_form-error') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif ?>

<form action="<?= base_url('horarios/update/' . $horario->id) ?>" method="post">
    <?= csrf_field() ?>

    <div class="mb-3">
        <label class="form-label">Odontólogo</label>
        <p class="form-control-plaintext"><?= esc($odontologo->nombre . ' ' . $odontologo->apellido) ?></p>
    </div>

    <div class="mb-3">
        <label class="form-label">Día de la semana</label>
        <input type="text" class="form-control" value="<?= ucfirst($horario->dia_semana) ?>" readonly>
        <input type="hidden" name="dia_semana" value="<?= $horario->dia_semana ?>">
    </div>

    <div class="mb-3">
      <?php
        $horaSeleccionadaFin = old('hora_inicio') ?? date('H:i', strtotime($horario->hora_inicio));
        ?>
         <label for="hora_inicio" class="form-label">Hora fin</label>
        <select name="hora_inicio" id="hora_inicio" class="form-control" required>
            <option value="">Selecciona hora</option>
            <?php foreach ($horas as $valor => $texto): ?>
                <option value="<?= $valor ?>" <?= $horaSeleccionadaFin === $valor ? 'selected' : '' ?>>
                    <?= $texto ?>
                </option>
            <?php endforeach ?>
        </select>
    </div>

    <div class="mb-3">
        <?php
        $horaSeleccionadaFin = old('hora_fin') ?? date('H:i', strtotime($horario->hora_fin));
        ?>
         <label for="hora_fin" class="form-label">Hora fin</label>
        <select name="hora_fin" id="hora_fin" class="form-control" required>
            <option value="">Selecciona hora</option>
            <?php foreach ($horas as $valor => $texto): ?>
                <option value="<?= $valor ?>" <?= $horaSeleccionadaFin === $valor ? 'selected' : '' ?>>
                    <?= $texto ?>
                </option>
            <?php endforeach ?>
        </select>
    </div>

    <button class="btn btn-primary" type="submit">Actualizar Horario</button>
</form>
<?php echo $this->endSection() ?>