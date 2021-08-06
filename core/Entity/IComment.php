<?php


namespace Core\Entity;


interface IComment
{
    public function getComments(): ?string;
    public function addComment();
    public function deleteComment();
}