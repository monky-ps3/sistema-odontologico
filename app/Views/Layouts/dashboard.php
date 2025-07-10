<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modulo de dashboard</title>
    <link rel="stylesheet" href="<?php echo base_url() ?>public/bootstrap/css/bootstrap.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg mb-3 navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand">Sistema Odontológico</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">

                    <li class="nav-item">
                        <a href="<?= base_url('pacientes') ?>" class="nav-link">Pacientes</a>
                    </li>

                    <!-- Dropdown para Odontólogos -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="odontologosDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Odontólogos
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="odontologosDropdown">
                            <li><a class="dropdown-item" href="<?= base_url('odontologos') ?>">Lista de Odontólogos</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('horarios') ?>">Horarios</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="<?= base_url('citas') ?>" class="nav-link">Citas</a>
                    </li>

                    <?php if (auth()->loggedIn()): ?>
                        <li class="nav-item">
                            <span class="nav-link">Bienvenido, <?= esc(auth()->user()->username) ?></span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('logout') ?>">Cerrar sesión</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>



    <div class="container">
        <div class="card">
            <div class="card-body">
                <!--muestra los muestra el titulo del listado-->
                <div class="card-header">
                    <h1><?php echo $this->renderSection('header') ?></h1>
                </div>

                <!--muestra los  errores en partials session-->
                <?php echo view('partials/_session') ?>
                <!--contenido de la plantilla layouts que es el html estructura-->
                <?php echo $this->renderSection('contenido') ?>
            </div>
        </div>


    </div>
    <script src="<?php echo base_url() ?>public/bootstrap/js/bootstrap.min.js">

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>