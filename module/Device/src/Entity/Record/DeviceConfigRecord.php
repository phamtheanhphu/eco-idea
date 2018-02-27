<?php
/**
 * Created by PhpStorm.
 * User: phu.pham
 * Date: 26/2/2018
 * Time: 2:30 PM
 */
namespace Device\Entity\Record;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="device_config_records")
 */
class DeviceConfigRecord {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="\Device\Entity\Device", inversedBy="config_records", cascade={"persist"})
     * @ORM\JoinColumn(name="device_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $device;

    /**
     * @ORM\Column(name="attribute", length=255)
     */
    protected $attribute;

    /**
     * @ORM\Column(name="value", length=255)
     */
    protected $value;

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
    public function getAttribute() {
        return $this->attribute;
    }

    /**
     * @param mixed $attribute
     */
    public function setAttribute($attribute) {
        $this->attribute = $attribute;
    }

    /**
     * @return mixed
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value) {
        $this->value = $value;
    }



}
