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
                    <h6 class="m-0 font-weight-bold text-primary">Listado de Pacientes</h6>
                    <a href="<?php echo  base_url()?>pacientes/new" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nuevo Paciente
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>DNI</th>
                                    <th>Teléfono</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pacientes as $paciente): ?>
                                <tr>
                                    <td><?= $paciente['id'] ?></td>
                                    <td><?= $paciente['nombre'] ?></td>
                                    <td><?= $paciente['apellido'] ?></td>
                                    <td><?= $paciente['dni'] ?></td>
                                    <td><?= $paciente['telefono'] ?></td>
                                    <td>
                                        <span class="badge badge-<?= $paciente['estado'] === 'activo' ? 'success' : 'danger' ?>">
                                            <?= ucfirst($paciente['estado']) ?>
                                        </span>
                                    </td>
                                    <td>
                                         <a href="<?= base_url('pacientes/show/' . $paciente['id']) ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit">Ver</i>
                                        </a>
                                        <a href="<?= base_url('pacientes/edit/' . $paciente['id']) ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit">Editar</i>
                                        </a>
                                        <a href="<?= base_url('pacientes/delete/' . $paciente['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">
                                            <i class="fas fa-trash">Eliminar</i>
                                        </a>
                                        <a href="<?= base_url('odontograma/' . $paciente['id']) ?>" class="btn btn-sm btn-info">
                                            <i class="fas fa-tooth"></i> Odontograma
                                        </a>
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