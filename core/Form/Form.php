<?php


namespace Core\Form;


use Core\Form\Type\AFormType;
use Core\Utility\Explorer;

class Form
{
    private $parts = [];
    private $datas;
    private $isValid;

    public function __construct($parts, $datas = [])
    {
        $this->parts = $parts;
        $this->datas = $datas;
        $this->isValid = null;

        foreach ($this->parts as $name => $type) {
            $type->setValue(Explorer::getValue($datas, $name));
        }
    }

    public function isSubmitted(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    public function isValid(): bool
    {
        if ($this->isValid !== null) {
            return $this->isValid();
        }

        $this->isValid = true;

        /**
         * @var string $name
         * @var AFormType $type
         */
        foreach ($this->parts as $type) {
            $this->isValid &= $type->isValid();
        }

        return $this->isValid;
    }

    public function handleRequest(): void
    {
        if ($this->isSubmitted()) {
            /**
             * @var string $name
             * @var AFormType $type
             */
            foreach ($this->parts as $name => $type) {
                $type->setValue($_POST[$name] ?? null);
                Explorer::setValue($this->datas, $name, $type->getValue());
            }
        }
    }

    public function getData()
    {
        return $this->datas;
    }

    public function getErrorsMessages(): array
    {
        return array_map(
            function (AFormType $value) {
                return $value->getErrorsMessages();
            },
            $this->parts
        );
    }

    public function getParts(): array
    {
        return $this->parts;
    }
}