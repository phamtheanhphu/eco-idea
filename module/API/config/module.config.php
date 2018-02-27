<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace API;

use Zend\Router\Http\Segment;

return [

    'router' => [

        'routes' => [

            'api' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/api[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\APIController::class,
                        'action' => 'index',
                    ],
                ],
            ],

        ],
    ],

    'controllers' => [

        'factories' => [

            //Index
            Controller\APIController::class
            => Controller\Factory\APIControllerFactory::class,

        ],

    ],

    'service_manager' => [

        'factories' => [

            //nothing


        ],

    ],

    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],

    // The 'access_filter' key is used by the User module to restrict or permit
    // access to certain controller actions for unauthorized visitors.
    'access_filter' => [

        'options' => [
            'mode' => 'restrictive'
        ],

        'controllers' => [

            Controller\IndexController::class => [

                // Allow anyone to visit "index" and "about" actions
                [
                    'actions' => ['test', 'send-data', 'get-config'],
                    'allow' => '*'
                ],

            ],

        ]
    ],

    // We need to set this up so that we're allowed to return JSON
    // responses from our controller.
    /*'strategies' => [
        'ViewJsonStrategy',
    ],*/


];
