<?php

namespace App\Controller;

use Core\Controller\AController;
use App\View\View;

class Contact extends AController
{

    private $post;

    public function __construct() {
        //$this->post = new \Model\Post();
    }

    public function show() {
        $headTitle = 'Blog - Romain Royer';

        //$posts = $this->post->getPosts();

        $posts = '';

        $this->render('contact.html.twig', [
            'headTitle' => $headTitle,
            'posts' => $posts
        ]);
    }
}