<?php
namespace Admin\Controller\Factory;

use Admin\Controller\ManageUserController;
use Interop\Container\ContainerInterface;
use User\Service\UserManager;
use Zend\ServiceManager\Factory\FactoryInterface;

class ManageUserControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {

        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $userManager = $container->get(UserManager::class);

        // Instantiate the controller and inject dependencies
        return new ManageUserController($entityManager, $userManager);

    }

}