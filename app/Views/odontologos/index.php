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
                    <h6 class="m-0 font-weight-bold text-primary">Listado de Odontologos</h6>
                    <a href="<?php echo  base_url() ?>odontologos/new" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nuevo Odontologo
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Usuario</th>
                                    <th>Nombre</th>
                                    <th>Cédula</th>
                                    <th>Especialidad</th>
                                    <th>Teléfono</th>
                                    <th>Activo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($odontologos as $o): ?>
                                    <tr>
                                        <td><?= esc($o['username']) ?></td>
                                        <td><?= esc($o['nombre']) ?></td>
                                        <td><?= esc($o['cedula']) ?></td>
                                        <td><?= esc($o['especialidad']) ?></td>
                                        <td><?= esc($o['telefono']) ?></td>
                                        <td><?= $o['activo'] ? 'Sí' : 'No' ?></td>
                                        <td>
                                            <a href="<?= base_url('odontologos/show/' . $o['id']) ?>" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit">Ver</i>
                                            </a>
                                            <!-- <a href="<?= base_url('horarios/odontologo/' . $o['id']) ?>" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit">Horario</i>
                                            </a> -->
                                            <a href="<?= base_url('citas/nueva/' . $o['id']) ?>" class="btn btn-sm btn-success">Cita</a>
                                            <a href="<?= base_url('odontologos/editar/' . $o['id']) ?>" class="btn btn-sm btn-warning">Editar</a>
                                            <form action="<?= base_url('odontologos/delete/' . $o['id']) ?>" method="post" style="display:inline;">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas desactivar al odontólogo?')">
                                                    Desactivar
                                                </button>
                                            </form>


                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                        <?= $pager->links() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>