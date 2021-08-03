<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Core\Controller\AController;
use Core\Form\Constraint\NotBlankConstraint;
use Core\Form\Constraint\NotNullConstraint;
use Core\Form\Form;
use Core\Form\Type\SubmitType;
use Core\Form\Type\TextAreaType;
use Core\Form\Type\TextType;

class PostController extends AController
{
    public function show($slug) {

        $postRepository = new PostRepository();
        $post = $postRepository->findOneBy(['slug' => $slug]);

        if(!$post) {
            throw new \Exception('Aucun article ne correspond à cet identifiant');
        }

        $formAddComment = new Form(
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
                'message' => new TextAreaType(
                    [
                        new NotNullConstraint(),
                        new NotBlankConstraint()
                    ],
                    [
                        'label' => 'Commentaire'
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

        $headTitle = $post->title . ' - Romain Royer';

        $this->render('post.html.twig', [
            'headTitle' => $headTitle,
            'post' => $post,
            'formAddComment' => $formAddComment
        ]);
    }
}