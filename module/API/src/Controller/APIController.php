<?php
/**
 * Created by PhpStorm.
 * User: phu.pham
 * Date: 26/2/2018
 * Time: 11:00 AM
 */

namespace API\Controller;

use API\Entity\HttpResponse;
use Device\Entity\Device;
use Device\Entity\Record\DeviceConfigRecord;
use Device\Entity\Record\DeviceReceiveRecord;
use Zend\Mvc\Controller\AbstractRestfulController;

class APIController extends AbstractRestfulController {

    /**
     * Entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * APIController constructor.
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function __construct(\Doctrine\ORM\EntityManager $entityManager) {
        $this->entityManager = $entityManager;
    }


    public function testAction() {
        echo 'test';
        exit();
    }

    //get-config
    public function getConfigAction() {

        $response = new HttpResponse();
        $request = $this->getRequest();

        if ($request->isPost()) {

            $response->setResult(false);

            $queryParams = $request->getQuery()->toArray();

            $device_unique_id = $queryParams['id'];

            if ($device_unique_id) {

                $device = $this->entityManager->getRepository(Device::class)
                    ->findOneBy(['device_unique_id' => $device_unique_id]);

                if ($device != null && $device instanceof Device) {

                    try {

                        $configs = $device->getConfigRecords()->toArray();
                        $configAsArray = [];

                        $config_attribute_code_maps = [
                            'automatic_mode_enable' => 'c1',
                            'send_data_to_server_interval' => 'c2',
                            'send_state_to_server_interval' => 'c3',
                            'get_command_from_server_interval' => 'c4',
                        ];

                        foreach ($configs as $config) {
                            if ($config instanceof DeviceConfigRecord) {
                                $configAsArray[$config_attribute_code_maps[$config->getAttribute()]] = $config->getValue();
                            }
                        }

                        $response->setResult(true);
                        $response->setData($configAsArray);


                    } catch (\Exception $e) {

                        //$response->setErrorMessages('Xảy ra lỗi trong quá trình cập nhật dữ liệu !');

                    }

                }

            }

            return $response->generate_json_response();

        }

        exit();
    }

    //send-data
    public function sendDataAction() {

        $response = new HttpResponse();
        $request = $this->getRequest();

        if ($request->isPost()) {

            $response->setResult(false);

            $queryParams = $request->getQuery()->toArray();

            $device_unique_id = $queryParams['id'];

            if ($device_unique_id) {

                $device = $this->entityManager->getRepository(Device::class)
                    ->findOneBy(['device_unique_id' => $device_unique_id]);

                if ($device != null && $device instanceof Device) {

                    try {

                        $current_timestamp = new \DateTime('now');

                        $receive_record = new DeviceReceiveRecord();
                        $receive_record->setDevice($device);
                        $receive_record->setReceivedDatetime($current_timestamp);

                        //temperature sensor -> s1
                        $receive_record->setTemperature((isset($queryParams['s1'])) ? $queryParams['s1'] : null);

                        //moisture sensor -> s2
                        $receive_record->setMoisture((isset($queryParams['s2'])) ? $queryParams['s2'] : null);

                        //light sensor -> s3
                        $receive_record->setLight((isset($queryParams['s3'])) ? $queryParams['s3'] : null);

                        $this->entityManager->persist($receive_record);
                        $this->entityManager->flush();

                        $response->setResult(true);
                        //$response->setData($receive_record->toJsonArray());

                    } catch (\Exception $e) {
                        //$response->setErrorMessages('Xảy ra lỗi trong quá trình cập nhật dữ liệu !');
                    }

                }

            }

            return $response->generate_json_response();
        }

        exit();

    }


}