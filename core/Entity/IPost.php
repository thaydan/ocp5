<?php


namespace Core\Entity;


interface IPost
{
    public function getPosts(): ?string;
    public function getPost();
    public function sanitize(): void;
}