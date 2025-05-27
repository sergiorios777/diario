<?php

namespace App\Controllers;

class DashboardController extends AppBaseController
{
    public function index()
    {
        // Aquí puedes agregar la lógica para mostrar el dashboard
        return view('dashboard/index');
    }

    public function settings()
    {
        // Aquí puedes agregar la lógica para mostrar la configuración del dashboard
        return view('dashboard/settings');
    }

    public function profile()
    {
        // Aquí puedes agregar la lógica para mostrar el perfil del usuario
        return view('dashboard/profile');
    }
}
