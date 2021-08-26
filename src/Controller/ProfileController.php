<?php


namespace App\Controller;

use App\Repository\CommentRepository;
use App\Repository\UserRepository;
use Core\Controller\AController;
use Core\Form\Constraint\NotBlankConstraint;
use Core\Form\Constraint\NotNullConstraint;
use Core\Form\Form;
use Core\Form\Type\HiddenType;
use Core\Form\Type\SubmitType;
use Core\Form\Type\TextAreaType;
use Core\Form\Type\TextType;
use Core\Security\Auth;
use Core\Security\BadAuthenticationException;

class ProfileController extends AController
{

    public function show()
    {
        $headTitle = 'Profil - Romain Royer';
        $userRepository = new UserRepository();

        $formNewPassword = new Form(
            [
                'oldPassword' => new HiddenType(
                    [
                        new NotNullConstraint(),
                        new NotBlankConstraint()
                    ],
                    [
                        'label' => 'Ancien mot de passe'
                    ]
                ),
                'newPassword1' => new HiddenType(
                    [
                        new NotNullConstraint(),
                        new NotBlankConstraint()
                    ],
                    [
                        'label' => 'Nouveau mot de passe'
                    ]
                ),
                'newPassword2' => new HiddenType(
                    [
                        new NotNullConstraint(),
                        new NotBlankConstraint()
                    ],
                    [
                        'label' => 'Répéter le nouveau mot de passe'
                    ]
                ),
                'submit' => new SubmitType(
                    [],
                    [
                        'label' => 'Modifier'
                    ]
                )
            ]
        );

        $formNewPassword->handleRequest();
        if ($formNewPassword->isSubmitted() && $formNewPassword->isValid()) {
            $user = $userRepository->find(Auth::getUser()->getID());
            $datas = $formNewPassword->getData();

            if (!password_verify($datas['oldPassword'], $user->getPassword())) {
                throw new \Exception('Ancien mot de passe incorrect');
            }

            if ($datas['newPassword1'] !== $datas['newPassword2']) {
                throw new \Exception('Vous avez fait une erreur en recopiant votre nouveau mot de passe');
            }
            $userRepository->edit([
                'id' => $user->getID(),
                'password' => password_hash($datas['newPassword1'], PASSWORD_DEFAULT)
            ]);
        }

        $formNewAdmin = new Form(
            [
                'email' => new TextType(
                    [
                        new NotNullConstraint(),
                        new NotBlankConstraint()
                    ],
                    [
                        'label' => 'Adresse e-mail'
                    ]
                ),
                'firstName' => new TextType(
                    [
                        new NotNullConstraint(),
                        new NotBlankConstraint()
                    ],
                    [
                        'label' => 'Prénom'
                    ]
                ),
                'lastName' => new TextType(
                    [
                        new NotNullConstraint(),
                        new NotBlankConstraint()
                    ],
                    [
                        'label' => 'Nom de famille'
                    ]
                ),
                'username' => new TextType(
                    [
                        new NotNullConstraint(),
                        new NotBlankConstraint()
                    ],
                    [
                        'label' => 'Pseudo'
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
                        'label' => 'Créer le compte'
                    ]
                )
            ]
        );

        $formNewAdmin->handleRequest();
        if ($formNewAdmin->isSubmitted() && $formNewAdmin->isValid()) {
            $datas = $formNewAdmin->getData();

            $userRepository->add([
                'username' => $datas['username'],
                'first_name' => $datas['firstName'],
                'last_name' => $datas['lastName'],
                'email' => $datas['email'],
                'password' => password_hash($datas['password'], PASSWORD_DEFAULT)
            ]);
        }

        $users = $userRepository->findAll();
        $commentRepository = new CommentRepository();
        $comments = $commentRepository->findBy([
            'validated' => 0
        ],
            'datetime DESC'
        );

        $this->render('profile.html.twig', [
            'headTitle' => $headTitle,
            'formNewPassword' => $formNewPassword,
            'formNewAdmin' => $formNewAdmin,
            'users' => $users,
            'comments' => $comments
        ]);
    }

    public function deleteUser($id)
    {
        $userRepo = new UserRepository();
        $userRepo->delete($id);

        $this->redirect('/profile');
    }

}