<?php

namespace App\Controller;

use Leaf\Core\Application\Common\Command\CommandBus;
use Leaf\Core\Application\Common\FieldDTO;
use Leaf\Core\Application\CreateElement\CreateElementCommand;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class ElementController
{
    public function __construct(private CommandBus $commandBus)
    {
    }
    
    #[Route('/lucky/number/', name: 'app_lucky_number')]
    public function number(): Response
    {
        $command = new CreateElementCommand(
            'johny',
            Uuid::uuid4(),
            new FieldDTO('name', 'John')
        );

        $this->commandBus->handle($command);

        $number = random_int(0, 100);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }
}