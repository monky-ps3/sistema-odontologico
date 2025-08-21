<?php

namespace App\Models;

use CodeIgniter\Model;

class CitasModel extends Model
{
    protected $table = 'citas';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'paciente_id',
        'odontologo_id',
        'fecha',
        'hora',
        'motivo',
        'estado'
    ];

    public function getByDateRange($start, $end)
    {
        return $this->select('citas.*, pacientes.nombre as paciente_nombre')
            ->join('pacientes', 'pacientes.paciente_id = citas.paciente_id')
            ->where('fecha_hora >=', $start)
            ->where('fecha_hora <=', $end)
            ->findAll();
    }

    public function getCitasHoy()
    {
        return $this->select('citas.*,pacientes.nombre as nombre_paciente')
            ->join('pacientes', 'pacientes.id=citas.paciente_id')
            ->where('DATE(fecha)', date('Y-m-d'))
            ->asObject()
            ->orderBy('hora', 'asc')
            ->findAll();
    }
    public function getCitasPorMes()
    {
        return $this->select('MONTH(fecha) as mes, COUNT(*) as total')
            ->groupBy('MONTH(fecha)')
            ->asObject()
            ->orderBy('mes', 'asc')
            ->findAll();
    }
    // consultas para atender la cita 
    public function atenderCita($id)
    {
        return $this->select('citas.*,pacientes.nombre AS nombre_paciente')
            ->join('pacientes', 'pacientes.id=citas.paciente_id')
            ->where('citas.id', $id)
            ->asObject()
            ->first();
    }
}
