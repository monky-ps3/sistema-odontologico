<?php 

namespace App\Models;

use CodeIgniter\Model;

class HistorialClinicoModel extends Model{
    protected $table = 'historial_clinico';
    protected $primaryKey= 'id';


    protected $allowedFields=[
        'cida_id','receta_id','diagnostico','tratamiento','observaciones'
    ];

    protected $useTimestamps = true;

    protected $createdField = 'created_at';
    protected $updatedField= 'update_at';
}