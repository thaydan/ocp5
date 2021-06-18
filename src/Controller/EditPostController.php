<?php

namespace App\Controller;

use Core\Controller\AController;
use App\Entity\Post;

class EditPostController extends AController
{

    private $post;

    public function __construct() {
        $this->post = new Post();
    }

    public function edit($slug = null) {

        if($slug) {
            $post = $this->post->getPost($slug)[0];
        }

        $headTitle = $post['title'] . ' - Romain Royer';


        $this->render('edit-post.html.twig', [
            'headTitle' => $headTitle,
            'post' => $post
        ]);
    }

    public function save(){

    }

}