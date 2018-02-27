<?php
/**
 * Created by PhpStorm.
 * User: phu.pham
 * Date: 23/2/2018
 * Time: 11:42 AM
 */

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * This view helper class displays a menu bar.
 */
class Message extends AbstractHelper {

    /**
     * @var \Zend\Mvc\Plugin\FlashMessenger\FlashMessenger
     */
    protected $flashMessenger;

    /**
     * Message constructor.
     * @param \Zend\Mvc\Plugin\FlashMessenger\FlashMessenger $flashMessenger
     */
    public function __construct(\Zend\Mvc\Plugin\FlashMessenger\FlashMessenger $flashMessenger) { $this->flashMessenger = $flashMessenger; }


    public function render() {

        //error messages
        if ($this->flashMessenger->hasErrorMessages()) {

            echo '<div class="alert alert-danger">';

            $messages = $this->flashMessenger->getErrorMessages();
            foreach ($messages as $message) {
                echo $message;
            }

            echo '</div>';
        }

        //success messages
        if ($this->flashMessenger->hasSuccessMessages()) {

            echo '<div class="alert alert-success">';

            $messages = $this->flashMessenger->getSuccessMessages();
            foreach ($messages as $message) {
                echo $message;
            }

            echo '</div>';
        }


    }

}