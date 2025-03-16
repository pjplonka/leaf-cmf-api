Leaf CMF is Content Management Framework based on Symfony Framework.  

# Installation
Copy `compose.override-example.yaml` and create `compose.override.yaml` with custom configuration if needed.  
Run `make dev`  
Open http://localhost

# Description / Overview
The CMF system, unlike the CMS system, uses abstraction to 
manage elements. Thanks to this, you can create any structure 
with any name with just a few clicks in the configuration:

![CMS vs CMF.jpeg](doc%2FCMS%20vs%20CMF.jpeg)

# Basic Example

1. Create a configuration
Put new configuration to config/elements/products.php
```php
use Leaf\Core\Core\Configuration\Field;
use Leaf\Core\Core\Element\Field\DateTimeField;
use Leaf\Core\Core\Element\Field\StringField;

return [
    'fields' => [
        new Field('name', StringField::getType(), ...StringField::getConstraints()),
        new Field('delivered_at', DateTimeField::getType(), ...DateTimeField::getConstraints()),
    ]
];
```

2. Create new product
```
Request:
POST https://localhost/builder/products
{
    "name": "Box",
    "delivered_at": "2023-05-05"
}
```
```
Response:
HTTP 201
{
    "uuid": "31a081be-18f3-4aba-8305-ae1c82f3a551",
    "group": "products",
    "fields": {
        "name": "Box",
        "delivered_at": "2023-05-05T00:00:00+00:00"
    }
}
```

3. Get product by uuid
```
Request:
GET https://localhost/elements/31a081be-18f3-4aba-8305-ae1c82f3a551
```
```
Response:
HTTP 200
{
    "uuid": "31a081be-18f3-4aba-8305-ae1c82f3a551",
    "group": "products",
    "fields": {
        "name": "Box",
        "delivered_at": "2023-05-05T00:00:00+00:00"
    }
}
```

4. Update product by uuid
```
Request:
PATCH https://localhost/elements/31a081be-18f3-4aba-8305-ae1c82f3a551
{
    "name": "Mug",
    "delivered_at": "2020-05-07"
}
```
```
Response:
HTTP 200
{
    "uuid": "31a081be-18f3-4aba-8305-ae1c82f3a551",
    "group": "products",
    "fields": {
        "name": "Mug",
        "delivered_at": "2020-05-07T00:00:00+00:00"
    }
}
```


# TODO
- move docker files to docker dir
- catch configuration not found in controller or add it to validation (which is not used now)
- update readme with tests, running dev env
- make xdebug running on local env (and phpunit coverage)
- add postman public repo for api examples OR swagger
- add swagger documentation
- remove all fields when element is removed (delete cascade)
- element need created_at and updated_at
- add phpstan
- test database should be separated from dev/prod database
- test every element type and scenario
- doc: example requests <basic>, apidoc, example app
- reset migrations to 0