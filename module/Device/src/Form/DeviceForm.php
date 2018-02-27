<?php
namespace Device\Form;

use Device\Entity\Device_Type;
use User\Entity\User;
use Zend\Form\Form;
use Zend\Form\Element;
use Zend\InputFilter\InputFilter;


class DeviceForm extends Form {

    /**
     * Scenario ('create' or 'update').
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
    public function __construct($scenario = 'create', $entityManager = null, $device = null) {

        // Define form name
        parent::__construct('device-form');

        // Set POST method for this form
        $this->setAttribute('method', 'post');

        //Set enctype -> multipart/form-data
        $this->setAttribute('enctype', 'multipart/form-data');

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

        if ($this->scenario == 'update') {
            // "user_id" field
            $this->add([
                'type' => 'Select',
                'name' => 'user_id',
                'options' => [
                    'label' => 'Thuộc về người dùng',
                    'value_options' => $this->getSelectUserOptions(),
                ],
                'attributes' => [
                    'id' => 'user_id',
                    'class' => 'form-control',
                ],
            ]);
        }

        // "device_unique_id" field
        $this->add([
            'type' => 'Text',
            'name' => 'device_unique_id',
            'options' => [
                'label' => 'Mã thiết bị (*)',
            ],
            'attributes' => [
                'id' => 'device_unique_id',
                'class' => 'form-control',
                'required' => True,
            ],
        ]);

        // "status" field
        $this->add([
            'type' => 'Select',
            'name' => 'status',
            'options' => [
                'label' => 'Tình trạng thiết bị',
                'value_options' => [
                    0 => 'Disabled',
                    1 => 'Enabled',
                    2 => 'Pending',
                ]
            ],
            'attributes' => [
                'id' => 'status',
                'class' => 'form-control',
            ],
        ]);


        // "device_type_id" field
        $this->add([
            'type' => 'Select',
            'name' => 'device_type_id',
            'options' => [
                'label' => 'Loại thiết bị (*)',
                'value_options' => $this->getSelectDeviceTypeOptions(),
            ],
            'attributes' => [
                'id' => 'device_type_id',
                'class' => 'form-control',
            ],
        ]);

        // "description" field
        $this->add([
            'type' => 'Textarea',
            'name' => 'description',
            'options' => [
                'label' => 'Mô tả thiết bị',
            ],
            'attributes' => [
                'id' => 'description',
                'class' => 'form-control',
            ],
        ]);

        //image file
        $this->add([
            'type' => 'File',
            'name' => 'image',
            'options' => [
                'label' => 'Hình ảnh thiết bị',
            ],
            'attributes' => [
                'id' => 'image',
            ],
        ]);

    }


    /**
     * This method creates input filter (used for form filtering/validation).
     */
    private function addInputFilter() {

        // Create main input filter
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        // Add input for "device_unique_id" field
        $inputFilter->add([
            'name' => 'device_unique_id',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 255
                    ],
                ],
                /*[
                    'name' => UserExistsValidator::class,
                    'options' => [
                        'entityManager' => $this->entityManager,
                        'user' => $this->device
                    ],
                ],*/
            ],
        ]);

        // Add validation rules for the "file" field.
        $inputFilter->add([

            'type' => 'Zend\InputFilter\FileInput',
            'name' => 'image',
            'required' => false,
            'validators' => [
                ['name' => 'FileUploadFile'],
                [
                    'name' => 'FileMimeType',
                    'options' => [
                        'mimeType' => ['image/jpeg', 'image/png']
                    ]
                ],
                ['name' => 'FileIsImage'],
                [
                    'name' => 'FileImageSize',
                    'options' => [
                        'minWidth' => 128,
                        'minHeight' => 128,
                        'maxWidth' => 4096,
                        'maxHeight' => 4096
                    ]
                ],
            ],

            'filters' => [
                [
                    'name' => 'FileRenameUpload',
                    'options' => [
                        'target' => getcwd() . '/public/uploads',
                        'useUploadName' => true,
                        'useUploadExtension' => true,
                        'overwrite' => true,
                        'randomize' => true
                    ]
                ]
            ],

        ]);

    }

    //getSelectDeviceTypeOptions
    private function getSelectDeviceTypeOptions() {

        $selectData = array();

        $device_types = $this->entityManager->getRepository(Device_Type::class)
            ->findBy([], ['id' => 'ASC']);

        foreach ($device_types as $device_type) {
            if ($device_type instanceof Device_Type) {
                $selectData[$device_type->getId()] = $device_type->getName();
            }
        }

        return $selectData;

    }

    private function getSelectUserOptions() {

        $selectData = array();

        $selectData[0] = 'Chưa xác định';

        $users = $this->entityManager->getRepository(User::class)
            ->findBy([], ['id' => 'ASC']);

        foreach ($users as $user) {
            if ($user instanceof User) {
                $selectData[$user->getId()] = $user->getFullName();
            }
        }

        return $selectData;
    }


}