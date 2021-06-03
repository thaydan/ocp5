<?php

namespace Core\Form\Constraint;

class NotBlankConstraint extends AConstraint
{
    public function __construct($errorMessage = 'La valeur ne doit pas être vide.')
    {
        parent::__construct($errorMessage);
    }

    public function isValid($value): bool
    {
        return is_string($value) && mb_strlen($value) > 0;
    }
}