<?php

declare(strict_types=1);

namespace App\Element\UserInterface\Controller;

use Leaf\Core\Application\Common\Command\CommandBus;
use Leaf\Core\Application\Common\FieldDTO;
use Leaf\Core\Application\CreateElement\CreateElementCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

#[AsController]
class ElementController
{
    #[Route('/elements', name: 'elements_create', methods: ['post'])]
    public function number(CommandBus $commandBus): Response
    {
        $command = new CreateElementCommand(
            'products',
            Uuid::v4(),
            new FieldDTO('name2', 'John'),
            new FieldDTO('delivered_at', '2022-05-01'),
        );

        $commandBus->handle($command);

        return new JsonResponse([], 201);
    }
}