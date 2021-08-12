<?php


namespace App\Entity;


use Core\Entity\IUser;

class User implements IUser
{
    private ?int $id;
    private ?string $username;
    private ?string $password;

    /**
     * @return int|null
     */
    public function getID(): ?int
    {
        return $this->id;
    }


    /**
     * @param int|null $id
     * @return $this
     */
    public function setID(?int $id): User
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     * @return User
     */
    public function setUsername(?string $username): User
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     * @return User
     */
    public function setPassword(?string $password): User
    {
        $this->password = $password;
        return $this;
    }

    public function sanitize(): void
    {
        $this->password = null;
    }
}