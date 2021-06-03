<?php

namespace Core\Form\Constraint;

abstract class AConstraint
{
    private $errorMessage;

    public function __construct($errorMessage = 'Il y a une erreur')
    {
        $this->errorMessage = $errorMessage;
    }

    abstract public function isValid($value): bool;

    /**
     * @param mixed|string $errorMessage
     * @return AConstraint
     */
    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;
        return $this;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}