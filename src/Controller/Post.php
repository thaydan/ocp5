<?php

namespace App\Controller;

use App\Model\Post;
use App\View\View;
use Core\Controller\AController;

class Post extends AController
{

    private $post;

    public function __construct() {
        $this->post = new \Model\Post();
    }

    public function show($slug) {

        //$post = $this->post->getPost($slug);
        $post = '';

        $headTitle = $post['title'] . ' - Romain Royer';


        $this->render('post.html.twig', [
            'headTitle' => $headTitle,
            'post' => $post
        ]);

        /*$view = new \View("Post");
        $view->render(array('head_title' => $head_title,
            'post' => $post
        ));*/
    }
}