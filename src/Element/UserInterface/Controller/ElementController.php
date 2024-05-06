<?php

declare(strict_types=1);

namespace App\Element\UserInterface\Controller;

use App\Element\Infrastructure\Repository\Elements;
use Leaf\Core\Application\Common\Command\CommandBus;
use Leaf\Core\Application\Common\FieldDTO;
use Leaf\Core\Application\Common\Serializer\ElementSerializer;
use Leaf\Core\Application\CreateElement\CreateElementCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

#[AsController]
class ElementController
{
    #[Route('/builder/{type}', name: 'elements_create', methods: ['post'])]
    public function create(
        string $type,
        Request $request,
        CommandBus $commandBus,
        Elements $elements,
        ElementSerializer $serializer
    ): Response {
        $fields = [];
        foreach ($request->toArray() as $key => $value) {
            $fields[] = new FieldDTO($key, $value);
        }

        $command = new CreateElementCommand($type, $uuid = Uuid::v4(), ...$fields);

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