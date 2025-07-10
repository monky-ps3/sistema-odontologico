<?php 

use CodeIgniter\Model;

class RecetaModel extends Model{

    protected $table = 'recetas';

    protected $primaryKey= 'id';


    protected $allowedFields=[
        'medicamentos','indicaciones',
    ];

    protected $useTimestamps = true;
    protected $createdField='created_at';
    protected $updatedField='updated_at';
}