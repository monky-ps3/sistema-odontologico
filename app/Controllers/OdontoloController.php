<?php

namespace App\Controllers;

use App\Models\CitasModel;
use App\Models\HorarioModel;
use App\Models\OdontologoModel;
use CodeIgniter\Controller;

class OdontoloController extends Controller
{
  protected $citaModel;
  protected $horarioModel;
  protected $odontologosModel;
  protected $historialmedico;
  public function __construct()
  {
    $this->citaModel  = new CitasModel();
    $this->horarioModel = new HorarioModel();
    $this->odontologosModel = new OdontologoModel();
  }
  public function citasHoy()
  {


    $userId = auth()->id(); // ID del usuario logueado (odontólogo)
    $hoy = date('Y-m-d');

    // Obtener citas del odontólogo para hoy
    //
    $citas = $this->citaModel
      ->select('citas.*, pacientes.nombre AS nombre_paciente')
      ->asObject()
      ->join('pacientes', 'pacientes.id = citas.paciente_id')
      ->join('odontologos', 'odontologos.id = citas.odontologo_id') // Join adicional
      ->where('odontologos.user_id', $userId) // Filtramos por usuario_id = 9
      ->where('citas.fecha', $hoy)
      ->orderBy('citas.hora', 'ASC')
      ->findAll();


    //echo var_dump($citas, $hoy, $userId);
    return view('odontologo_panel/citas_hoy', [
      'title' => 'Citas de Hoy',
      'citas' => $citas
    ]);
  }
  public function horario()
  {
    // Obtener el ID del odontólogo asociado al usuario logueado
    $odontologo = $this->odontologosModel->asObject()->where('user_id', auth()->id())->first();

    if (!$odontologo) {
      return redirect()->back()->with('error', 'No se encontró el odontólogo asociado');
    }

    $userId = auth()->id();
    $data = [
      'title' => 'Mi Horario',
      'horarios' => $this->horarioModel
        ->select('horarios.*,odontologos.nombre AS nombre_odontologo')
        ->asObject()
        ->join('odontologos', 'odontologos.id=horarios.odontologo_id')
        ->where('odontologos.user_id', $userId)
        ->orderBy('dia_semana')
        ->paginate(10),
      'pager' => $this->horarioModel->pager,
      'odontologo_id' => $odontologo->id,

    ];
    return view('horarios/index', $data);
  }
  public function atenderCita($id)
  {
    $cita = $this->citaModel->atenderCita($id);
    if (!$cita) {
      return redirect()->back()->with('erro', 'cita no encontrada');
    }

    return view('odontologo_panel/atender', [
      'title' => 'Atender cita',
      'cita' => $cita
    ]);
  }
}
