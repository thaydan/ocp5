<?php

namespace App\Controller;

use Core\Controller\AController;
use Core\Form\Constraint\NotBlankConstraint;
use Core\Form\Constraint\NotNullConstraint;
use Core\Form\Form;
use Core\Form\Type\AFormType;
use Core\Form\Type\SubmitType;
use Core\Form\Type\TextAreaType;
use Core\Form\Type\TextType;

class ContactController extends AController
{

    public function __construct() {
    }

    public function show() {
        $headTitle = 'Contact - Romain Royer';

        $formContact = new Form(
            [
                'username' => new TextType(
                    [
                        new NotNullConstraint(),
                        new NotBlankConstraint()
                    ],
                    [
                        'label' => 'Nom d\'utilisateur'
                    ]
                ),
                'content' => new TextAreaType(
                    [
                        new NotNullConstraint(),
                        new NotBlankConstraint()
                    ],
                    [
                        'label' => 'Contenu'
                    ]
                ),
                'submit' => new SubmitType()
            ]
        );

        $this->render('contact.html.twig', [
            'headTitle' => $headTitle
        ]);
    }
}