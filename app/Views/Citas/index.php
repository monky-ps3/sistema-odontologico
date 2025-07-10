<?= $this->extend('Layouts/dashboard') ?>

<?= $this->section('contenido')  ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif ?>

            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Listado de Citas</h6>
                    <a href="<?php echo  base_url() ?>odontologos" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nueva Cita
                    </a>
                </div>


                <!-- Tabs de navegación -->
                <ul class="nav nav-tabs mb-3" id="tabFiltroCitas" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#todas">Todas</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#pendientes">Pendientes</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#canceladas">Canceladas</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#hoy">Hoy</button>
                    </li>
                </ul>




                <div class="card-body">

                    <!-- Contenido de las pestañas -->
                    <div class="tab-content">

                        <!-- Todas las citas -->
                        <div class="tab-pane fade show active" id="todas">
                            <?php if (count($citas)): ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Paciente</th>
                                                <th>Fecha</th>
                                                <th>Hora</th>
                                                <th>Odontologo</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                                <th>Estado Cita</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($citas as $cita): ?>
                                                <tr>
                                                    <td><?= esc($cita->nombre_paciente) ?></td>
                                                    <td><?= esc($cita->fecha) ?></td>
                                                    <td><?= esc($cita->hora) ?></td>
                                                    <?php
                                                    $prefijo = ($cita->genero_odontologo == 'femenino') ? 'Dra.' : (($cita->genero_odontologo == 'masculino') ? 'Dr.' : '');
                                                    $nombreOdontologo = $prefijo . ' ' . $cita->nombre_odontologo;
                                                    ?>
                                                    <td><?= esc($nombreOdontologo) ?></td>
                                                    <td><span class="badge bg-secondary"><?= ucfirst($cita->estado) ?></span></td>
                                                    <td>

                                                        <div class="d-flex flex-wrap gap-1">
                                                            <a href="<?= base_url('citas/show/' . $cita->id) ?>" class="btn btn-sm btn-primary">
                                                                <i class="fas fa-eye me-1"></i> Ver
                                                            </a>

                                                            <a href="<?= base_url('citas/editar/' . $cita->id) ?>" class="btn btn-sm btn-info">
                                                                <i class="fas fa-edit me-1"></i> Editar
                                                            </a>
                                                        </div>




                                                    </td>
                                                    <td>

                                                        <form action="<?= base_url('citas/cambiarestado/' . $cita->id) ?>" method="post" class="d-inline">
                                                            <?= csrf_field() ?>
                                                            <select name="estado" class="form-select form-select-sm" onchange="this.form.submit()">
                                                                <option value="">Cambiar estado</option>
                                                                <option value="pendiente" <?= $cita->estado == 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                                                                <option value="atendida" <?= $cita->estado == 'atendida' ? 'selected' : '' ?>>Atendida</option>
                                                                <option value="cancelada" <?= $cita->estado == 'cancelada' ? 'selected' : '' ?>>Cancelada</option>
                                                            </select>
                                                        </form>

                                                    </td>


                                                </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                    <?= $pager->links() ?>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-info">No hay citas registradas.</div>
                            <?php endif ?>
                        </div>

                        <!-- Citas pendientes -->
                        <div class="tab-pane fade" id="pendientes">
                            <?php foreach ($citas as $cita): ?>
                                <?php if ($cita->estado === 'pendiente'): ?>
                                    <div class="alert alert-warning mb-2">
                                        <?= esc($cita->nombre_paciente) ?> - <?= esc($cita->fecha) ?> a las <?= esc($cita->hora) ?>
                                    </div>
                                <?php endif ?>
                            <?php endforeach ?>
                        </div>

                        <!-- Citas canceladas -->
                        <div class="tab-pane fade" id="canceladas">
                            <?php foreach ($citas as $cita): ?>
                                <?php if ($cita->estado === 'cancelada'): ?>
                                    <div class="alert alert-danger mb-2">
                                        <?= esc($cita->nombre_paciente) ?> - <?= esc($cita->fecha) ?> a las <?= esc($cita->hora) ?>
                                    </div>
                                <?php endif ?>
                            <?php endforeach ?>
                        </div>

                        <!-- Citas de hoy -->
                        <div class="tab-pane fade" id="hoy">
                            <?php
                            $hoy = date('Y-m-d');
                            foreach ($citas as $cita):
                                if ($cita->fecha === $hoy):
                                    // Clase de Bootstrap según el estado
                                    $alertClass = 'alert-success'; // Default: atendida

                                    if ($cita->estado === 'cancelada') {
                                        $alertClass = 'alert-danger';
                                    } elseif ($cita->estado === 'pendiente') {
                                        $alertClass = 'alert-warning';
                                    }
                            ?>
                                    <div class="alert <?= $alertClass ?> mb-2">
                                        <?= esc($cita->nombre_paciente) ?> hoy a las <?= esc($cita->hora) ?> - <strong><?= ucfirst($cita->estado) ?></strong>
                                    </div>
                            <?php
                                endif;
                            endforeach;
                            ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>