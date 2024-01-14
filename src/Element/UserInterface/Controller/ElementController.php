<?php

declare(strict_types=1);

namespace App\Element\UserInterface\Controller;

use App\Element\UserInterface\DTO\CreateElementDTO;
use App\Element\UserInterface\DTO\CreateElementFieldDTO;
use Leaf\Core\Application\Common\Command\CommandBus;
use Leaf\Core\Application\Common\FieldDTO;
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
    public function create(#[MapRequestPayload] CreateElementDTO $createElementDTO, CommandBus $commandBus): Response
    {
        $command = new CreateElementCommand(
            $createElementDTO->getType(),
            Uuid::v4(),
            ...array_map(
                fn(CreateElementFieldDTO $field) => new FieldDTO($field->getName(), $field->getValue()),
                $createElementDTO->getFields()
            )
        );

        $commandBus->handle($command);

        return new JsonResponse([], 201);
    }


}