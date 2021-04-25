<?php

namespace App\Controller;

use Core\Controller\AController;

class DefaultController extends AController
{
    public function homepageAction()
    {
        $name = 'Fabien';
        $this->render('index.html.twig', [
            'name' => $name
        ]);
    }
}
}