<?php

namespace App\Controller;

use Core\Controller\AController;
use App\Entity\Post;

class BlogController extends AController
{

    private $post;

    public function __construct() {
        $this->post = new Post();
    }

    public function show() {
        $headTitle = 'Blog - Romain Royer';

        $posts = $this->post->getPosts();
        //var_dump($posts);

        $this->render('blog.html.twig', [
            'headTitle' => $headTitle,
            'posts' => $posts
        ]);
    }
}