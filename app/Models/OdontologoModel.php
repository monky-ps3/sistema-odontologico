<?php

namespace App\Models;

use CodeIgniter\Model;

class OdontologoModel extends Model
{
    protected $table = 'odontologos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id','nombre','apellido','cedula', 'especialidad', 'telefono','direccion', 'activo','genero','fecha_nacimiento'];
}
