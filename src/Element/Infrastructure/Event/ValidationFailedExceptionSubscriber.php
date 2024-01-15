<?php

namespace App\Element\Infrastructure\Event;

use Leaf\Core\Application\Common\Exception\ValidationFailedException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ValidationFailedExceptionSubscriber implements EventSubscriberInterface
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();

        if (!$throwable instanceof ValidationFailedException) {
            return;
        }

        $errors = [];
        foreach ($throwable->violations as $violation) {
            $errors[str_replace(['[', ']'], '', $violation->getPropertyPath())][] = $violation->getMessage();
        }

        $event->setResponse(new JsonResponse($errors, 400));
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException'
        ];
    }
}