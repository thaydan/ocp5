<?php

namespace Core\Form\Constraint;

class NotNullConstraint extends AConstraint
{
    public function __construct($errorMessage = 'La valeur ne doit pas être null.')
    {
        parent::__construct($errorMessage);
    }

    public function isValid($value): bool
    {
        return $value !== null;
    }
}