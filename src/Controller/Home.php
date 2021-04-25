<?php

namespace App\Controller;

use Core\Controller\AController;

class Home extends AController
{

    public function show()
    {

        $headTitle = 'Romain Royer';

        $this->render('home.html.twig', [
            'headTitle' => $headTitle
        ]);

    }

}