<?php


namespace Core\Entity;


interface IUser
{
    public function getUsername(): ?string;
    public function getPassword(): ?string;
    public function sanitize(): void;
}