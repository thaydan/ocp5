<?php


namespace Core\Form\Type;


use Core\Form\Constraint\AConstraint;

abstract class AFormType
{
    private $constraints;
    private $value;
    private $errorsMessages;
    private $isValid;
    private $options;

    public function __construct($constraints = [], $options = [])
    {
        $this->constraints = $constraints;
        $this->options = $options;
        $this->errorsMessages = [];
    }

    public function getConstraints(): array
    {
        return $this->constraints;
    }

    public function setConstraints(array $constraints): self
    {
        $this->constraints = $constraints;
        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value): self
    {
        $this->value = $value;
        return $this;
    }

    public function isValid(): bool
    {
        if ($this->isValid !== null) {
            return $this->isValid;
        }

        $this->isValid = true;

        /** @var AConstraint $constraint */
        foreach ($this->getConstraints() as $constraint) {
            $constraintIsValid = $constraint->isValid($this->getValue());
            $this->isValid &= $constraintIsValid;

            if (!$constraintIsValid) {
                $this->errorsMessages[] = $constraint->getErrorMessage();
            }
        }

        return $this->isValid;
    }

    /**
     * @return array
     */
    public function getErrorsMessages(): array
    {
        return $this->errorsMessages;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}