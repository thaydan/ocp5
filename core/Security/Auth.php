<?php


namespace Core\Security;

use Core\Entity\IUser;

abstract class
Auth
{
    const SESSION_NAME = 'USER';
    const USER_CLASS = 'App\Entity\User';
    const AUTHENTICATOR_CLASS = 'App\Security\Authenticator';

    static function login($username, $password)
    {
        if (!class_exists(self::USER_CLASS) || !class_exists(self::AUTHENTICATOR_CLASS)) {
            throw new \Exception('You need to create ' . self::USER_CLASS . ' and ' . self::AUTHENTICATOR_CLASS);
        }

        if (
            !is_subclass_of(self::USER_CLASS, IUser::class) ||
            !is_subclass_of(self::AUTHENTICATOR_CLASS, IAuthenticator::class)
        ) {
            throw new \Exception(
                self::USER_CLASS . ' must to be an instance of ' . IUser::class .
                ' and ' . self::AUTHENTICATOR_CLASS . ' must to be an instance of ' . IAuthenticator::class
            );
        }

        /** @var IAuthenticator $authenticator */
        $AUTHENTICATOR_CLASS = self::AUTHENTICATOR_CLASS;
        $authenticator = new $AUTHENTICATOR_CLASS;
        $user = $authenticator->getUser($username);

        if (!$user) {
            throw new BadAuthenticationException('Bad username');
        }

        if (!$authenticator->checkPassword($user, $password)) {
            throw new BadAuthenticationException('Bad password');
        }
        $user->sanitize();

        $_SESSION[self::SESSION_NAME] = $user;
    }

    static function getUser(): ?IUser
    {
        return $_SESSION[self::SESSION_NAME] ?? null;
    }

    static function isConnected(): bool
    {
        return !empty(self::getUser());
    }

    static function logout()
    {
        unset($_SESSION[self::SESSION_NAME]);
    }
}