<?php

namespace App\CoreIntegration;

use Leaf\Core\Core\Element\Element;
use Ramsey\Uuid\UuidInterface;

class Elements implements \Leaf\Core\Core\Element\Elements
{
    public function find(UuidInterface $uuid): ?Element
    {
        dd($uuid);
    }

    public function save(Element $element): void
    {
        dd($element);
    }
}