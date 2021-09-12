<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Core\Controller\AController;
use Core\Form\Constraint\IsValidEmailConstraint;
use Core\Form\Constraint\NotBlankConstraint;
use Core\Form\Constraint\NotNullConstraint;
use Core\Form\Form;
use Core\Form\Type\SubmitType;
use Core\Form\Type\TextAreaType;
use Core\Form\Type\TextType;
use Core\Security\Auth;

class PostController extends AController
{
    public function show($slug)
    {

        $postRepository = new PostRepository();
        $post = $postRepository->findOneBy(['slug' => $slug]);

        if (!$post) {
            throw new \Exception('Aucun article ne correspond à cet identifiant');
        }

        $userRepo = new UserRepository();
        $post->author = (array)$userRepo->find($post->author_id, ['id', 'first_name']);

        $commentRepository = new CommentRepository();
        if (Auth::isConnected()) {
            $comments = $commentRepository->findBy([
                'id_post' => $post->id
            ],
                'datetime DESC'
            );
        } else {
            $comments = $commentRepository->findBy([
                'id_post' => $post->id,
                'validated' => 1
            ],
                'datetime DESC'
            );
        }

        $formAddComment = $this->newFormAddComment();

        $headTitle = $post->title . ' - Romain Royer';

        $this->render('post.html.twig', [
            'headTitle' => $headTitle,
            'post' => $post,
            'comments' => $comments,
            'formAddComment' => $formAddComment
        ]);
    }

    public function addComment($slug)
    {
        $formAddComment = $this->newFormAddComment();
        $formAddComment->handleRequest();

        if (!$formAddComment->isSubmitted() or !$formAddComment->isValid()) {
            throw new \Exception('Les champs n\'ont pas été remplis correctement.');
        }

        $datas = $formAddComment->getData();
        unset($datas['submit']);

        $postRepository = new PostRepository();
        $post = $postRepository->findOneBy(['slug' => $slug]);

        $datas['id_post'] = $post->id;

        $commentRepository = new CommentRepository();
        $commentRepository->add($datas);

        $headTitle = $post->title . ' - Romain Royer';

        $this->render('add-comment-success.html.twig', [
            'headTitle' => $headTitle,
            'post_slug' => $slug
        ]);
    }

    public function newFormAddComment()
    {
        return new Form(
            [
                'author_name' => new TextType(
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
                        new NotBlankConstraint(),
                        new IsValidEmailConstraint()
                    ],
                    [
                        'label' => 'Adresse e-mail'
                    ]
                ),
                'comment' => new TextAreaType(
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

    }

}