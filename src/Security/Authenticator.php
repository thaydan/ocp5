<?php


namespace App\Security;


use App\Entity\User;
use Core\Entity\IUser;
use Core\Security\IAuthenticator;

class Authenticator implements IAuthenticator
{

    public function getUser($username): ?IUser
    {
        // TO DO recup en bdd

        return (new User())->setID(1)->setUsername($username)->setPassword(password_hash('azerty', PASSWORD_DEFAULT));
    }

    public function checkPassword(IUser $user, string $password): bool
    {
        return password_verify($password, $user->getPassword());
    }
}