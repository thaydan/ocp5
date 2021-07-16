<?php

namespace Core\Controller;

use Core\Form\Form;
use Core\Security\Auth;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

abstract class AController
{

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
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
                    dump($var, ...$vars);
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
             * @throws \Twig\Error\LoaderError
             * @throws \Twig\Error\RuntimeError
             * @throws \Twig\Error\SyntaxError
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
        header('Location: '. $location);
        exit;
    }

}