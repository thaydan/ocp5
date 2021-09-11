<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Core\Controller\AController;
use Core\Form\Constraint\NotBlankConstraint;
use Core\Form\Constraint\NotNullConstraint;
use Core\Form\Form;
use Core\Form\Type\{AFormType, PasswordType, SubmitType, TextAreaType, TextType};

class HomeController extends AController
{

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function show()
    {
        $contactController = new ContactController();
        $formContact = $contactController->newContactForm();

        $headTitle = 'Romain Royer';

        $postRepository = new PostRepository();
        $posts = $postRepository->findAll(6);        // AJOUTER LIMIT 6 POSTS

        $this->render('home.html.twig', [
            'headTitle' => $headTitle,
            'posts' => $posts,
            'formContact' => $formContact
        ]);

    }

}