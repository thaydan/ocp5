<?php


namespace App\Controller;

use Core\Controller\AController;

class ProfileController extends AController
{

    public function show ()
    {
        $headTitle = 'Profil - Romain Royer';

        $this->render('profile.html.twig', [
            'headTitle' => $headTitle
        ]);
    }

}