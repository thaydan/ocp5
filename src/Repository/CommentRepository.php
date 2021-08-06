<?php


namespace App\Repository;


use App\Entity\Comment;
use Core\Repository\ARepository;

/**
 * @method Comment find(int $id)
 * @method Comment findOneBy(array $filters)
 * @method Comment[] findBy(array $filters)
 * @method Comment[] findAll()
 */
class CommentRepository extends ARepository
{
    protected function getEntityClassName(): string
    {
        return Comment::class;
    }
}