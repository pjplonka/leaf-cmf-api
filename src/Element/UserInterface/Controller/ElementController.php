<?php

declare(strict_types=1);

namespace App\Element\UserInterface\Controller;

use App\Element\Infrastructure\Repository\Elements;
use App\Element\UserInterface\DTO\CreateElementDTO;
use App\Element\UserInterface\DTO\CreateElementFieldDTO;
use Leaf\Core\Application\Common\Command\CommandBus;
use Leaf\Core\Application\Common\FieldDTO;
use Leaf\Core\Application\Common\Serializer\ElementSerializer;
use Leaf\Core\Application\CreateElement\CreateElementCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

#[AsController]
class ElementController
{
    #[Route('/elements', name: 'elements_create', methods: ['post'])]
    public function create(
        #[MapRequestPayload] CreateElementDTO $createElementDTO,
        CommandBus $commandBus,
        Elements $elements,
        ElementSerializer $serializer
    ): Response {
        $command = new CreateElementCommand(
            $createElementDTO->getType(),
            $uuid = Uuid::v4(),
            ...array_map(
                fn(CreateElementFieldDTO $field) => new FieldDTO($field->getName(), $field->getValue()),
                $createElementDTO->getFields()
            )
        );

        $commandBus->handle($command);

        return new JsonResponse($serializer->serialize($elements->find($uuid)), 201);
    }

    #[Route('/elements/{uuid}', name: 'elements_view', methods: ['get'])]
    public function view(Uuid $uuid, Elements $elements, ElementSerializer $serializer): Response
    {
        $element = $elements->find($uuid);

        if (!$element) {
            return new JsonResponse(['message' => 'Element not found.', 'status' => 404], 404);
        }

        return new JsonResponse($serializer->serialize($element), 200);
    }
}