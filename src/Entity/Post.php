<?php


namespace App\Entity;


class Post
{
    private ?string $posts;
    private ?string $post;

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

    public function sanitize(): void
    {
        $this->password = null;
    }
}