<?php

use Leaf\Core\Core\Configuration\Field;
use Leaf\Core\Core\Element\Field\DateTimeField;
use Leaf\Core\Core\Element\Field\ParentField;
use Leaf\Core\Core\Element\Field\StringField;

return [
    'fields' => [
        new Field('name', StringField::getType(), ...StringField::getConstraints()),
        new Field('delivered_at', DateTimeField::getType(), ...DateTimeField::getConstraints()),
        new Field('product_categories', ParentField::getType(), ...ParentField::getConstraints()),
    ]
];
