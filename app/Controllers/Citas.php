<?php

namespace App\Controllers;

use  App\Models\CitasModel;
use App\Models\HorarioModel;
use App\Models\PacienteModel;
use App\Models\OdontologoModel;


class Citas extends BaseController
{

    protected $citaModel;
    protected $pacienteModel;
    protected $odontologosModel;
    protected $horarioModel;

    public function __construct()
    {
        $this->citaModel = new CitasModel();
        $this->pacienteModel = new PacienteModel();
        $this->odontologosModel = new OdontologoModel();
        $this->horarioModel = new HorarioModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Gestión de Citas',
            'citas' => $this->citaModel
                ->select('citas.*, pacientes.nombre AS nombre_paciente, odontologos.nombre AS nombre_odontologo,odontologos.genero as genero_odontologo')
                ->asObject()
                ->join('pacientes', 'pacientes.id = citas.paciente_id')
                ->join('odontologos', 'odontologos.id = citas.odontologo_id')
                //->where('citas.estado', 'pendiente')
                ->orderBy('citas.id', 'DESC')
                ->paginate(10),
            'pager' => $this->citaModel->pager,
        ];
        //var_dump($data['citas']);
        return view('citas/index', $data);
    }


public function nueva(){
   $data = [
            'title' => 'Gestión de Citas',
            'odontologos' => $this->odontologosModel
                ->select('odontologos.*,users.username')
                ->join('users', 'users.id =odontologos.user_id')
                ->orderBy('id', 'DESC')
                ->where('activo', "1")
                ->paginate(10),
            'pager' => $this->odontologosModel->pager,
        ];

        return view('citas/odontologos', $data);


}




    public function show($id){

     $cita = $this->citaModel            
            ->select('citas.*, pacientes.nombre AS nombre_paciente,odontologos.nombre AS nombre_odontologo')
            ->asObject()
            ->join('pacientes', 'pacientes.id = citas.paciente_id')
            ->join('odontologos', 'odontologos.id = citas.odontologo_id')
            ->where('citas.id', $id)
            ->get()
            ->getRow();
        //si no encuentra el odontologo  redirige errror

        if (!$cita) {
            return redirect()->to('cita')->with('error', 'cita');
        }
        return view('citas/show', [
            'title' => 'Datos generales de la cita',
            'cita' => $cita,
        ]);
    }

      
    public function new($id)
    {
        $data = [
            'title' => 'Registrar Nueva Cita',
            'pacientes' => $this->pacienteModel->asObject()->findAll(),
            'odontologo' => $this->odontologosModel->asObject()->find($id),
        ];
        return view('citas/create', $data);
    }


    public function create()
    {
        if (!$this->validate('citasvalidation')) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }
        $this->citaModel->save([
            'paciente_id' => $this->request->getPost('paciente_id'),
            'odontologo_id' => $this->request->getPost('odontologo_id'),
            'fecha' => $this->request->getPost('fecha'),
            'hora' => $this->request->getPost('hora'),
            'motivo' => $this->request->getPost('motivo'),
            'estado' => 'pendiente'
        ]);

        return redirect()->to('citas')->with('success', 'Cita registrada correctamente');
    }

    public function edit($id)
    {

        //buscar si  existe la cita 
        $cita = $this->citaModel->asObject()->find($id);

        if (!$cita) {
            return redirect()->to('citas')->with('error', 'Cita no encontrada');
        }

        $data = [
            'title' => 'Editar Nueva Cita',
            'pacientes' => $this->pacienteModel->asObject()->findAll(),
            'odontologos' => $this->odontologosModel->asObject()->findAll(),
            'cita' => $cita,
        ];
        return view('citas/edit', $data);
    }



    public function update($id)
    {
        if (!$this->validate('citasvalidation')) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }
        // Verificar que la cita exista antes de actualizar
        $cita = $this->citaModel->find($id);
        if (!$cita) {
            return redirect()->to('citas')->with('error', 'La cita no fue encontrada');
        }
        $this->citaModel->update($id, [
            'paciente_id' => $this->request->getPost('paciente_id'),
            'odontologo_id' => $this->request->getPost('odontologo_id'),
            'fecha' => $this->request->getPost('fecha'),
            'hora' => $this->request->getPost('hora'),
            'motivo' => $this->request->getPost('motivo'),
            'estado' => 'pendiente'
        ]);

        return redirect()->to('citas')->with('success', 'Cita Actualizada correctamente');
    }

    public function delete($id)
    {

        $this->citaModel->update($id, ['estado' => 'cancelada']);
        return redirect()->to('citas')->with('success', 'Cita cancelada correctamente');
    }
    public function cambiarEstado($id){
        $nuevoEstado=$this->request->getPost('estado');
        if(!in_array($nuevoEstado,['pendiente','atendida','cancelada'])){
            return redirect()->back()->with('error','Estado invalido');

        }
        $this->citaModel->update($id,['estado'=>$nuevoEstado]);

        return redirect()->back()->with('mensaje','Estado actualizado');
    }

    public function horarios_disponibles()
    {
        // Obtener los parámetros de la solicitud GET
        $fecha = $this->request->getGet('fecha');
        $odontologo_id = $this->request->getGet('odontologo_id');

        // Validar entrada
        if (!$fecha || !$odontologo_id) {
            return $this->response->setJSON([]);
        }

        // Obtener el día de la semana (en inglés) y traducirlo a español
        $diaSemanaIngles = strtolower(date('l', strtotime($fecha)));
        $diasTraducidos = [
            'monday'    => 'lunes',
            'tuesday'   => 'martes',
            'wednesday' => 'miercoles',
            'thursday'  => 'jueves',
            'friday'    => 'viernes',
            'saturday'  => 'sabado',
            'sunday'    => 'domingo',
        ];

        $diaSemana = $diasTraducidos[$diaSemanaIngles] ?? null;
        if (!$diaSemana) {
            return $this->response->setJSON([]);
        }

        // Buscar el horario del odontólogo para ese día
        $horario = $this->horarioModel
            ->where('odontologo_id', $odontologo_id)
            ->where('dia_semana', $diaSemana)
            ->first();

        if (!$horario) {
            return $this->response->setJSON([]); // No hay horario definido para ese día
        }

        // Convertimos a timestamps para poder generar intervalos
        $horaInicio = strtotime($horario->hora_inicio); // ej: "08:00:00"
        $horaFin    = strtotime($horario->hora_fin);    // ej: "14:00:00"

        // Generar bloques de 1 hora (3600 segundos)
        $intervalos = [];
        for ($hora = $horaInicio; $hora < $horaFin; $hora += 3600) {
            $intervalos[] = [
                'valor' => date('H:i', $hora),             // para enviar el valor del select (ej. "14:00")
                'texto' => date('g:i A', $hora)            // para mostrar en pantalla (ej. "2:00 PM")
            ];
        }

        // Obtener citas ya registradas en esa fecha y odontólogo
        $citasOcupadas = $this->citaModel
            ->where('odontologo_id', $odontologo_id)
            ->where('fecha', $fecha)
          ->whereIn('estado', ['pendiente', 'atendida']) 
            ->findAll();

        // Extraer las horas ocupadas 'hora es el nombre del campo hora de la base de datos '
        // $horasOcupadas = array_column($citasOcupadas, 'hora');$horasOcupadas = array_map(function ($cita) {
        $horasOcupadas = array_map(function ($cita) {
            return date('H:i', strtotime($cita['hora']));
        }, $citasOcupadas);

        // Filtrar intervalos disponibles eliminando los ya ocupados
        $disponibles = array_filter($intervalos, function ($h) use ($horasOcupadas) {
            return !in_array($h['valor'], $horasOcupadas);
        });

        // Reindexar y devolver en formato JSON
        return $this->response->setJSON(array_values($disponibles));
    }
}
