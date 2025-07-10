<?= $this->extend('Layouts/dashboard') ?>
<?= $this->section('header') ?>
<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>
<?php echo view('partials/_form-error') ?>

<form action="<?= base_url('odontologos/create') ?>" method="post">

    <h5>Cuenta de usuario</h5>

    <div class="row">
        <div class="col-12 col-md-6 mb-3">
            <label class="form-label" for="username">Usuario</label>
            <input class="form-control" type="text" name="username" id="username" placeholder="usuario" value="<?= old('username') ?>">
        </div>

        <div class="col-12 col-md-6 mb-3">
            <label class="form-label" for="email">Correo</label>
            <input class="form-control" type="email" name="email" id="email" placeholder="correo" value="<?= old('email') ?>">
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-6 mb-3">
            <label>Contraseña</label>
            <input type="password" name="password" class="form-control" required>
        </div>
    </div>

    <hr>
    <h5>Datos del odontólogo</h5>

    <div class="row">
        <div class="col-12 col-md-6 mb-3">
            <label class="form-label" for="nombre">Nombre</label>
            <input class="form-control" type="text" name="nombre" id="nombre" placeholder="nombre" value="<?= old('nombre') ?>">
        </div>

        <div class="col-12 col-md-6 mb-3">
            <label class="form-label" for="apellido">Apellido</label>
            <input class="form-control" type="text" name="apellido" id="apellido" placeholder="apellido" value="<?= old('apellido') ?>">
        </div>

        <div class="col-12 col-md-6 mb-3">
            <label class="form-label" for="cedula">Cedula</label>
            <input class="form-control" type="text" name="cedula" id="cedula" placeholder="cedula" value="<?= old('cedula') ?>">
        </div>
        <div class=" col-12 col-md-6 mb-3">
            <label class="form-label" for="especialidad">Especialidad</label>
            <input class="form-control" type="text" name="especialidad" id="especialidad" placeholder="especialidad" value="<?= old('especialidad') ?>">
        </div>
        <div class=" col-12 col-md-6 mb-3">
            <label class="form-label" for="telefono">Teléfono</label>
            <input class="form-control" type="text" name="telefono" id="telefono" placeholder="telefono" value="<?= old('telefono') ?>">
        </div>

        <div class=" col-12 col-md-6 mb-3">
            <label class="form-label" for="fecha_nacimiento">Fecha Nacimiento</label>
            <input class="form-control" type="text" name="fecha_nacimiento" id="fecha_nacimiento" placeholder="fecha_nacimiento" value="<?= old('fecha_nacimiento') ?>">
        </div>
        <div class="row">
            <label class="form-label" for="genero">Género</label>
            <select class="form-control" name="genero" id="genero">
                <option value="masculino" <?= old('genero') == 'masculino' ? 'selected' : '' ?>>Masculino</option>
                <option value="femenino" <?= old('genero') == 'femenino' ? 'selected' : '' ?>>Femenino</option>
                <option value="otros" <?= old('genero') == 'otros' ? 'selected' : '' ?>>Otros</option>
            </select>

        </div>
    </div>

    <h5>Datos opcionales</h5>

    <div class="row">
        <div class="col-12 col-md-6 mb-3">
            <label class="form-label" for="direccion">Dirección</label>
            <input class="form-control" type="text" name="direccion" id="direccion" placeholder="direccion" value="<?= old('direccion') ?>">
        </div>


    </div>

    <button class=" btn btn-primary" type="submit">Enviar</button>
</form>

<?= $this->endSection() ?>