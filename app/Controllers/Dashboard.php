<?php

namespace App\Controllers;

use App\Models\PacienteModel;
use App\Models\CitasModel;
use App\Models\OdontologoModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $pacienteModel = new PacienteModel();
        $citaModel = new CitasModel();
        $odontologoModel = new OdontologoModel();

        $data = [
            'title' => 'Panel Principal',
            'totalPacientes' => $pacienteModel->countAll(),
            'totalCitas' => $citaModel->countAll(),
            'totalOdontologos' => $odontologoModel->countAll(),
            'citasHoy' => $citaModel->getCitasHoy(),
            'citasPorMes' => $citaModel->getCitasPorMes(),
        ];

        return view('dashboard/index', $data);
    }
}
