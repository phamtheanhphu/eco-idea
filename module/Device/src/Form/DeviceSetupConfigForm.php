<?php
namespace Device\Form;

use Device\Entity\Device;
use Device\Entity\Record\DeviceConfigRecord;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;


class DeviceSetupConfigForm extends Form {

    /**
     * Scenario ('smart_farm_device').
     * @var string
     */
    private $scenario;

    /**
     * Entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager = null;

    /**
     * Current user.
     * @var \Device\Entity\Device
     */
    private $device = null;

    /**
     * Constructor.
     */
    public function __construct($scenario = 'smart_farm_device', $entityManager = null, $device = null) {

        // Define form name
        parent::__construct('device-setup-config-form');

        // Set POST method for this form
        $this->setAttribute('method', 'post');


        // Save parameters for internal use.
        $this->scenario = $scenario;
        $this->entityManager = $entityManager;
        $this->device = $device;

        $this->addElements();
        $this->addInputFilter();

    }

    /**
     * This method adds elements to form (input fields and submit button).
     */
    protected function addElements() {

        if ($this->scenario == 'smart_farm_device') {

            //automatic_mode_enable
            $this->add(array(

                'type' => 'Zend\Form\Element\Select',
                'name' => 'automatic_mode_enable',
                'options' => array(
                    'value_options' => array(
                        '1' => 'Kích hoạt',
                        '0' => 'Ngừng kích hoạt',
                    ),
                    'label' => 'Kích hoạt chế độ tự động (*)'
                ),

                'attributes' => array(
                    'id' => 'automatic_mode_enable',
                    'class' => 'form-control',
                ),

            ));


            //send_data_to_server_interval
            $this->add(array(

                'type' => 'Zend\Form\Element\Select',
                'name' => 'send_data_to_server_interval',
                'options' => array(
                    'value_options' => array(
                        '5' => '5 phút',
                        '10' => '10 phút',
                        '15' => '15 phút',
                        '20' => '20 phút',
                    ),
                    'label' => 'Định kỳ gửi dữ liệu (*)'
                ),

                'attributes' => array(
                    'id' => 'send_data_to_server_interval',
                    'class' => 'form-control',
                ),

            ));

            //send_state_to_server_interval
            $this->add(array(

                'type' => 'Zend\Form\Element\Select',
                'name' => 'send_state_to_server_interval',
                'options' => array(
                    'value_options' => array(
                        '5' => '5 phút',
                        '10' => '10 phút',
                        '15' => '15 phút',
                        '20' => '20 phút',
                    ),
                    'label' => 'Định kỳ cập nhật tình trạng (*)'
                ),

                'attributes' => array(
                    'id' => 'send_state_to_server_interval',
                    'class' => 'form-control',
                ),

            ));

            //get_command_from_server_interval
            $this->add(array(

                'type' => 'Zend\Form\Element\Select',
                'name' => 'get_command_from_server_interval',
                'options' => array(
                    'value_options' => array(
                        '5' => '5 phút',
                        '10' => '10 phút',
                        '15' => '15 phút',
                        '20' => '20 phút',
                    ),
                    'label' => 'Định kỳ nhận lệnh từ server (*)'
                ),

                'attributes' => array(
                    'id' => 'get_command_from_server_interval',
                    'class' => 'form-control',
                ),

            ));


            if ($this->device != null && $this->device instanceof Device) {
                $configs = $this->device->getConfigRecords();
                foreach ($configs as $config) {
                    if ($config instanceof DeviceConfigRecord) {
                        $this->get($config->getAttribute())->setValue($config->getValue());
                    }

                }

            }

        }

    }


    /**
     * This method creates input filter (used for form filtering/validation).
     */
    private function addInputFilter() {

        // Create main input filter
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);


    }


}