<?php


namespace App\Repository;


use App\Entity\Post;
use Core\Repository\ARepository;

/**
 * @method Post find(int $id)
 * @method Post findOneBy(array $filters)
 * @method Post[] findBy(array $filters)
 * @method Post[] findAll()
 */
class PostRepository extends ARepository
{
    protected function getEntityClassName(): string
    {
        return Post::class;
    }
}