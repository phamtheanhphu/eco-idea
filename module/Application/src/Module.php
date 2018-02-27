<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use User\Form\LoginForm;
use Zend\Mvc\MvcEvent;

class Module {

    const VERSION = '3.0.0dev';

    public function onBootstrap(MvcEvent $e) {
        $app = $e->getParam('application');
        $app->getEventManager()
            ->attach(MvcEvent::EVENT_RENDER, array($this, 'mappingFormToView'), 100);
    }

    public function mappingFormToView(MvcEvent $event) {
        $login_form = new LoginForm();
        $viewModel = $event->getViewModel();
        $viewModel->setVariables(array(
            'login_form' => $login_form,
        ));
    }

    public function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }

}
