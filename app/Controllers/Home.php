<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // Redirect to login page instead of showing welcome message
        return redirect()->to('auth/login');
    }
}
