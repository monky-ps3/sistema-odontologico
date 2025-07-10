<?php


namespace App\Models;

use CodeIgniter\Model;

class HorarioModel extends Model
{

    protected $table = 'horarios';
    protected $primaryKey = 'id';
    protected $allowedFields = ['odontologo_id', 'dia_semana', 'hora_inicio', 'hora_fin', 'activo'];
    protected $useTimestamps = false;
}
