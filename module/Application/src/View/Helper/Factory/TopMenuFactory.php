<?php
namespace Application\View\Helper\Factory;

use Application\View\Helper\TopMenu;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * This is the factory for Menu view helper. Its purpose is to instantiate the
 * helper and init menu items.
 */
class TopMenuFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {

        //auth service
        $authService = $container->get(\Zend\Authentication\AuthenticationService::class);

        //url helper
        $viewHelperManager = $container->get('ViewHelperManager');
        $urlHelper = $viewHelperManager->get('url');

        // Instantiate the helper.
        return new TopMenu($urlHelper, $authService);

    }
}

