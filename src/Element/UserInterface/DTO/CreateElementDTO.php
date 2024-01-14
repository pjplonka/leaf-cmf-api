<?php

declare(strict_types=1);

namespace App\Element\UserInterface\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class CreateElementDTO
{
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    private string $type;

    #[Assert\Valid]
    #[Assert\NotBlank]
    #[Assert\Type('array')]
    /** @var CreateElementFieldDTO[] */
    private array $fields;

    public function __construct(string $type, array $fields)
    {
        $this->type = $type;
        $this->fields = $fields;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getFields(): array
    {
        return $this->fields;
    }
}