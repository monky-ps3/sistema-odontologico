<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */






// Agrega estas rutas en tu archivo de rutas para el login
//$routes->group('admin', ['filter' => 'auth'], function ($routes) {});


// $routes->group('pacientes', function ($routes) {
//     $routes->get('/', 'Pacientes::index');
//     $routes->get('new', 'Pacientes::new'); // Muestra el formulario
//     $routes->post('create', 'Pacientes::create');
//     $routes->get('show/(:num)', 'Pacientes::show/$1');
//     $routes->get('edit/(:num)', 'Pacientes::edit/$1');
//     $routes->post('update/(:num)', 'Pacientes::update/$1');
//     $routes->get('delete/(:num)', 'Pacientes::delete/$1');
//     $routes->get('search', 'Pacientes::search');
// });

// $routes->group('odontologos', function ($routes) {
//     $routes->get('/', 'Odontologos::index');
//     $routes->get('new', 'Odontologos::new'); // Muestra el formulario
//     $routes->post('create', 'Odontologos::create');
//     $routes->get('show/(:num)', 'Odontologos::show/$1');
//     $routes->get('editar/(:num)', 'Odontologos::edit/$1');
//     $routes->post('update/(:num)', 'Odontologos::update/$1');
//     $routes->post('delete/(:num)', 'Odontologos::delete/$1');
//     $routes->get('search', 'Odontologos::search');
// });


// $routes->group('citas', function ($routes) {
//     $routes->get('/', 'Citas::index');
//     $routes->get('nueva/(:num)', 'Citas::new/$1');
//     $routes->get('horariosdisponibles', 'Citas::horarios_disponibles');
//     $routes->get('show/(:num)', 'Citas::show/$1');
//     $routes->post('create', 'Citas::create');
//     $routes->get('editar/(:num)', 'Citas::edit/$1');
//     $routes->post('update/(:num)', 'Citas::update/$1');
//     $routes->post('delete/(:num)', 'Citas::delete/$1');
//     $routes->post('cambiarestado/(:num)', 'Citas::cambiarEstado/$1');
// });


// $routes->group('horarios', function ($routes) {
//     $routes->get('/', 'HorarioOdontologo::odontologos');
//     // Mostrar horarios de un odontólogo
//     $routes->get('odontologo/(:num)', 'HorarioOdontologo::index/$1');


//     $routes->get('nuevo/(:num)', 'HorarioOdontologo::new/$1');

//     $routes->post('create/(:num)', 'HorarioOdontologo::create/$1');

//     $routes->get('editar/(:num)', 'HorarioOdontologo::edit/$1');
//     $routes->post('update/(:num)', 'HorarioOdontologo::update/$1');
//     $routes->post('desactivar/(:num)', 'HorarioOdontologo::delete/$1');
// });
$routes->get('/', 'Home::index');

service('auth')->routes($routes);
$routes->group('', ['filter' => 'group:admin,recepcionista'], function ($routes) {
    $routes->get('dashboard', 'Dashboard::index'); // Nueva ruta
    $routes->group('pacientes', function ($routes) {
        $routes->get('/', 'Pacientes::index');
        $routes->get('new', 'Pacientes::new');
        $routes->post('create', 'Pacientes::create');
        $routes->get('show/(:num)', 'Pacientes::show/$1');
        $routes->get('edit/(:num)', 'Pacientes::edit/$1');
        $routes->post('update/(:num)', 'Pacientes::update/$1');
        $routes->get('delete/(:num)', 'Pacientes::delete/$1');
        $routes->get('search', 'Pacientes::search');
    });

    $routes->group('odontologos', function ($routes) {
        $routes->get('/', 'Odontologos::index');
        $routes->get('new', 'Odontologos::new');
        $routes->post('create', 'Odontologos::create');
        $routes->get('show/(:num)', 'Odontologos::show/$1');
        $routes->get('editar/(:num)', 'Odontologos::edit/$1');
        $routes->post('update/(:num)', 'Odontologos::update/$1');
        $routes->post('delete/(:num)', 'Odontologos::delete/$1');
        $routes->get('search', 'Odontologos::search');
    });

    $routes->group('citas', function ($routes) {
        $routes->get('/', 'Citas::index');
        $routes->get('odontologos', 'Citas::nueva');
        $routes->get('nueva/(:num)', 'Citas::new/$1');
        $routes->get('horariosdisponibles', 'Citas::horarios_disponibles');
        $routes->get('show/(:num)', 'Citas::show/$1');
        $routes->post('create', 'Citas::create');
        $routes->get('editar/(:num)', 'Citas::edit/$1');
        $routes->post('update/(:num)', 'Citas::update/$1');
        $routes->post('delete/(:num)', 'Citas::delete/$1');
        $routes->post('cambiarestado/(:num)', 'Citas::cambiarEstado/$1');
    });

    $routes->group('horarios', function ($routes) {
        $routes->get('/', 'HorarioOdontologo::odontologos');
        $routes->get('odontologo/(:num)', 'HorarioOdontologo::index/$1');
        $routes->get('nuevo/(:num)', 'HorarioOdontologo::new/$1');
        $routes->post('create/(:num)', 'HorarioOdontologo::create/$1');
        $routes->get('editar/(:num)', 'HorarioOdontologo::edit/$1');
        $routes->post('update/(:num)', 'HorarioOdontologo::update/$1');
        $routes->post('desactivar/(:num)', 'HorarioOdontologo::delete/$1');
    });
});

$routes->group('odontologo', ['filter' => 'group:odontologo'], function ($routes) {
    $routes->get('citas-hoy', 'OdontoloController::citasHoy');
    $routes->get('horario', 'OdontoloController::horario');
    $routes->get('atender-cita/(:num)', 'OdontoloController::atenderCita/$1');
    $routes->post('guardar-atencion/(:num)', 'OdontoloController::guardarAtencion/$1');
    // Aquí puedes seguir agregando otras funciones exclusivas del odontólogo
});
