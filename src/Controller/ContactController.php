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
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class ContactController extends AController
{

    private string $headTitle;

    public function __construct()
    {
        $this->headTitle = 'Contact - Romain Royer';
    }

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

        $this->render('contact.html.twig', [
            'headTitle' => $this->headTitle,
            'formContact' => $formContact
        ]);
    }

    public function send()
    {
        // Create the Transport
        $transport = (new Swift_SmtpTransport('smtp.ionos.fr', 587, 'tls'))
            ->setUsername('ocp5@rominfo.fr')
            ->setPassword('#G%r.+D5P9!zz;c')
        ;

        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);

        // Create a message
        $messageAdmin = (new Swift_Message('Nouvelle demande de contact'))
            ->setFrom(['contact@rominfo.fr' => 'Romain Royer'])
            ->setTo(['contact@rominfo.fr', 'rominoudu85@gmail.com' => 'Romain Royer'])
            ->setReplyTo([$_POST['email'] => $_POST['name']])
            ->setBody(
                '<p>Bonjour Romain,<br>Vous avez une nouvelle demande de contact.</p>
                    <p>Nom : ' . $_POST['name'] . '<br>
                    Adresse e-mail : ' . $_POST['email'] . '<br>
                    Téléphone : ' . $_POST['phone'] . '<br>
                    Message : <br>' . htmlentities($_POST['message']) . '</p>',
                'text/html'
            );

        $messageUser = (new Swift_Message('Votre message a bien été envoyé.'))
            ->setFrom(['contact@rominfo.fr' => 'Romain Royer'])
            ->setTo([$_POST['email'] => $_POST['name']])
            ->setBody(
                '<p>Bonjour ' . $_POST['name'] . ',<br>Nous avons bien reçu votre message. Vous recevrez une réponse très rapidement.</p>
                    <p>Voici votre message :<br>' . htmlentities($_POST['message']) . '</p>',
                'text/html'
            );

        // Send the message
        $result = $mailer->send($messageAdmin);
        if ($result) {
            $result = $mailer->send($messageUser);
        }

        if ($result) {
            $this->render('contactConfirmation.html.twig', [
                'headTitle' => $this->headTitle
            ]);
        } else {
            $this->show();
        }

    }

}