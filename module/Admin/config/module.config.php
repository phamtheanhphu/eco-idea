<?php
namespace Admin;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [

    'router' => [

        'routes' => [

            //admin
            'admin' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/admin',
                    'defaults' => [
                        'controller' => Controller\AdminController::class,
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,

                'child_routes' => [

                    //manage-user
                    'manage-user' => [

                        'type' => Segment::class,

                        'options' => [

                            'route' => '/manage-user[/:action[/:id]]',

                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[a-zA-Z0-9_-]*',
                            ],

                            'defaults' => [
                                'controller' => Controller\ManageUserController::class,
                                'action' => 'index',
                            ],
                        ],
                    ],

                    //manage-device
                    'manage-device' => [

                        'type' => Segment::class,

                        'options' => [

                            'route' => '/manage-device[/:action[/:id]]',

                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[a-zA-Z0-9_-]*',
                            ],

                            'defaults' => [
                                'controller' => Controller\ManageDeviceController::class,
                                'action' => 'index',
                            ],
                        ],
                    ],

                ],
            ],

        ],

    ],

    'controllers' => [

        'factories' => [

            Controller\AdminController::class
            => Controller\Factory\AdminControllerFactory::class,


            //Manage User
            Controller\ManageUserController::class
            => Controller\Factory\ManageUserControllerFactory::class,

            //Manage Device
            Controller\ManageDeviceController::class
            => Controller\Factory\ManageDeviceControllerFactory::class,

        ],


    ],

    //service_manager
    'service_manager' => [
        'factories' => [
            //nothing
        ],
    ],

    'view_manager' => [

        'template_path_stack' => [
            __DIR__ . '/../view',
        ],

        'template_map' => [

            //tables
            'manage-user/tables/users'
            => __DIR__ . '/../view/admin/manage-user/tables/users.phtml',
            'manage-device/tables/devices'
            => __DIR__ . '/../view/admin/manage-device/tables/devices.phtml',

            //forms

        ]
    ],

    // The 'access_filter' key is used by the User module to restrict or permit
    // access to certain controller actions for unauthorized visitors.
    'access_filter' => [

        'options' => [
            'mode' => 'restrictive'
        ],

        'controllers' => [

            Controller\AdminController::class => [

                // Allow admin user only
                [
                    'actions' => ['index'],
                    'allow' => 'admin'
                ]

            ],

            Controller\ManageUserController::class => [

                // Allow admin user only
                [
                    'actions' => ['index', 'add', 'edit', 'view', 'remove'],
                    'allow' => 'admin'
                ]

            ],

            Controller\ManageDeviceController::class => [

                // Allow admin user only
                [
                    'actions' => ['index', 'add', 'edit', 'view', 'remove'],
                    'allow' => 'admin'
                ]

            ],


        ]
    ],


];
