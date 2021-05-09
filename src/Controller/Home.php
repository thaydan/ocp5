<?php

namespace App\Controller;

use Core\Controller\AController;

class Home extends AController
{

    public function show()
    {

        $posts = $this->sql('select * from posts');

        //var_dump($posts);
        $headTitle = 'Romain Royer';

        $this->render('home.html.twig', [
            'headTitle' => $headTitle,
            'posts' => $posts
        ]);

    }

}