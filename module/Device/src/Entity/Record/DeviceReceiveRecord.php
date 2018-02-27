<?php
/**
 * Created by PhpStorm.
 * User: phu.pham
 * Date: 26/2/2018
 * Time: 10:46 AM
 */

namespace Device\Entity\Record;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="device_receive_records")
 */
class DeviceReceiveRecord {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="\Device\Entity\Device", inversedBy="receive_records")
     * @ORM\JoinColumn(name="device_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $device;

    /**
     * @ORM\Column(name="temperature", length=255, nullable=True)
     */
    protected $temperature;

    /**
     * @ORM\Column(name="moisture", length=255, nullable=True)
     */
    protected $moisture;

    /**
     * @ORM\Column(name="light", length=255, nullable=True)
     */
    protected $light;


    /**
     * @ORM\Column(name="received_datetime", type="datetime")
     */
    protected $received_datetime;

    /**
     * DeviceReceiveRecord constructor.
     */
    public function __construct() { }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getDevice() {
        return $this->device;
    }

    /**
     * @param mixed $device
     */
    public function setDevice($device) {
        $this->device = $device;
    }

    /**
     * @return mixed
     */
    public function getTemperature() {
        return $this->temperature;
    }

    /**
     * @param mixed $temperature
     */
    public function setTemperature($temperature) {
        $this->temperature = $temperature;
    }

    /**
     * @return mixed
     */
    public function getMoisture() {
        return $this->moisture;
    }

    /**
     * @param mixed $moisture
     */
    public function setMoisture($moisture) {
        $this->moisture = $moisture;
    }

    /**
     * @return mixed
     */
    public function getLight() {
        return $this->light;
    }

    /**
     * @param mixed $light
     */
    public function setLight($light) {
        $this->light = $light;
    }

    /**
     * @return mixed
     */
    public function getReceivedDatetime() {
        return $this->received_datetime;
    }

    /**
     * @param mixed $received_datetime
     */
    public function setReceivedDatetime($received_datetime) {
        $this->received_datetime = $received_datetime;
    }

    public function toJsonArray() {
        return [
            'device_id' => $this->device->getId(),
            'device_unique_id' => $this->device->getDeviceUniqueId(),
            'temperature' => (isset($this->temperature)) ? $this->temperature : null,
            'moisture' => (isset($this->moisture)) ? $this->moisture : null,
            'light' => (isset($this->light)) ? $this->light : null,
        ];
    }


}