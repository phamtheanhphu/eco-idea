<?php
namespace Admin\Controller\Factory;

use Admin\Controller\ManageDeviceController;
use Device\Service\DeviceManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ManageDeviceControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {

        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $deviceManager = $container->get(DeviceManager::class);

        // Instantiate the controller and inject dependencies
        return new ManageDeviceController($entityManager, $deviceManager);

    }

}