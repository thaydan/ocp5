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

        $formLogin->handleRequest();

        if ($formLogin->isSubmitted() && $formLogin->isValid()) {
            if ($formLogin) {
                $datas = $formLogin->getData();
            }
            Auth::login($datas['id'], $datas['password']);
            //dump(Auth::isConnected(), Auth::getUser());
        }

        if (Auth::isConnected()) {
            header('Location: /dashboard');
            exit;
        }

        $headTitle = 'Login - Romain Royer';

        $this->render('login.html.twig', [
            'headTitle' => $headTitle,
            'formLogin' => $formLogin
        ]);
    }

}