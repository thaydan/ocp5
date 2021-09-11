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
use mysql_xdevapi\Exception;
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
        $formContact = $this->newContactForm();

        $this->render('contact.html.twig', [
            'headTitle' => $this->headTitle,
            'formContact' => $formContact
        ]);
    }

    public function send()
    {
        $formContact = $this->newContactForm();
        $formContact->handleRequest();

        if (!$formContact->isSubmitted() OR !$formContact->isValid()) {
            throw new \Exception('Les champs n\'ont pas été remplis correctement.');
        }

        $datas = $formContact->getData();

        if (empty($_ENV['CONTACT_FORM_RECIPIENT'])) {
            throw new \Exception('Aucun destinataire n\'est défini pour réceptionner la demande de contact.
                                                Veuillez indiquer une adresse e-mail dans le fichier .env, puis réessayez.');
        }

        // Create the Transport
        $transport = (new Swift_SmtpTransport($_ENV['EMAIL_HOST'], $_ENV['EMAIL_PORT'], $_ENV['EMAIL_ENCRYPTION']))
            ->setUsername($_ENV['EMAIL_LOGIN'])
            ->setPassword($_ENV['EMAIL_PASSWORD']);

        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);

        // Create a message
        $messageAdmin = (new Swift_Message('Nouvelle demande de contact'))
            ->setFrom(['contact@rominfo.fr' => 'Romain Royer'])
            ->setTo([$_ENV['CONTACT_FORM_RECIPIENT']])
            ->setReplyTo([$datas['email'] => $datas['name']])
            ->setBody(
                '<p>Bonjour Romain,<br>Vous avez une nouvelle demande de contact.</p>
                    <p>Nom : ' . $datas['name'] . '<br>
                    Adresse e-mail : ' . $datas['email'] . '<br>
                    Téléphone : ' . $datas['phone'] . '<br>
                    Message : <br>' . htmlentities($datas['message']) . '</p>',
                'text/html'
            );

        $messageUser = (new Swift_Message('Votre message a bien été envoyé.'))
            ->setFrom(['contact@rominfo.fr' => 'Romain Royer'])
            ->setTo([$datas['email'] => $datas['name']])
            ->setBody(
                '<p>Bonjour ' . $datas['name'] . ',<br>Nous avons bien reçu votre message. Vous recevrez une réponse très rapidement.</p>
                    <p>Voici votre message :<br>' . htmlentities($datas['message']) . '</p>',
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

    public function newContactForm()
    {
        return new Form(
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
    }

}