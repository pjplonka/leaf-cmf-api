<?php

namespace App\Element\Infrastructure\Entity\Fields;

use App\Element\Infrastructure\Entity\Element;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'element_datetime_values')]
class DateTimeValue
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

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $value;

    public function __construct(string $elementId, string $name, DateTimeImmutable $value)
    {
        $this->name = $name;
        $this->value = $value;
        $this->elementId = $elementId;
    }
}