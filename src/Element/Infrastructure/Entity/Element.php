<?php

namespace App\Element\Infrastructure\Entity;

use App\Element\Infrastructure\Entity\Fields\DateTimeValue;
use App\Element\Infrastructure\Entity\Fields\StringValue;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Table]
class Element
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    #[ORM\Column(name: 'uuid', type: 'uuid', unique: true)]
    private string $uuid;

    #[ORM\Column(name: 'type', length: 255)]
    private string $group;

    #[ORM\OneToMany(mappedBy: 'element', targetEntity: StringValue::class, cascade: ['persist'])]
    private Collection $stringValues;

    #[ORM\OneToMany(mappedBy: 'element', targetEntity: DateTimeValue::class, cascade: ['persist'])]
    private Collection $dateTimeValues;

    public function __construct(string $uuid, string $group)
    {
        $this->uuid = $uuid;
        $this->group = $group;
        $this->stringValues = new ArrayCollection();
        $this->dateTimeValues = new ArrayCollection();
    }

    public function addStringValue(StringValue $stringValue): self
    {
        if (!$this->stringValues->contains($stringValue)) {
            $this->stringValues->add($stringValue);
        }

        return $this;
    }

    public function addDateTimeValue(DateTimeValue $stringValue): self
    {
        if (!$this->dateTimeValues->contains($stringValue)) {
            $this->dateTimeValues->add($stringValue);
        }

        return $this;
    }

    public function getUuid(): Uuid
    {
        if ($this->uuid instanceof Uuid) {
            return $this->uuid;
        }

        return Uuid::fromString($this->uuid);
    }

    public function getGroup(): string
    {
        return $this->group;
    }

    /** @return Collection<StringValue> */
    public function getStringValues(): Collection
    {
        return $this->stringValues;
    }

    /** @return Collection<DateTimeValue> */
    public function getDateTimeValues(): Collection
    {
        return $this->dateTimeValues;
    }

    public function __toString(): string
    {
        return $this->getUuid();
    }
}