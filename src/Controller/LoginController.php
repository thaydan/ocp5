<?php

namespace App\Controller;

use Core\Controller\AController;
use Core\Form\Constraint\NotBlankConstraint;
use Core\Form\Constraint\NotNullConstraint;
use Core\Form\Form;
use Core\Form\Type\HiddenType;
use Core\Form\Type\PasswordType;
use Core\Form\Type\SubmitType;
use Core\Form\Type\TextType;
use Core\Security\Auth;

class LoginController extends AController
{

    public function login()
    {
        $formLogin = new Form(
            [
                'email' => new TextType(
                    [
                        new NotNullConstraint(),
                        new NotBlankConstraint()
                    ],
                    [
                        'label' => 'Identifiant'
                    ]
                ),
                'password' => new HiddenType(
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

        $formLogin->handleRequest();

        if ($formLogin->isSubmitted() && $formLogin->isValid()) {
            if ($formLogin) {
                $datas = $formLogin->getData();
            }
            Auth::login($datas['email'], $datas['password']);
        }

        if (Auth::isConnected()) {
            $this->redirect('/profil');
        }

        $headTitle = 'Login - Romain Royer';

        $this->render('login.html.twig', [
            'headTitle' => $headTitle,
            'formLogin' => $formLogin
        ]);
    }

}