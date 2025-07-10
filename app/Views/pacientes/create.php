<?php echo $this->extend('Layouts/dashboard') ?>
<?php echo $this->section('header') ?>
<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

<?php echo $this->endSection() ?>
<?php echo $this->section('contenido') ?>
<?php echo view('partials/_form-error') ?>
<form action="<?= base_url('pacientes/create') ?>" method="post">

    <div class="row">
        <div class="col">
            <label class="form-label" for="nombre">Nombre</label>
            <input class="form-control" type="text" name="nombre" id="nombre" placeholder="nombre" value="<?= old('nombre') ?>">
        </div>
        <div class="col">
            <label class="form-label" for="apellido">Apellido</label>
            <input class="form-control" type="text" name="apellido" id="apellido" placeholder="apellido" value="<?= old('apellido') ?>">

        </div>
    </div>
    <div class="row">
        <div class="col">
            <label class="form-label" for="fecha_nacimiento">fecha Nacimiento</label>
            <input class="form-control" type="text" name="fecha_nacimiento" id="fecha_nacimiento" placeholder="fecha_nacimiento" value="<?= old('fecha_nacimiento') ?> ">
        </div>
        <!-- <div class="col">
            <label class="form-label" for="genero">Genero</label>
            <select class="form-control" name="genero" id="genero">
                <option value="masculino">Masculino</option>
                <option value="femenino">Femenino</option>
                <option value="Otros">Otros</option>


            </select>
        </div> -->

        <div class="col">
            <label class="form-label" for="genero">Género</label>
            <select class="form-control" name="genero" id="genero">
                <option value="masculino" <?= old('genero') == 'masculino' ? 'selected' : '' ?>>Masculino</option>
                <option value="femenino" <?= old('genero') == 'femenino' ? 'selected' : '' ?>>Femenino</option>
                <option value="Otros" <?= old('genero') == 'Otros' ? 'selected' : '' ?>>Otros</option>
            </select>
        </div>
        <div class="col">
            <label class="form-label" for="curp">Curp</label>
            <input class="form-control" type="text" name="curp" id="curp" placeholder="curp">
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label class="form-label" for="telefono">Telefono</label>
            <input class="form-control" type="text" name="telefono" id="telefono" placeholder="telefono">
        </div>
        <div class="col">
            <label class="form-label" for="email">Email</label>
            <input class="form-control" type="text" name="email" id="email" placeholder="email">
        </div>
    </div>


    <div class="mb-3">
        <label class="form-label" for="alergias">Alergias</label>
        <input class="form-control" type="text" name="alergias" id="alergias" placeholder="alergias">


    </div>
    <div class="mb-3">
        <label class="form-label" for="enfermedades_preexistentes">Enfermedades preexistentes</label>
        <input class="form-control" type="text" name="enfermedades_preexistentes" id="enfermedades_preexistentes" placeholder="enfermedades preexistentes">


    </div>

    <button class="btn btn-primary" type="submit">Enviar</button>
</form>
<?php echo $this->endSection() ?>