<?php

namespace App\Controller;

use Core\Controller\AController;

class LegalNoticeController extends AController
{

    private string $headTitle;

    public function __construct()
    {
        $this->headTitle = 'Mentions légales - Romain Royer';
    }

    public function show()
    {
        $this->render('legal-notice.html.twig', [
            'headTitle' => $this->headTitle
        ]);
    }

}