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
                    <h6 class="m-0 font-weight-bold text-primary">
                        Dr. <?= esc($horarios[0]->nombre_odontologo ?? 'Sin nombre') ?>
                    </h6>
                    <a href="<?= base_url('horarios/nuevo/' . $horarios[0]->odontologo_id) ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nuevo Horario
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>

                                    <th>Día</th>
                                    <th>Desde</th>
                                    <th>Hasta</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($horarios as $h): ?>
                                    <tr>

                                        <td><?= ucfirst($h->dia_semana) ?></td>
                                        <td><?= date('h:i A', strtotime($h->hora_inicio)) ?></td>
                                        <td><?= date('h:i A', strtotime($h->hora_fin)) ?></td>

                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="<?= base_url('horarios/editar/' . $h->id) ?>" class="btn btn-sm btn-warning">Editar</a>

                                                <form action="<?= base_url('horarios/desactivar/' . $h->id) ?>" method="post" onsubmit="return confirm('¿Eliminar?')" class="d-inline">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                                </form>
                                            </div>
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