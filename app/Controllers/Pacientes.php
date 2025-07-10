<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PacienteModel;

class Pacientes extends BaseController
{
    protected $pacienteModel;

    public function __construct()
    {
        $this->pacienteModel = new PacienteModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Gestión de Pacientes',
            'pacientes' => $this->pacienteModel->paginate(10),
            'pager' => $this->pacienteModel->pager,
        ];

        return view('pacientes/index', $data);
    }
    public function show($id)
    {


        echo view('pacientes/show', [
            'title' => 'Datos generales del Paciente',
            'paciente' => $this->pacienteModel->find($id),

        ]);

        // echo var_dump($this->pacienteModel->find($id));
    }

    public function new()
    {
        $data = ['title' => 'Nuevo Paciente'];

        return view('pacientes/create', $data);
    }

    public function create()
    {

        // Validar los datos
        if ($this->validate('pacientesvalidation')) {
            // Guardar en la base de datos
            $this->pacienteModel->insert([
                'nombre' => $this->request->getPost('nombre'),
                'apellido' => $this->request->getPost('apellido'),
                'dni' => $this->request->getPost('curp'),
                'fecha_nacimiento' => $this->request->getPost('fecha_nacimiento'),
                'genero' => $this->request->getPost('genero'),
                'telefono' => $this->request->getPost('telefono'),
                'email' => $this->request->getPost('email'),
                'alergias' => $this->request->getPost('alergias'),
                'enfermedades_preexistentes' => $this->request->getPost('enfermedades_preexistentes'),
                'fecha_registro' => date('Y-m-d H:m:s'),
                'estado' => 'activo',
            ]);
        } else {
            //si npasa la validacion 
            session()->setFlashdata([
                'validation' => $this->validator
            ]);
            //regresa al mismo formulario 
            return redirect()->back()->withInput();
        }
        // Redirigir con mensaje de éxito
        return redirect()->to('pacientes')->with('mensaje', 'Registro creado de manera exitosa');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Editar Informacion del Paciente',
            'pacientes' => $this->pacienteModel->asObject()->find($id),
        ];

        return view('pacientes/edit', $data);
    }

    public function update($id)
    {

        // Validar los datos
        if ($this->validate('pacientesvalidation')) {
            // Guardar en la base de datos
            $this->pacienteModel->update($id, [
                'nombre' => $this->request->getPost('nombre'),
                'apellido' => $this->request->getPost('apellido'),
                'dni' => $this->request->getPost('curp'),
                'fecha_nacimiento' => $this->request->getPost('fecha_nacimiento'),
                'genero' => $this->request->getPost('genero'),
                'telefono' => $this->request->getPost('telefono'),
                'email' => $this->request->getPost('email'),
                'alergias' => $this->request->getPost('alergias'),
                'enfermedades_preexistentes' => $this->request->getPost('enfermedades_preexistentes'),
                'fecha_registro' => date('Y-m-d H:m:s'),
                'estado' => 'activo',
            ]);
        } else {
            //si npasa la validacion 
            session()->setFlashdata([
                'validation' => $this->validator
            ]);
            //regresa al mismo formulario 
            return redirect()->back()->withInput();
        }
        // Redirigir con mensaje de éxito
        //redirecciona si pasa la validacion
        return redirect()->to('pacientes')->with('mensaje', 'Registro actualizado de manera exitosa');
    }


    public function delete($id)
    {
        $this->pacienteModel->update($id, ['estado' => 'inactivo']);
        return redirect()->to('pacientes')->with('success', 'Paciente desactivado correctamente');
    }

    public function search()
    {
        $term = $this->request->getGet('term');
        $pacientes = $this->pacienteModel->like('nombre', $term)
            ->orLike('apellido', $term)
            ->orLike('dni', $term)
            ->findAll();

        return $this->response->setJSON($pacientes);
    }
}
