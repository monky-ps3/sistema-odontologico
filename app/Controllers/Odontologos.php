<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\OdontologoModel;
use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;
use CodeIgniter\Shield\Entities\User;

class Odontologos extends BaseController
{
    protected $odontologoModel;

    public function __construct()
    {
        $this->odontologoModel = new OdontologoModel();
    }

    public function index()
    {

        $data = [
            'title' => 'Gestión de Odontologos',
            'odontologos' => $this->odontologoModel
                ->select('odontologos.*,users.username')
                ->join('users', 'users.id =odontologos.user_id')
                ->orderBy('id', 'DESC')
                ->where('activo', "1")
                ->paginate(10),
            'pager' => $this->odontologoModel->pager,
        ];

        return view('odontologos/index', $data);
    }
    public function show($id)
    {
        $odontologo = $this->odontologoModel
            ->asObject()
            ->select('odontologos.*, auth_identities.secret AS email, users.username')
            ->join('users', 'users.id = odontologos.user_id')
            ->join('auth_identities', 'auth_identities.user_id = users.id AND auth_identities.type = "email_password"')
            ->where('odontologos.id', $id)
            ->get()
            ->getRow();
        //si no encuentra el odontologo  redirige errror

        if (!$odontologo) {
            return redirect()->to('odontologos')->with('error', 'Odontologo no encontrado');
        }
        return view('odontologos/show', [
            'title' => 'Datos generales del Odontólogo',
            'odontologo' => $odontologo,
        ]);
    }

    public function new()
    {
        $data = ['title' => 'Nuevo Odontologo'];

        return view('odontologos/create', $data);
    }



    public function create()
    {
        if ($this->validate('odontologosvalidation')) {

            $auth = auth();

            // Crear usuario
            $user = new User([
                'username' => $this->request->getPost('username'),
                'email'    => $this->request->getPost('email'),
                'password' => $this->request->getPost('password'),
            ]);

            $userModel = model(ShieldUserModel::class);

            // Guardar el usuario en la tabla users y entities
            if (!$userModel->save($user)) {
                return redirect()->back()->with('error', 'Error al guardar el usuario')->withInput();
            }

            // Obtener el ID del usuario recién creado
            $userId = $userModel->getInsertID();

            // Cargar usuario guardado para añadir al grupo
            $newUser = $userModel->find($userId);
            $newUser->addGroup('odontologo');
            $userModel->save($newUser); // importante guardar otra vez para persistir el grupo

            $this->odontologoModel->insert([
                'user_id' => $userId,
                'nombre' => $this->request->getPost('nombre'),
                'apellido' => $this->request->getPost('apellido'),
                'cedula' => $this->request->getPost('cedula'),
                'especialidad' => $this->request->getPost('especialidad'),
                'telefono' => $this->request->getPost('telefono'),
                'direccion' => $this->request->getPost('direccion'),
                'activo' => 1,
                'genero' => $this->request->getPost('genero'),
                'fecha_nacimiento' => $this->request->getPost('fecha_nacimiento'),
            ]);

            return redirect()->to('odontologos')->with('mensaje', 'Registro creado de manera exitosa');
        } else {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }
    }




    public function edit($id)
    {
        $odontologo = $this->odontologoModel
            ->asObject()
            ->select('odontologos.*, auth_identities.secret AS email, users.username')
            ->join('users', 'users.id = odontologos.user_id')
            ->join('auth_identities', 'auth_identities.user_id = users.id AND auth_identities.type = "email_password"')
            ->where('odontologos.id', $id)
            ->get()
            ->getRow();
        //si no encuentra el odontologo  redirige errror

        if (!$odontologo) {
            return redirect()->to('odontologos')->with('error', 'Odontologo no encontrado');
        }
        //  Esto imprimirá el objeto en pantalla
        //    var_dump($odontologo);
        //exit;
        return view('odontologos/edit', [
            'title' => 'Editar Informacion del Odontologo',
            'odontologo' => $odontologo,
        ]);
    }

    public function update($id)
    {
        if (!$this->validate('odontvalidateUpdate')) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Buscar odontólogo
        $odontologo = $this->odontologoModel->asObject()->find($id);
        if (!$odontologo) {
            return redirect()->to('odontologos')->with('error', 'Odontólogo no encontrado');
        }

        // Actualizar datos del odontólogo
        $this->odontologoModel->update($id, [
            'nombre'           => $this->request->getPost('nombre'),
            'apellido'         => $this->request->getPost('apellido'),
            'cedula'           => $this->request->getPost('cedula'),
            'especialidad'     => $this->request->getPost('especialidad'),
            'telefono'         => $this->request->getPost('telefono'),
            'direccion'        => $this->request->getPost('direccion'),
            'genero'           => $this->request->getPost('genero'),
            'fecha_nacimiento' => $this->request->getPost('fecha_nacimiento'),
        ]);

        // Actualizar username y email del usuario relacionado
        $userModel = model(\CodeIgniter\Shield\Models\UserModel::class);
        // $user = $userModel->find($odontologo->user_id);
        $user = $userModel->asObject()->find($odontologo->user_id);
        if ($user) {
            // Actualizar username
            $user->username = $this->request->getPost('username');

            //verifica si hayu  una nueva contraseña 

            $newpassword = trim($this->request->getPost('password'));
            if (!empty($newpassword)) {
                $user->password = $newpassword;
            }


            $userModel->save($user);

            // Actualizar email en auth_identities
            $db = \Config\Database::connect();
            $db->table('auth_identities')
                ->where('user_id', $odontologo->user_id)
                ->where('type', 'email_password')
                ->update(['secret' => $this->request->getPost('email')]);
        }

        return redirect()->to('odontologos')->with('mensaje', 'Registro actualizado correctamente');
    }

    public function delete($id)
    {
        $this->odontologoModel->update($id, ['activo' => '0']);
        return redirect()->to('odontologos')->with('success', 'Odontologo desactivado correctamente');
    }

    public function search()
    {
        $term = $this->request->getGet('term');
        $odontologos = $this->odontologoModel->like('nombre', $term)
            ->orLike('apellido', $term)
            ->orLike('dni', $term)
            ->findAll();

        return $this->response->setJSON($odontologos);
    }



}