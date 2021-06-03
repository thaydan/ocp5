<?php


namespace App\Controller;

use Core\Controller\AController;
use Core\Security\Auth;

class DashboardController extends AController
{

    public function dashboard()
    {
        //$posts = $this->;
        $headTitle = 'Romain Royer';

        $this->render('home.html.twig', [
            'headTitle' => $headTitle
        ]);
    }

}