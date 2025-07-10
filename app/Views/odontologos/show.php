<?php echo $this->extend('Layouts/dashboard') ?>
<?php echo $this->section('header') ?>

<?php echo $this->endSection() ?>
<?php echo $this->section('contenido') ?>


<div class="card">
    <div class="card-body">



        <div class="container">
            <h2><?= esc($title) ?></h2>

            <div class="card">
                     <div class="card-body">
                    <h5 class="card-title">Información Personal</h5>
                    <p class="card-text"><strong>Nombre:</strong> <?= esc($odontologo->nombre) ?></p>
                    <p class="card-text"><strong>Apellido:</strong> <?= esc($odontologo->apellido) ?></p>
                    <p class="card-text"><strong>Género:</strong> <?= esc(ucfirst($odontologo->genero)) ?></p>

                    <h5 class="card-title mt-4">Contacto</h5>
                    <p class="card-text"><strong>Teléfono:</strong> <?= esc($odontologo->telefono) ?></p>
                    <p class="card-text"><strong>Dirección:</strong> <?= esc($odontologo->direccion) ?></p>
                    <p class="card-text"><strong>Email:</strong> <?= esc($odontologo->email) ?></p>
                    <p class="card-text"><strong>Username:</strong> <?= esc($odontologo->username) ?></p>

                    <h5 class="card-title mt-4">Datos profesionales</h5>
                    <p class="card-text"><strong>Cédula:</strong> <?= esc($odontologo->cedula) ?></p>
                    <p class="card-text"><strong>Especialidad:</strong> <?= esc($odontologo->especialidad) ?></p>
                    <p class="card-text"><strong>Fecha de Nacimiento:</strong> <?= esc($odontologo->fecha_nacimiento) ?></p>
                </div>
                <div class="card-footer text-end">
                    <a href="<?= base_url('odontologos') ?>" class="btn btn-secondary">Volver al listado</a>
                </div>
            </div>
        </div>


    </div>



</div>
</div>



<?php echo $this->endSection() ?>