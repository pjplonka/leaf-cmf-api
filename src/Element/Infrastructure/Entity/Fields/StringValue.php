<?php

namespace App\Element\Infrastructure\Entity\Fields;

use App\Element\Infrastructure\Entity\Element;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'element_string_value')]
class StringValue
{
    #[ORM\Id]
    #[ORM\GeneratedValue('SEQUENCE')]
    #[ORM\Column]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Element::class, inversedBy: 'stringValues')]
    #[ORM\JoinColumn(name: 'element_id', referencedColumnName: 'uuid')]
    private Element $element;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 255)]
    private string $value;

    public function __construct(Element $element, string $name, string $value)
    {
        $this->element = $element;
        $this->name = $name;
        $this->value = $value;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getElement(): Element
    {
        return $this->element;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }
}