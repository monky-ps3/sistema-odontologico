<?php 
namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // Verificar autenticación básica
        if (!auth()->loggedIn()) {
            return redirect()->to('login');
        }

        // Obtener el usuario actual
        $user = auth()->user();
        
        // Verificar grupos usando la relación directa
        $groups = $user->getGroups(); // Método directo de Shield

        // Redirección por roles
        if (in_array('admin', $groups) || in_array('recepcionista', $groups)) {
            return redirect()->to('dashboard');
        }

        if (in_array('odontologo', $groups)) {
            return redirect()->to('odontologo/citas-hoy');
        }

        return redirect()->to('login')->with('error', 'Rol no asignado');
    }
}
