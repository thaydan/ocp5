<?php


namespace Core\Entity;


interface IUser
{
    public function getID(): ?int;
    public function getUsername(): ?string;
    public function getPassword(): ?string;
    public function sanitize(): void;
}