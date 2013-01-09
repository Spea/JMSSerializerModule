Installation
============

Prerequisites
-------------

This module requires ZendFramework 2.*

Installation
------------

1. Download JMSSerializerModule using composer
2. Enable the Module
3. Basic usage

### Step 1: Download JMSSerializerModule using composer

Add JMSSerializerModule in your composer.json:

```json
{
    "require": {
        "sp/jms-serializer-module": "dev-master"
    }
}
```

Now tell composer to download the module by running the command:

``` bash
$ php composer.phar update sp/jms-serializer-module
```

### Step 2: Enable the module

Enable the module in your application config:

``` php
<?php
// my/project/directory/config/application.config.php

return array(
    'modules' => array(
        // ...
        'JMSSerializerModule',
        // ...
    ),
);
```

### Step 3: Basic usage

#### Registered Services

* jms_serializer.serializer
* jms_serializer.handler_registry
* jms_serializer.event_dispatcher

#### Service Locator

Access the serializer using the following alias:

```php
<?php
$serializer = $this->getServiceLocator()->get('jms_serializer.serializer');
$serializer->serialize($data, 'json');
```

Or use the integrated view helper in your templates:

```php
<?php
echo $this->jmsSerializer($object); // will serialize to json
echo $this->jmsSerializer($object, 'json');
echo $this->jmsSerializer($object, 'xml');
echo $this->jmsSerializer($object, 'yml');
?>
```

If you don't use annotations for the metadata, you have to specify the path where the metadata can be found.
This will be done in your ```module.config.php```

``` php
<?php
// MyModule/config/module.config.php
return array(
    'jms_serializer' => array(
        'metadata' => array(
            'directories' => array(
                'any-name' => array(
                    'namespace_prefix' => 'MyModule\Entity',
                    'path' => __DIR__ .'/serializer'
                )
            )
        ),
    ),
);
```

### Next Steps

- [Configuration Reference](configuration_reference.md)
