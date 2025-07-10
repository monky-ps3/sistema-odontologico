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
                    <h5 class="card-title">Datos de la Cita</h5>

                    <p class="card-text"><strong>Paciente:</strong> <?= esc($cita->nombre_paciente) ?></p>
                    <p class="card-text"><strong>Odontólogo:</strong> <?= esc($cita->nombre_odontologo) ?></p>
                    <p class="card-text"><strong>Fecha:</strong> <?= esc($cita->fecha) ?></p>
                    <p class="card-text"><strong>Hora:</strong> <?= esc($cita->hora) ?></p>
                    <p class="card-text"><strong>Motivo:</strong> <?= esc($cita->motivo) ?></p>
                    <p class="card-text"><strong>Estado:</strong>
                        <span class="badge 
                <?= $cita->estado === 'pendiente' ? 'bg-warning' : ($cita->estado === 'atendida' ? 'bg-success' : 'bg-danger') ?>">
                            <?= ucfirst($cita->estado) ?>
                        </span>
                    </p>

                    <div class="mt-4">
                        <a href="<?= site_url('citas/editar/' . $cita->id) ?>" class="btn btn-primary">Editar</a>
                        <a href="<?= site_url('citas') ?>" class="btn btn-secondary">Volver</a>
                    </div>
                </div>
            </div>
        </div>


    </div>



</div>
</div>



<?php echo $this->endSection() ?>