<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\PostRepository;
use Core\Controller\AController;

class BlogController extends AController
{

    public function show() {
        $headTitle = 'Blog - Romain Royer';

        //$posts = $this->post->getPosts();
        //var_dump($posts);

        $postRepository = new PostRepository();
        $posts = $postRepository->findAll();
        //dd($posts);

        /*$userRepository = new UserRepository();
        $user = $userRepository->findOneBy(['email' => 'romain']);
        //dd($user);*/

        $this->render('blog.html.twig', [
            'headTitle' => $headTitle,
            'posts' => $posts
        ]);
    }
}