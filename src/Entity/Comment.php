<?php


namespace App\Entity;

use Core\Entity\IComment;

class Comment implements IComment
{
    private ?string $comments;

    /**
     * @return string|null
     */
    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function addComment()
    {
        return $this->comment;
    }

    public function deleteComment()
    {
    }

}