<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Core\Controller\AController;

class PostController extends AController
{
    public function show($slug) {

        $postRepository = new PostRepository();
        $post = $postRepository->findOneBy(['slug' => $slug]);

        $headTitle = $post->title . ' - Romain Royer';


        $this->render('post.html.twig', [
            'headTitle' => $headTitle,
            'post' => $post
        ]);
    }
}