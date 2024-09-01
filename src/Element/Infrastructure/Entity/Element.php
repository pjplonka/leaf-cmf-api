<?php

declare(strict_types=1);

namespace App\Element\Infrastructure\Entity;

use App\Element\Infrastructure\Entity\Fields\DateTimeValue;
use App\Element\Infrastructure\Entity\Fields\ParentValue;
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
    #[ORM\GeneratedValue('NONE')]
    #[ORM\Column(name: 'uuid', type: 'uuid', unique: true)]
    private string $uuid;

    #[ORM\Column(name: 'type', length: 255)]
    private string $group;

    /** @var ArrayCollection<int, StringValue> */
    #[ORM\OneToMany(mappedBy: 'element', targetEntity: StringValue::class, cascade: ['persist'])]
    private Collection $stringValues;

    /** @var ArrayCollection<int, DateTimeValue> */
    #[ORM\OneToMany(mappedBy: 'element', targetEntity: DateTimeValue::class, cascade: ['persist'])]
    private Collection $dateTimeValues;

    /** @var ArrayCollection<int, DateTimeValue> */
    #[ORM\OneToMany(mappedBy: 'element', targetEntity: ParentValue::class, cascade: ['persist'])]
    private Collection $parentValues;

    public function __construct(string $uuid, string $group)
    {
        $this->uuid = $uuid;
        $this->group = $group;
        $this->stringValues = new ArrayCollection();
        $this->dateTimeValues = new ArrayCollection();
        $this->parentValues = new ArrayCollection();
    }

    public function addStringValue(StringValue $value): self
    {
        $foundElement = $this
            ->stringValues
            ->findFirst(fn(int $key, StringValue $item) => $item->getName() === $value->getName());

        if (!$foundElement) {
            $this->stringValues->add($value);

            return $this;
        }

        $foundElement->setValue($value->getValue());

        return $this;
    }

    public function addDateTimeValue(DateTimeValue $value): self
    {
        $foundElement = $this
            ->dateTimeValues
            ->findFirst(fn(int $key, DateTimeValue $item) => $item->getName() === $value->getName());

        if (!$foundElement) {
            $this->dateTimeValues->add($value);

            return $this;
        }

        $foundElement->setValue($value->getValue());

        return $this;
    }

    public function addParentValue(ParentValue $value): self
    {
        $foundElement = $this
            ->parentValues
            ->findFirst(fn(int $key, ParentValue $item) => $item->getName() === $value->getName());

        if (!$foundElement) {
            $this->parentValues->add($value);

            return $this;
        }

        $foundElement->setValue($value->getValue());

        return $this;
    }

    public function getUuid(): Uuid
    {
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

    /** @return Collection<ParentValue> */
    public function getParentValues(): Collection
    {
        return $this->parentValues;
    }

    public function __toString(): string
    {
        return $this->getUuid()->toRfc4122();
    }
}