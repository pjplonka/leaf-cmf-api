<?php

use Leaf\Core\Core\Configuration\Field;
use Leaf\Core\Core\Element\Field\ParentField;
use Leaf\Core\Core\Element\Field\StringField;

return [
    'fields' => [
        new Field('projects', ParentField::getType(), ...ParentField::getConstraints()),
        new Field('type', StringField::getType(), ...StringField::getConstraints()),
        new Field('amount', StringField::getType(), ...StringField::getConstraints()),
        new Field('length', StringField::getType(), ...StringField::getConstraints()),
        new Field('width', StringField::getType(), ...StringField::getConstraints()),
        new Field('cost', StringField::getType(), ...StringField::getConstraints()),
        new Field('description', StringField::getType(), ...StringField::getConstraints()),
    ],
];