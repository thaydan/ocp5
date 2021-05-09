<?php


namespace App\Controller;


use Core\Controller\AController;

class Login extends AController
{

    public function __construct()
    {
    }

    public function Login ()
    {
        $this->sql('select * from posts');
        $headTitle = 'Blog - Romain Royer';

        $this->render('login.html.twig', [
            'headTitle' => $headTitle
        ]);
    }

}