<?php
namespace App\Models;

use CodeIgniter\Model;

class CitasModel extends Model
{
    protected $table = 'citas';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'paciente_id', 'odontologo_id', 'fecha','hora', 
        'motivo', 'estado'
    ];
    
    public function getByDateRange($start, $end)
    {
        return $this->select('citas.*, pacientes.nombre as paciente_nombre')
            ->join('pacientes', 'pacientes.paciente_id = citas.paciente_id')
            ->where('fecha_hora >=', $start)
            ->where('fecha_hora <=', $end)
            ->findAll();
    }
}