<?php

namespace App\Element\Infrastructure\Entity\Fields;

use App\Element\Infrastructure\Entity\Element;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'element_parent_value')]
class ParentValue
{
    #[ORM\Id]
    #[ORM\GeneratedValue('SEQUENCE')]
    #[ORM\Column]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Element::class, inversedBy: 'parentValues')]
    #[ORM\JoinColumn(name: 'element_id', referencedColumnName: 'uuid')]
    private Element $element;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\ManyToOne(targetEntity: Element::class)]
    #[ORM\JoinColumn(name: 'value', referencedColumnName: 'uuid')]
    private Element $value;

    public function __construct(Element $element, string $name, Element $value)
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

    public function getValue(): Element
    {
        return $this->value;
    }

    public function setValue(Element $value): self
    {
        $this->value = $value;

        return $this;
    }
}