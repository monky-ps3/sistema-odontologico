<?php


namespace App\Controllers;

use App\Models\HorarioModel;
use App\Models\OdontologoModel;

class HorarioOdontologo extends BaseController
{
    protected $horarioModel;
    protected $odontologoModel;

    public function __construct()
    {
        $this->horarioModel = new HorarioModel();
        $this->odontologoModel = new OdontologoModel();
    }

    public function index($odontologo_id)
    {

       // var_dump($odontologo_id);
        $data = [
            'title' => 'Horario de Odontologos',
            'horarios' => $this->horarioModel
                ->select('horarios.*,odontologos.nombre AS nombre_odontologo')
               
                ->join('odontologos', 'odontologos.id=horarios.odontologo_id')
                ->where('odontologo_id', $odontologo_id)
                ->orderBy('dia_semana')
                 ->asObject()
                ->paginate(10),
            'pager' => $this->horarioModel->pager,
            'odontologo_id' => $odontologo_id,
        ];
        //dd($data);
        return view('horarios/index', $data);
    }
      public function odontologos()
    {

        $data = [
            'title' => 'Gestión de Horarios',
            'odontologos' => $this->odontologoModel
                ->select('odontologos.*')
                ->asObject()            
                ->orderBy('id', 'DESC')
                ->where('activo', "1")
                ->paginate(10),
            'pager' => $this->odontologoModel->pager,
        ];

        return view('horarios/odontologos', $data);
    }

    public function new($odontologo_id)
    {

        $horas = [
            '08:00' => '08:00 AM',
            '09:00' => '09:00 AM',
            '10:00' => '10:00 AM',
            '11:00' => '11:00 AM',
            '12:00' => '12:00 PM',
            '13:00' => '01:00 PM',
            '14:00' => '02:00 PM',
            '15:00' => '03:00 PM',
            '16:00' => '04:00 PM',
            '17:00' => '05:00 PM',
            '18:00' => '06:00 PM',
            '19:00' => '07:00 PM',
            '20:00' => '08:00 PM',
        ];
        $dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];


        $diasOcupados = [];
        if ($odontologo_id) {
            $horarios = $this->horarioModel
                ->select('dia_semana')
                ->where('odontologo_id', $odontologo_id)
                ->findAll();
        }
        // Convertimos en array de días ocupados
        $diasOcupados = array_column($horarios, 'dia_semana');


