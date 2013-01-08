Configuration
=============

Handlers
--------
You can register any service as a handler by adding it to the config.

```php
return array(
    // ...
    'jms_serializer' => array(
        'handlers' => array(
            'subscribers' => array(
                'my_service_id',
                'My\Fully\Quallified\ClassName',
            ),
        ),
    // ...
);
```

**Note:** The handler must implement the interface ```JMS\Serializer\Handler\SubscribingHandlerInterface```

Event Dispatcher
----------------
In order to register a new event subscriber, you have to add the service/class to the config.

```php
return array(
    // ...
    'jms_serializer' => array(
        'eventdispatcher' => array(
            'subscribers' => array(
                'my_service_id',
                'My\Fully\Quallified\ClassName',
            ),
        ),
    // ...
);
```

Overriding Third-Party Metadata
-------------------------------
Sometimes you want to serialize objects which are shipped by a third-party module.
Such a third-party module might not ship with metadata that suits your needs, or
possibly none, at all. In such a case, you can override the default location that
is searched for metadata with a path that is under your control.

```php
return array(
    // ...
    'jms_serializer' => array(
        'metadata' => array(
            'directories' => array(
                'ZfcUser' => array(
                    'namespace_prefix' => 'ZfcUser\Entity',
                    'path' => __DIR__ .'/serializer'
                )
            ),
        ),
    // ...
);
```
