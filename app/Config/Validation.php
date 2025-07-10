<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------

    public $pacientesvalidation = ([
        'nombre' => 'required|min_length[3]|max_length[30]',
        'apellido' => 'required|min_length[3]|max_length[50]',
        'email' => 'required|min_length[3]|max_length[100]|is_unique[pacientes.email]',
    ]);

    public  $odontologosvalidation = ([
        'username' => [
            'label'  => 'Usuario',
            'rules'  => 'required|min_length[4]|max_length[30]|is_unique[users.username]',
            'errors' => [
                'required'    => 'El nombre de usuario es obligatorio.',
                'is_unique'   => 'El usuario ya está en uso.',
                'min_length'  => 'El usuario debe tener al menos 4 caracteres.',
                'max_length'  => 'El usuario no puede superar los 30 caracteres.'
            ]
        ],
        'email' => [
            'label'  => 'Correo electrónico',
            'rules'  => 'required|valid_email|is_unique[auth_identities.secret]',
            'errors' => [
                'required'   => 'El correo es obligatorio.',
                'valid_email' => 'El correo no es válido.',
                'is_unique'  => 'Ese correo ya está registrado.'
            ]
        ],
        'password' => [
            'label'  => 'Contraseña',
            'rules'  => 'required|min_length[6]',
            'errors' => [
                'required'   => 'La contraseña es obligatoria.',
                'min_length' => 'La contraseña debe tener al menos 6 caracteres.'
            ]
        ],
        'nombre' => [
            'label'  => 'Nombre',
            'rules'  => 'required|min_length[3]|max_length[30]',
            'errors' => [
                'required'   => 'El campo {field} es obligatorio.',
                'min_length' => 'El campo {field} debe tener al menos 3 caracteres.',
                'max_length' => 'El campo {field} no puede tener más de 30 caracteres.'
            ]
        ],
        'apellido' => [
            'label'  => 'Apellido',
            'rules'  => 'required|min_length[3]|max_length[50]',
            'errors' => [
                'required'   => 'El campo {field} es obligatorio.',
                'min_length' => 'El campo {field} debe tener al menos 3 caracteres.',
                'max_length' => 'El campo {field} no puede tener más de 50 caracteres.'
            ]
        ],


    ]);

    public array $odontvalidateUpdate = ([
        'username' => [
            'label' => 'Usuario',
            'rules' => 'required|min_length[3]|max_length[50]',
            'errors' => [
                'required'   => 'El nombre de usuario es obligatorio.',
                'min_length' => 'El usuario debe tener al menos 3 caracteres.',
                'max_length' => 'El usuario no debe exceder los 50 caracteres.',
            ],
        ],
        'email' => [
            'label' => 'Correo electrónico',
            'rules' => 'required|valid_email',
            'errors' => [
                'required'    => 'El correo electrónico es obligatorio.',
                'valid_email' => 'Debes ingresar un correo válido.',
            ],
        ],
        'password' => [
            'label' => 'Contraseña',
            'rules' => 'permit_empty|min_length[6]',
            'errors' => [
                'min_length' => 'La contraseña debe tener al menos 6 caracteres si se cambia.',
            ],
        ],
        'nombre' => [
            'label' => 'Nombre',
            'rules' => 'required',
            'errors' => [
                'required' => 'El nombre es obligatorio.',
            ],
        ],
        'apellido' => [
            'label' => 'Apellido',
            'rules' => 'required',
            'errors' => [
                'required' => 'El apellido es obligatorio.',
            ],
        ],
        'cedula' => [
            'label' => 'Cédula profesional',
            'rules' => 'required',
            'errors' => [
                'required' => 'La cédula profesional es obligatoria.',
            ],
        ],
        'especialidad' => [
            'label' => 'Especialidad',
            'rules' => 'required',
            'errors' => [
                'required' => 'La especialidad es obligatoria.',
            ],
        ],
        'telefono' => [
            'label' => 'Teléfono',
            'rules' => 'required|min_length[10]',
            'errors' => [
                'required'   => 'El teléfono es obligatorio.',
                'min_length' => 'El teléfono debe tener al menos 10 dígitos.',
            ],
        ],
        'fecha_nacimiento' => [
            'label' => 'Fecha de nacimiento',
            'rules' => 'required|valid_date[Y-m-d]',
            'errors' => [
                'required'   => 'La fecha de nacimiento es obligatoria.',
                'valid_date' => 'La fecha debe tener el formato correcto (YYYY-MM-DD).',
            ],
        ],
        'genero' => [
            'label' => 'Género',
            'rules' => 'required|in_list[masculino,femenino,otros]',
            'errors' => [
                'required' => 'El género es obligatorio.',
                'in_list' => 'Selecciona un género válido.',
            ],
        ],
    ]);


    public $citasvalidation = ([
        'paciente_id' => [
            'label' => 'Paciente',
            'rules' => 'required|is_natural_no_zero',
            'errors' => [
                'required' => 'El paciente es obligatorio. Seleccione uno.',
                'is_natural_no_zero' => 'Seleccione un paciente válido.'
            ]
        ],
        'odontologo_id' => [
            'label' => 'Odontólogo',
            'rules' => 'required|is_natural_no_zero',
            'errors' => [
                'required' => 'El odontólogo es obligatorio.',
                'is_natural_no_zero' => 'Seleccione un odontólogo válido.'
            ]
        ],
        'fecha' => [
            'label' => 'Fecha',
            'rules' => 'required|valid_date[Y-m-d]',
            'errors' => [
                'required' => 'La fecha de la cita es obligatoria.',
                'valid_date' => 'Debe ingresar una fecha válida en formato YYYY-MM-DD.'
            ]
        ],
        'hora' => [
            'label' => 'Hora',
            'rules' => 'required',
            'errors' => [
                'required' => 'La hora es obligatoria.'
            ]
        ],
        'motivo' => [
            'label' => 'Motivo',
            'rules' => 'permit_empty|string',
            'errors' => [
                'string' => 'El motivo debe ser un texto válido.'
            ]
        ]
    ]);


    public $horariosvalidation = ([
        'dia_semana' => [
            'label' => 'Día',
            'rules' => 'required|in_list[lunes,martes,miercoles,jueves,viernes,sabado,domingo]',
            'errors' => [
                'required' => 'El día es obligatorio.',
                'in_list' => 'Selecciona un día válido.',
            ],
        ],
        'odontologo_id' => [
            'label' => 'Nombre',
            'rules' => 'required|is_natural_no_zero',
            'errors' => [
                'string' => 'Debe seleccionar el nombre del medico.'
            ]
        ],
        'hora_inicio'   => 'required',
        'hora_fin'      => 'required',

    ]);
    public $horariosvalidationupdate = ([
        'hora_inicio' => [
            'label' => 'Hora de inicio',
            'rules' => 'required',
            'errors' => [
                'required' => 'La hora de inicio es obligatoria.',
            ],
        ],
        'hora_fin' => [
            'label' => 'Hora de fin',
            'rules' => 'required',
            'errors' => [
                'required' => 'La hora de fin es obligatoria.',
            ],
        ],

    ]);
}
