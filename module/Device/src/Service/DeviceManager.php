<?php
namespace Device\Service;


use Device\Entity\Device;
use Device\Entity\Device_Type;
use Device\Entity\Record\DeviceConfigRecord;
use User\Entity\User;

class DeviceManager {

    private $smart_farm_device_default_config = [
        'automatic_mode_enable' => '1',
        'send_data_to_server_interval' => '5',
        'send_state_to_server_interval' => '5',
        'get_command_from_server_interval' => '5'
    ];

    /**
     * Doctrine entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Constructs the service.
     */
    public function __construct($entityManager) {
        $this->entityManager = $entityManager;
    }

    public function addDevice($data, $device_type = 'smart_farm_device') {

        $device = new Device();

        //device unique id
        $device->setDeviceUniqueId($data['device_unique_id']);

        //device type
        $device_type = $this->entityManager->getRepository(Device_Type::class)
            ->find($data['device_type_id']);
        $device->setType($device_type);

        //status
        $device->setStatus($data['status']);

        //date_implemented
        $device->setDateImplemented(new \DateTime());

        //description
        $device->setDescription($data['description']);

        //image file
        $device->setImage(basename($data['image']['tmp_name']));

        // Add the entity to the entity manager.
        $this->entityManager->persist($device);

        // Apply changes to database.
        $this->entityManager->flush();

        //initialize device's configs
        if ($device_type = 'smart_farm_device') {

            foreach ($this->smart_farm_device_default_config as $attribute => $value) {
                $config = new DeviceConfigRecord();
                $config->setDevice($device);
                $config->setAttribute($attribute);
                $config->setValue($value);
                $device->addConfigRecord($config);
            }

        }

        // Apply changes to database.
        $this->entityManager->flush();

        return $device;

    }

    //update device information
    public function updateDevice($device, $data) {

        if ($device instanceof Device) {

            //user_id
            if ($data['user_id']) {
                $user = $this->entityManager->getRepository(User::class)
                    ->findOneById($data['user_id']);
                if ($user != null && $user instanceof User) {
                    $device->setUser($user);
                }
            }

            //device unique id
            $device->setDeviceUniqueId($data['device_unique_id']);

            //device type
            $device_type = $this->entityManager->getRepository(Device_Type::class)
                ->find($data['device_type_id']);
            $device->setType($device_type);

            //status
            $device->setStatus($data['status']);

            //description
            $device->setDescription($data['description']);

            //image file
            if (strlen($data['image']['tmp_name']) > 0) {
                $device->setImage(basename($data['image']['tmp_name']));
            }

            // Apply changes to database.
            $this->entityManager->flush();

            return true;

        }

        return false;

    }

    //update device's configs
    public function updateDeviceConfigs($device_type = 'smart_farm_device', Device $device, $data) {

        //update device's configs
        if ($device_type == 'smart_farm_device') {

            $current_configs = $device->getConfigRecords();

            foreach ($current_configs as $config) {

                if($config instanceof DeviceConfigRecord) {
                    if(isset($data[$config->getAttribute()])) {
                        $config->setValue($data[$config->getAttribute()]);
                    }
                }

            }

            // Apply changes to database.
            $this->entityManager->flush();

            return true;

        }

        return false;

    }


}

