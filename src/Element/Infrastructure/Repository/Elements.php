<?php

namespace App\Element\Infrastructure\Repository;

use App\Element\Infrastructure\Entity\Element as ElementEntity;
use App\Element\Infrastructure\Entity\Fields\DateTimeValue;
use App\Element\Infrastructure\Entity\Fields\StringValue;
use Doctrine\ORM\EntityManagerInterface;
use Leaf\Core\Core\Element\Element;
use Leaf\Core\Core\Element\Field\DateTimeField;
use Leaf\Core\Core\Element\Field\StringField;
use Symfony\Component\Uid\Uuid;

readonly class Elements implements \Leaf\Core\Core\Element\Elements
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function find(Uuid $uuid): ?Element
    {
        dd($uuid);
    }

    public function save(Element $element): void
    {
        $elementEntity = new ElementEntity($element->uuid, $element->group);

        foreach ($element->getFields() as $field) {
            match (true) {
                $field instanceof StringField => $elementEntity->addStringValue(
                    new StringValue($element->uuid, $field->getName(), $field->getValue())
                ),
                $field instanceof DateTimeField => $elementEntity->addDateTimeValue(
                    new DateTimeValue($element->uuid, $field->getName(), $field->getValue())
                )
            };
        }

        $this->entityManager->persist($elementEntity);
        $this->entityManager->flush();
    }
}