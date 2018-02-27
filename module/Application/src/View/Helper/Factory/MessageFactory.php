<?php
namespace Application\View\Helper\Factory;

use Application\View\Helper\Message;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * This is the factory for Menu view helper. Its purpose is to instantiate the
 * helper and init menu items.
 */
class MessageFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {

        $flashMessenger = $container
            ->get('ControllerPluginManager')
            ->get('flashmessenger');

        //url helper
        $viewHelperManager = $container->get('ViewHelperManager');
        $urlHelper = $viewHelperManager->get('url');

        // Instantiate the helper.
        return new Message($flashMessenger);

    }
}

