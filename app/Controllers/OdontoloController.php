<?php

namespace App\Controllers;

use App\Models\CitasModel;
use CodeIgniter\Controller;

class OdontologoController extends Controller
{
    public function citasHoy()
    {
        $citaModel = new CitasModel();

        $userId = auth()->id(); // ID del usuario logueado (odontólogo)
        $hoy = date('Y-m-d');

        // Obtener citas del odontólogo para hoy
        $citas = $citaModel
            ->select('citas.*, pacientes.nombre AS nombre_paciente')
            ->join('pacientes', 'pacientes.id = citas.paciente_id')
            ->where('citas.odontologo_id', $userId)
            ->where('citas.fecha', $hoy)
            ->orderBy('citas.hora', 'ASC')
            ->asObject()
            ->findAll();

        return view('odontologo/citas_hoy', [
            'title' => 'Citas de Hoy',
            'citas' => $citas
        ]);
    }
}
