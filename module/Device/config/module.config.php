<?php
namespace Device;


use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [

    //service_manager
    'service_manager' => [
        'factories' => [
            Service\DeviceManager::class => Service\Factory\DeviceManagerFactory::class,
        ],
    ],

    //doctrine
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ],

];
