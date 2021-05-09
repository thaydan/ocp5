<?php

namespace App\Controller;

use Core\Controller\AController;

class Contact extends AController
{

    public function __construct() {
    }

    public function show() {
        $headTitle = 'Blog - Romain Royer';

        $this->render('contact.html.twig', [
            'headTitle' => $headTitle
        ]);
    }
}