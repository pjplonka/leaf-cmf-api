<?php

namespace App\Element\Infrastructure\Repository;

use App\Element\Infrastructure\Entity\Element as ElementEntity;
use App\Element\Infrastructure\Entity\Fields\DateTimeValue;
use App\Element\Infrastructure\Entity\Fields\ParentValue;
use App\Element\Infrastructure\Entity\Fields\StringValue;
use Doctrine\ORM\EntityManagerInterface;
use Leaf\Core\Core\Element\Element;
use Leaf\Core\Core\Element\Elements as CoreElements;
use Leaf\Core\Core\Element\Field\DateTimeField;
use Leaf\Core\Core\Element\Field\ParentField;
use Leaf\Core\Core\Element\Field\StringField;
use Symfony\Component\Uid\Uuid;

readonly class Elements implements CoreElements
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function find(Uuid $uuid): ?Element
    {
        /** @var ElementEntity $elementEntity */
        $elementEntity = $this->entityManager->getRepository(ElementEntity::class)->find($uuid);

        if (!$elementEntity) {
            return null;
        }

        $fields = [];
        foreach ($elementEntity->getStringValues() as $stringValue) {
            $fields[] = new StringField($stringValue->getName(), $stringValue->getValue());
        }
        foreach ($elementEntity->getDateTimeValues() as $dateTimeValue) {
            $fields[] = new DateTimeField($dateTimeValue->getName(), $dateTimeValue->getValue());
        }

        foreach ($elementEntity->getParentValues() as $parentValue) {
            $fields[] = new ParentField($parentValue->getName(), Uuid::fromString($parentValue->getValue()));
        }

        return new Element($elementEntity->getUuid(), $elementEntity->getGroup(), ...$fields);
    }

    public function save(Element $element): void
    {
        $elementEntity = $this->entityManager->getRepository(ElementEntity::class)->findOneBy(['uuid' => $element->uuid]);
        if (!$elementEntity) {
            $elementEntity = new ElementEntity($element->uuid, $element->group);
        }

        foreach ($element->getFields() as $field) {
            match (true) {
                $field instanceof StringField => $elementEntity->addStringValue(
                    new StringValue($elementEntity, $field->getName(), $field->getValue())
                ),
                $field instanceof DateTimeField => $elementEntity->addDateTimeValue(
                    new DateTimeValue($elementEntity, $field->getName(), $field->getValue())
                ),
                // todo: here we have to be sure that parent exist -> name in conf exist, name in db exist and value is in db (id of parent)
                $field instanceof ParentField => $elementEntity->addParentValue(
                    new ParentValue($elementEntity, $field->getName(), $this->findElementEntity($field->getValue()))
                )
            };
        }

        $this->entityManager->persist($elementEntity);
        $this->entityManager->flush();
    }

    protected function findElementEntity(Uuid $uuid): ElementEntity
    {
        return $this->entityManager->getRepository(ElementEntity::class)->find($uuid);
    }
}
