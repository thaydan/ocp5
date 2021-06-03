<?php

namespace App\Controller;

use Core\Controller\AController;
use App\Entity\Post;

class PostController extends AController
{

    private $post;

    public function __construct() {
        $this->post = new Post();
    }

    public function show($slug) {

        $post = $this->post->getPost($slug)[0];

        $headTitle = $post['title'] . ' - Romain Royer';


        $this->render('post.html.twig', [
            'headTitle' => $headTitle,
            'post' => $post
        ]);
    }
}