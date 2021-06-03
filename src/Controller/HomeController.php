<?php

namespace App\Controller;

use Core\Controller\AController;

class HomeController extends AController
{

    public function show()
    {

        //$posts = $this->;
        $headTitle = 'Romain Royer';

        $this->render('home.html.twig', [
            'headTitle' => $headTitle
        ]);

    }

}