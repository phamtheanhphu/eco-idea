<?php
namespace Application\View\Helper\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\View\Helper\Menu;
use Application\Service\NavManager;

/**
 * This is the factory for Menu view helper. Its purpose is to instantiate the
 * helper and init menu items.
 */
class MenuFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {

        $navManager = $container->get(NavManager::class);

        // Get menu items.
        $main_menu_items = $navManager->getMainMenuItems();
        $user_menu_items = $navManager->getUserMenuItems();

        //url helper
        $viewHelperManager = $container->get('ViewHelperManager');
        $urlHelper = $viewHelperManager->get('url');

        // Instantiate the helper.
        return new Menu($main_menu_items, $user_menu_items, $urlHelper);

    }
}

