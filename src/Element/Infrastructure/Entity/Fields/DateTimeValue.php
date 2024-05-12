<?php

namespace App\Element\Infrastructure\Entity\Fields;

use App\Element\Infrastructure\Entity\Element;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'element_date_time_value')]
class DateTimeValue
{
    #[ORM\Id]
    #[ORM\GeneratedValue('SEQUENCE')]
    #[ORM\Column]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Element::class, inversedBy: 'dateTimeValues')]
    #[ORM\JoinColumn(name: 'element_id', referencedColumnName: 'uuid')]
    private Element $element;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $value;

    public function __construct(Element $element, string $name, DateTimeImmutable $value)
    {
        $this->name = $name;
        $this->value = $value;
        $this->element = $element;
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

    public function getValue(): DateTimeImmutable
    {
        return $this->value;
    }
}