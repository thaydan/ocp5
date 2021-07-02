<?php


namespace App\Repository;


use App\Entity\User;
use Core\Repository\ARepository;

/**
 * @method User find(int $id)
 * @method User findOneBy(array $filters)
 * @method User[] findBy(array $filters)
 * @method User[] findAll()
 */
class UserRepository extends ARepository
{
    protected function getEntityClassName(): string
    {
        return User::class;
    }
}