        $data = [
            'title' => 'Agregar horario',
            'odontologos' => $this->odontologoModel->asObject()->find($odontologo_id),
            'horas' => $horas,
            'dias' => $dias,
            'diasOcupados' => $diasOcupados

        ];
        return view('horarios/create', $data);
    }
    public function create($odontologo_id)
    {
        $horaInicio = $this->request->getPost('hora_inicio');
        $horaFin = $this->request->getPost('hora_fin');

        // Validar los datos
        if ($this->validate('horariosvalidation')) {

            // Validar que horaInicio < horaFin
            if (strtotime($horaInicio) >= strtotime($horaFin)) {
                return redirect()->back()->withInput()->with('error', 'La hora de inicio debe ser menor que la hora de fin.');
            }

            // Validar que no exista traslape
            $existe = $this->horarioModel
                ->where('odontologo_id', $this->request->getPost('odontologo_id'))
                ->where('dia_semana', $this->request->getPost('dia_semana'))
                ->groupStart()
                ->where('hora_inicio <', $horaFin)
                ->where('hora_fin >', $horaInicio)
                ->groupEnd()
                ->first();

            if ($existe) {
                return redirect()->back()->withInput()->with('error', 'Este horario se cruza con uno existente.');
            }

            // Guardar el horario
            $this->horarioModel->insert([
                'odontologo_id' => $this->request->getPost('odontologo_id'),
                'dia_semana'    => $this->request->getPost('dia_semana'),
                'hora_inicio'   => $horaInicio,
                'hora_fin'      => $horaFin,
            ]);

            return redirect()->to('horarios/nuevo/' . $odontologo_id)->with('mensaje', 'Registro creado de manera exitosa');
        }

        // Si no pasa validación
        return redirect()->back()->withInput()->with('validation', $this->validator);
    }

    public function edit($id)
    {
        // Obtener el horario por ID
        $horario = $this->horarioModel->asObject()->find($id);

        if (!$horario) {
            return redirect()->to('horarios/odontologo/' . $id)->with('error', 'Horario no encontrado');
        }

        // Horas disponibles para el select
        $horas = [
            '08:00' => '08:00 AM',
            '09:00' => '09:00 AM',
            '10:00' => '10:00 AM',
            '11:00' => '11:00 AM',
            '12:00' => '12:00 PM',
            '13:00' => '01:00 PM',
            '14:00' => '02:00 PM',
            '15:00' => '03:00 PM',
            '16:00' => '04:00 PM',
            '17:00' => '05:00 PM',
            '18:00' => '06:00 PM',
            '19:00' => '07:00 PM',
            '20:00' => '08:00 PM',
        ];

        // Días de la semana
        $dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];

        // Días ya ocupados por el mismo odontólogo (excepto el actual)
        $otrosHorarios = $this->horarioModel
            ->select('dia_semana')
            ->where('odontologo_id', $horario->odontologo_id)
            ->where('id !=', $id)
            ->findAll();

        $diasOcupados = array_column($otrosHorarios, 'dia_semana');

        $data = [
            'title' => 'Editar horario',
            'horario' => $horario,
            'odontologo' => $this->odontologoModel->asObject()->find($horario->odontologo_id),
            'horas' => $horas,
            'dias' => $dias,
            'diasOcupados' => $diasOcupados
        ];
         var_dump($data);
        return view('horarios/edit', $data);
    }
    public function update($id)
    {

        $horario = $this->horarioModel->find($id);

        if (!$horario) {
            return redirect()->to('horarios/odontologo/' . $id)->with('error', 'Horario no encontrado');
        }

        //validar reglas definidad del update
        if (!$this->validate('horariosvalidationupdate')) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $horaInicio = $this->request->getPost('hora_inicio');
        $horaFin = $this->request->getPost('hora_fin');
        // Validación de lógica: hora inicio debe ser menor que hora fin

        // Validación de lógica: hora inicio debe ser menor que hora fin
        if (strtotime($horaInicio) >= strtotime($horaFin)) {
            return redirect()->back()->withInput()
                ->with('error', 'La hora de inicio debe ser menor que la hora de fin.');
        }

        // Validar que no haya traslape con otros horarios del mismo odontólogo ese día
        $existeTraslape = $this->horarioModel
            ->where('odontologo_id', $horario['odontologo_id'])
            ->where('dia_semana', $horario['dia_semana'])
            ->where('id !=', $id)
            ->groupStart()
            ->where('hora_inicio <', $horaFin)
            ->where('hora_fin >', $horaInicio)
            ->groupEnd()
            ->first();

        if ($existeTraslape) {
            return redirect()->back()->withInput()
                ->with('error', 'El nuevo horario se traslapa con otro ya existente.');
        }

        // Guardar cambios
        $this->horarioModel->update($id, [
            'hora_inicio' => $horaInicio,
            'hora_fin'    => $horaFin,
        ]);

        return redirect()->to('horarios/odontologo/' . $horario['odontologo_id'])->with('mensaje', 'Horario actualizado correctamente.');
    }

       public function delete($id)
    {

        $horario = $this->horarioModel->asObject()->find($id);
        if(!$horario){
            return redirect()->back()->with('error','Horario no encontrado');
        }
        $this->odontologoModel->update($id, ['activo' => '0']);
        return redirect()->to('horarios/odontologo/' . $horario->odontologo_id)->with('success', 'Odontologo desactivado correctamente');
    }
}
