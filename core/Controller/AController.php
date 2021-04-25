<?php

namespace Core\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class AController
{
    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    protected function render(string $name, array $context = []): void
    {
        $loader = new FilesystemLoader('../template');
        $twig = new Environment(
            $loader,
            [
                'cache' => ($_SERVER['APP_ENV'] === 'prod') ? '../var/cache/twig' : false,
            ]
        );

        echo $twig->render($name, $context);
    }
}