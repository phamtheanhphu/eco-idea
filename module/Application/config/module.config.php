<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\Router\Http\Regex;
use Zend\ServiceManager\Factory\InvokableFactory;
#use Application\Route\StaticRoute;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [

    'router' => [

        'routes' => [

            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],

            'application' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],

            'trang-chu' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/trang-chu[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],

            //posts
            'posts' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/posts[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]*'
                    ],
                    'defaults' => [
                        'controller' => Controller\PostController::class,
                        'action' => 'index',
                    ],
                ],
            ],

            //about
            'about' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/about',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'about',
                    ],
                ],
            ],

            'gioi-thieu' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/gioi-thieu',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'about',
                    ],
                ],
            ],

            //news
            'news' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/news',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'news',
                    ],
                ],
            ],

            'tin-tuc' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/tin-tuc',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'news',
                    ],
                ],
            ],

            //contact
            'contact' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/contact',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'contact',
                    ],
                ],
            ],

            'lien-he' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/lien-he',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'contact',
                    ],
                ],
            ],

        ],
    ],

    'controllers' => [

        'factories' => [

            //Index
            Controller\IndexController::class
            => Controller\Factory\IndexControllerFactory::class,

        ],

    ],

    'service_manager' => [

        'factories' => [

            // Register the NavManager service
            Service\NavManager::class
            => Service\Factory\NavManagerFactory::class,

            // Register the ImageManager service
            Service\ImageManager::class
            => InvokableFactory::class,


        ],

    ],

    // The following registers our custom view
    // helper classes in view plugin manager.
    'view_helpers' => [

        'factories' => [
            View\Helper\Menu::class => View\Helper\Factory\MenuFactory::class,
            View\Helper\TopMenu::class => View\Helper\Factory\TopMenuFactory::class,
            View\Helper\Message::class => View\Helper\Factory\MessageFactory::class,
            View\Helper\Breadcrumbs::class => InvokableFactory::class,
        ],

        'aliases' => [
            'mainMenu' => View\Helper\Menu::class,
            'topMenu' => View\Helper\TopMenu::class,
            'pageBreadcrumbs' => View\Helper\Breadcrumbs::class,
            'message' => View\Helper\Message::class,

        ],


    ],

    'view_manager' => [

        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',

        'template_map' => [

            //layout
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',

            //plugin init
            'app/init_plugin' => __DIR__ . '/../src/View/Plugins/init_plugin.phtml',

            //headers
            'layout/partials/header'
            => __DIR__ . '/../view/layout/partials/header.partial.phtml',
            'layout/partials/headers/top_header'
            => __DIR__ . '/../view/layout/partials/headers/top_header.partial.phtml',

            //footers
            'layout/partials/footer'
            => __DIR__ . '/../view/layout/partials/footer.partial.phtml',

            //modals
            'layout/partials/modals/login_popup'
            => __DIR__ . '/../view/layout/partials/modals/login_popup.partial.phtml',
            'layout/partials/modals/signup_popup'
            => __DIR__ . '/../view/layout/partials/modals/signup_popup.partial.phtml',

            //menus
            'layout/partials/menus/top_menu'
            => __DIR__ . '/../view/layout/partials/menus/top_menu.partial.phtml',

            //carousels
            'layout/partials/carousels/main_carousel'
            => __DIR__ . '/../view/layout/partials/carousels/main_carousel.partial.phtml',

            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',

            //handling errors
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',

        ],

        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],

    //doctrine
    /*'doctrine' => [
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
    ],*/

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
                    'actions' => ['index', 'about', 'contact', 'news'],
                    'allow' => '*'
                ],

                // Allow authorized users to visit "settings" action
                [
                    'actions' => ['settings'], 'allow' => '@'
                ]

            ],

        ]
    ],

];
