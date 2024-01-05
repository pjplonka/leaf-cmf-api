<?php

namespace App\CoreIntegration;

use Leaf\Core\Core\Configuration\Configuration;
use Leaf\Core\Core\Configuration\Field;
use Leaf\Core\Core\Element\Field\StringField;

class ConfigurationProvider implements \Leaf\Core\Application\Common\ConfigurationProvider
{
    public function find(string $identifier): Configuration
    {
        return new Configuration(
            'products',
            ...[
                new Field('name', StringField::getType(), ...StringField::getConstraints()),
            ]
        );
    }
}