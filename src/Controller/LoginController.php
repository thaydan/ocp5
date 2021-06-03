<?php


namespace App\Controller;

use Core\Controller\AController;
use Core\Form\Constraint\NotBlankConstraint;
use Core\Form\Constraint\NotNullConstraint;
use Core\Form\Form;
use Core\Form\Type\AFormType;
use Core\Form\Type\PasswordType;
use Core\Form\Type\SubmitType;
use Core\Form\Type\TextAreaType;
use Core\Form\Type\TextType;
use Core\Security\Auth;

class LoginController extends AController
{

    public function login()
    {
        $formLogin = new Form(
            [
                'id' => new TextType(
                    [
                        new NotNullConstraint(),
                        new NotBlankConstraint()
                    ],
                    [
                        'label' => 'Identifiant'
                    ]
                ),
                'password' => new PasswordType(
                    [
                        new NotNullConstraint(),
                        new NotBlankConstraint()
                    ],
                    [
                        'label' => 'Mot de passe'
                    ]
                ),
                'submit' => new SubmitType(
                    [],
                    [
                        'label' => 'S\'identifier'
                    ]
                )
            ]
        );

        /*$formContact = new Form(
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
        );*/

        $formLogin->handleRequest();

        if ($formLogin->isSubmitted() && $formLogin->isValid()) {
            if ($formLogin) {
                $datas = $formLogin->getData();
            }
            Auth::login($datas['id'], $datas['password']);
            //dump(Auth::isConnected(), Auth::getUser());
        }

        // if identifiant ok
        // do login
        // then redirect
        // verification des champs
        // if not login, show again login page with error message

        $headTitle = 'Login - Romain Royer';

        $this->render('login.html.twig', [
            'headTitle' => $headTitle,
            'formLogin' => $formLogin
        ]);
    }

}