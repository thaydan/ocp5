<?php


namespace App\Security;


use App\Entity\User;
use App\Repository\UserRepository;
use Core\Entity\IUser;
use Core\Security\IAuthenticator;

class Authenticator implements IAuthenticator
{

    public function getUser($username): ?IUser
    {
        $userRepo = new UserRepository();
        $user = $userRepo->findOneBy(['username' => $username]);

        if($user) {
            return (new User())->setID($user->getID())->setUsername($user->getUsername())->setPassword($user->getPassword());
        }
        return null;
    }

    public function checkPassword(IUser $user, string $password): bool
    {
        return password_verify($password, $user->getPassword());
    }
}