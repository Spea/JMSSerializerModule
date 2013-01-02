<?php

/*
 * This file is part of the JMSSerializerModule package.
 *
 * (c) Martin Parsiegla <martin.parsiegla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return array(
    'jms_serializer' => array(
        'handlers' => array(
            'datetime' => array(
                'default_format' => \DateTime::ISO8601,
                'default_timezone' => date_default_timezone_get(),
            ),
            'subscribers' => array(
                'jms_serializer.datetime_handler',
                'jms_serializer.array_collection_handler',
            ),
        ),
        'eventdispatcher' => array(
            'subscribers' => array(
                'jms_serializer.doctrine_proxy_subscriber'
            )
        ),
        'property_naming' => array(
            'separator' => '_',
            'lower_case' => true,
            'enable_cache' => true
        ),
        'metadata' => array(
            'cache' => 'file',
            'annotation_cache' => 'array',
            'debug' => false,
            'file_cache' => array(
                'dir' => 'data/JMSSerializerModule',
            ),
            'infer_types_from_doctrine_metadata' => true,
            'directories' => array()
        ),
        'visitors' => array(
            'json' => array(
                'options' => 0
            ),
            'xml' => array(
                'doctype_whitelist' => array(),
            ),
            'serialization' => array(
                'json' => 'jms_serializer.json_serialization_visitor',
                'xml' => 'jms_serializer.xml_serialization_visitor',
                'yml' => 'jms_serializer.yaml_serialization_visitor',
            ),
            'deserialization' => array(
                'json' => 'jms_serializer.json_deserialization_visitor',
                'xml' => 'jms_serializer.xml_deserialization_visitor',
            ),
        )
    ),
);
