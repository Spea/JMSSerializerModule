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

### Next Steps

- [Configuration Reference](configuration_reference.md)
