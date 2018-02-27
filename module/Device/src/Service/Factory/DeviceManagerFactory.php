<?php
namespace Device\Service\Factory;

use Device\Service\DeviceManager;
use Interop\Container\ContainerInterface;

/**
 * This is the factory class for UserManager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class DeviceManagerFactory {
    /**
     * This method creates the DeviceManagerFactory service and returns its instance.
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {

        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        return new DeviceManager($entityManager);

    }
}
