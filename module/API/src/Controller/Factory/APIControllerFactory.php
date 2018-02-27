<?php
/**
 * Created by PhpStorm.
 * User: phu.pham
 * Date: 26/2/2018
 * Time: 11:02 AM
 */

namespace API\Controller\Factory;

use API\Controller\APIController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * This is the factory for UserController. Its purpose is to instantiate the
 * controller and inject dependencies into it.
 */
class APIControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {

        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        // Instantiate the controller and inject dependencies
        return new APIController($entityManager);
    }

}