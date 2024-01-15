<?php

namespace App\Element\Infrastructure\Event;

use Leaf\Core\Application\Common\Event\Event;
use Leaf\Core\Application\Common\Event\EventDispatcher as CoreEventDispatcher;

class EventDispatcher implements CoreEventDispatcher
{
    public function dispatch(Event $event): void
    {
        // Not implemented yet, no needed
    }
}