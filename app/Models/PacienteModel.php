<?php

namespace App\Models;

use CodeIgniter\Model;

class PacienteModel extends Model
{
    protected $table = 'pacientes';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nombre',
        'apellido',
        'fecha_nacimiento',
        'genero',
        'dni',
        'telefono',
        'email',
        'alergias',
        'enfermedades_preexistentes',
        'estado'
    ];


    public function buscar($term)
    {
        return $this->like('nombre', $term)
            ->orLike('apellido', $term)
            ->orLike('dni', $term)
            ->findAll();
    }
}
