<?php

namespace Core\Controller;

use Core\Form\Form;
use Core\Security\Auth;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

abstract class AController
{

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */

    protected function render(string $name, array $context = []): void
    {
        $loader = new FilesystemLoader(['../template', '../core/Template']);
        $twig = new Environment(
            $loader,
            [
                'cache' => ($_SERVER['APP_ENV'] === 'prod') ? '../var/cache/twig' : false,
            ]
        );

        $twig->addGlobal('app', [
            'connected' => Auth::isConnected(),
            'user' => Auth::getUser()
        ]);

        $twig->addFunction(
            new TwigFunction(
                'dump',
                function ($var, ...$vars) {
                    var_dump($var, ...$vars);
                }
            )
        );

        $twig->addFunction(
            new TwigFunction(
                'showComments',
                function ($comments) use ($twig) {
                    $twig->display(
                        'comments/comments.html.twig',
                        [
                            'comments' => $comments
                        ]
                    );
                }
            )
        );

        $twig->addFunction(
            new TwigFunction(
                'className',
                function ($object) {
                    $fullClassName = get_class($object);
                    $split = explode('\\', $fullClassName);
                    return $split[count($split) - 1];
                }
            )
        );

        $twig->addFunction(
            new TwigFunction(
            /**
             * @param Form $form
             * @throws LoaderError
             * @throws RuntimeError
             * @throws SyntaxError
             */ 'form',
                function (Form $form) use ($twig) {
                    $twig->display(
                        'form/form.html.twig',
                        [
                            'form' => $form
                        ]
                    );
                }
            )
        );

        echo $twig->render($name, $context);
    }

    protected function redirect(string $location)
    {
        header('Location: ' . $location);
        exit;
    }

}