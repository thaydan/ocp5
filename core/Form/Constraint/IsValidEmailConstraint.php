<?php

namespace Core\Form\Constraint;

class IsValidEmailConstraint extends AConstraint
{
    public function __construct($errorMessage = 'L\'adresse e-mail n\'est pas valide.')
    {
        parent::__construct($errorMessage);
    }

    public function isValid($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }
}