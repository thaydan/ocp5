<?php

namespace App\Controller;

use App\Model\Post;
use App\View\View;
use Core\Controller\AController;

class Blog extends AController
{

    private $post;

    public function __construct() {
        //$this->post = new \Model\Post();
    }

    public function show() {

        $headTitle = 'Blog - Romain Royer';

        //$posts = $this->post->getPosts();

        $posts = '';

        $this->render('blog.html.twig', [
            'headTitle' => $headTitle,
            'posts' => $posts
        ]);

        /*$view = new \View("Blog");
        $view->render(array('head_title' => $head_title
        ));*/
    }
}