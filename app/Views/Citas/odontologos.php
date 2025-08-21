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
                   
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                   
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
                                            <a href="<?= base_url('citas/nueva/' . $o['id']) ?>" class="btn btn-sm btn-success">Nueva Cita</a>
                                      


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