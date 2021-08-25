<?php


namespace App\Entity;


use Core\Entity\IPost;

class Post implements IPost
{
    private ?string $posts;
    private ?string $post;
    public ?array $author;
    public ?string $featured_image;

    /**
     * @return string|null
     */
    public function getPosts(): ?string
    {
        return $this->posts;
    }

    public function getPost(): ?string
    {
        return $this->post;
    }
}