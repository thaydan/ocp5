<?php

namespace App\Controller;

use Core\Controller\AController;

class ErrorController extends AController
{

    public function defaultError($error)
    {
        header('HTTP/1.0 404 Not Found');

        $this->render('error.html.twig', [
            'error' => $error
        ]);
    }
}

?>