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
        $formContact = new Form(
            [
                'name' => new TextType(
                    [
                        new NotNullConstraint(),
                        new NotBlankConstraint()
                    ],
                    [
                        'label' => 'Nom'
                    ]
                ),
                'email' => new TextType(
                    [
                        new NotNullConstraint(),
                        new NotBlankConstraint()
                    ],
                    [
                        'label' => 'Adresse e-mail'
                    ]
                ),
                'phone' => new TextType(
                    [
                        new NotNullConstraint(),
                        new NotBlankConstraint()
                    ],
                    [
                        'label' => 'Téléphone'
                    ]
                ),
                'message' => new TextAreaType(
                    [
                        new NotNullConstraint(),
                        new NotBlankConstraint()
                    ],
                    [
                        'label' => 'Message'
                    ]
                ),
                'submit' => new SubmitType(
                    [],
                    [
                        'label' => 'Envoyer'
                    ]
                )
            ]
        );

        $formContact->handleRequest();

        $headTitle = 'Romain Royer';

        $postRepository = new PostRepository();
        $posts = $postRepository->findAll();        // AJOUTER LIMIT 6 POSTS

        $this->render('home.html.twig', [
            'headTitle' => $headTitle,
            'posts' => $posts,
            'formContact' => $formContact
        ]);

    }

}