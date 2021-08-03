<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\PostRepository;
use Core\Controller\AController;

class BlogController extends AController
{

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function show() {
        $headTitle = 'Blog - Romain Royer';

        $postRepository = new PostRepository();
        $posts = $postRepository->findAll();

        $this->render('blog.html.twig', [
            'headTitle' => $headTitle,
            'posts' => $posts
        ]);
    }
}