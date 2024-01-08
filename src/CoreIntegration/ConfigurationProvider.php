<?php

namespace App\CoreIntegration;

use Leaf\Core\Application\Common\Exception\ConfigurationNotFoundException;
use Leaf\Core\Core\Configuration\Configuration;
use Leaf\Core\Core\Configuration\Field;
use Leaf\Core\Core\Element\Field\DateTimeField;
use Leaf\Core\Core\Element\Field\StringField;

class ConfigurationProvider implements \Leaf\Core\Application\Common\ConfigurationProvider
{
    public function find(string $identifier): Configuration
    {
        if ($identifier !== 'products') {
            throw new ConfigurationNotFoundException();
        }

        return new Configuration(
            'products',
            ...[
                new Field('name', StringField::getType(), ...StringField::getConstraints()),
                new Field('delivered_at', DateTimeField::getType(), ...DateTimeField::getConstraints()),
            ]
        );
    }
}