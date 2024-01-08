<?php

namespace App\Element\Infrastructure\Entity\Fields;

use App\Element\Infrastructure\Entity\Element;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'element_string_values')]
class StringValue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(name: 'element_id')]
    #[ORM\ManyToOne(targetEntity: Element::class, inversedBy: 'stringValues')]
    private string $elementId;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 255)]
    private string $value;

    public function __construct(string $elementId, string $name, string $value)
    {
        $this->elementId = $elementId;
        $this->name = $name;
        $this->value = $value;
    }
}