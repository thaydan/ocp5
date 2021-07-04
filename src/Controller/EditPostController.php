<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Core\Controller\AController;
use App\Entity\Post;

class EditPostController extends AController
{

    private $post;

    public function __construct() {
        $this->post = new Post();
    }

    public function edit($slug = null) {

        $post = [
            'title' => 'Nouvel article',
            'desc' => 'Description du nouvel article',
            'content' => 'Contenu du nouvel article'
        ];

        $headTitle = 'Nouvel article - Romain Royer';

        $postRepository = new PostRepository();
        if ($_POST) {
            $post = $postRepository->edit($slug, $_POST);
        }

        if($slug) {
            $post = $postRepository->findOneBy(['slug' => $slug]);
            $headTitle = $post->title . ' - Romain Royer';
        }

        //$formLogin->handleRequest();


        $this->render('edit-post.html.twig', [
            'headTitle' => $headTitle,
            'post' => $post
        ]);
    }

    public function save(){

    }

}