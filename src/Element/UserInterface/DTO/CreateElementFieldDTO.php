<?php

declare(strict_types=1);

namespace App\Element\UserInterface\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class CreateElementFieldDTO
{
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    private string $name;

    #[Assert\NotBlank]
    private string $value;

    public function __construct(string $name, string $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}