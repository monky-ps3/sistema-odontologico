<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('header') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>
<div class="row">
    <!-- Total Pacientes -->
    <div class="col-md-4">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Pacientes registrados</h5>
                <p class="card-text fs-3"><?= esc($totalPacientes) ?></p>
            </div>
        </div>
    </div>

    <!-- Total Citas -->
    <div class="col-md-4">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Citas totales</h5>
                <p class="card-text fs-3"><?= esc($totalCitas) ?></p>
            </div>
        </div>
    </div>

    <!-- Total Odontólogos -->
    <div class="col-md-4">
        <div class="card text-white bg-info mb-3">
            <div class="card-body">
                <h5 class="card-title">Odontólogos registrados</h5>
                <p class="card-text fs-3"><?= esc($totalOdontologos) ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Puedes agregar más tarjetas o gráficas aquí -->
<!-- Tabla de Citas de Hoy -->
<div class="card mb-4">
    <div class="card-header">
        Citas para hoy
    </div>
    <div class="card-body">
        <?php if (count($citasHoy) > 0): ?>
            <div class="table-responsive">
                <table class="table table-sm table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Paciente</th>
                            <th>Hora</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($citasHoy as $cita): ?>
                            <tr>
                                <td><?= esc($cita->nombre_paciente) ?></td>
                                <td><?= date('h:i A', strtotime($cita->hora)) ?></td>
                                <td><span class="badge bg-secondary"><?= ucfirst($cita->estado) ?></span></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-muted">No hay citas programadas para hoy.</p>
        <?php endif ?>
    </div>
</div>

<?= $this->endSection() ?>
