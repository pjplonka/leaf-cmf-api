<?php

use Leaf\Core\Core\Configuration\Field;
use Leaf\Core\Core\Element\Field\StringField;

return [
    'fields' => [
        new Field('name', StringField::getType(), ...StringField::getConstraints()),
    ]
];
