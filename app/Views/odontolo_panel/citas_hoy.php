<?= $this->extend('Layouts/dashboard') ?>

<?= $this->section('contenido') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= esc($title) ?></h1>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif ?>

    <?php if (count($citas) > 0): ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Paciente</th>
                        <th>Hora</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($citas as $cita): ?>
                        <tr>
                            <td><?= esc($cita->nombre_paciente) ?></td>
                            <td><?= date('h:i A', strtotime($cita->hora)) ?></td>
                            <td>
                                <?php
                                    $badgeClass = match($cita->estado) {
                                        'pendiente' => 'warning',
                                        'atendida' => 'success',
                                        'cancelada' => 'danger',
                                        default => 'secondary'
                                    };
                                ?>
                                <span class="badge bg-<?= $badgeClass ?>">
                                    <?= ucfirst($cita->estado) ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($cita->estado === 'pendiente'): ?>
                                    <a href="<?= base_url('historial/create/' . $cita->id) ?>" class="btn btn-sm btn-success">
                                        <i class="fas fa-stethoscope me-1"></i> Atender
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">Ya atendida</span>
                                <?php endif ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">No tienes citas programadas para hoy.</div>
    <?php endif ?>
</div>
<?= $this->endSection() ?>