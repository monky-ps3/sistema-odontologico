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
                    <p class="card-text"><strong>Nombre:</strong> <?= esc($paciente['nombre']) ?></p>
                    <p class="card-text"><strong>Apellido:</strong> <?= esc($paciente['apellido']) ?></p>
                    <p class="card-text"><strong>DNI:</strong> <?= esc($paciente['dni']) ?></p>
                    <p class="card-text"><strong>Género:</strong> <?= esc(ucfirst($paciente['genero'])) ?></p>

                    <h5 class="card-title mt-4">Contacto</h5>
                    <p class="card-text"><strong>Teléfono:</strong> <?= esc($paciente['telefono']) ?></p>
                    <p class="card-text"><strong>Email:</strong> <?= esc($paciente['email']) ?></p>

                    <h5 class="card-title mt-4">Historial Médico</h5>
                    <p class="card-text"><strong>Alergias:</strong> <?= esc($paciente['alergias']) ?></p>
                    <p class="card-text"><strong>Enfermedades Preexistentes:</strong> <?= esc($paciente['enfermedades_preexistentes']) ?></p>

                    <div class="mt-4">
                        <a href="<?= site_url('pacientes/edit/' . $paciente['id']) ?>" class="btn btn-primary">Editar</a>
                        <a href="<?= site_url('pacientes') ?>" class="btn btn-secondary">Volver</a>
                    </div>
                </div>
            </div>
        </div>


    </div>



</div>
</div>



<?php echo $this->endSection() ?>