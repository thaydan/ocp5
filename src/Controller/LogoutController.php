<?php


namespace App\Controller;

use Core\Controller\AController;
use Core\Security\Auth;

class LogoutController extends AController
{

    public function logout()
    {
        Auth::logout();
        header('Location: /login');
        exit;
    }

}