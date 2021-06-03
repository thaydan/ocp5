<?php


namespace Core\Security;


use Core\Entity\IUser;

interface IAuthenticator
{
    public function getUser($username): ?IUser;

    public function checkPassword(IUser $user, string $password): bool;
}