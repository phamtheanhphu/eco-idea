<?php
/**
 * Created by PhpStorm.
 * User: PHUPHAM
 * Date: 1/22/2018
 * Time: 9:23 PM
 */

namespace Device\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="devices")
 */
class Device {

    const STATUS_DISABLE = 0; // Device is disable by admin.
    const STATUS_ENABLE = 1; // Device is enable by admin.
    const STATUS_PENDING = 2; // Device is pending by admin.

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(name="device_unique_id", length=255, nullable=False)
     */
    protected $device_unique_id;


    /**
     * @ORM\Column(name="date_implemented", type="date")
     */
    protected $date_implemented;

    /**
     * @ORM\Column(name="status", type="smallint")
     */
    protected $status = self::STATUS_DISABLE;

    /**
     * @ORM\Column(name="description", nullable=True)
     */
    protected $description;

    /**
     * @ORM\Column(name="image", nullable=True)
     */
    protected $image;

    /**
     * @ORM\ManyToOne(targetEntity="\Device\Entity\Device_Type", inversedBy="devices")
     * @ORM\JoinColumn(name="device_type_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $type;

    /**
     * @ORM\ManyToOne(targetEntity="\User\Entity\User", inversedBy="devices")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $user;

    /**
     * @ORM\OneToMany(targetEntity="\Device\Entity\Record\DeviceConfigRecord", mappedBy="device", cascade={"persist"})
     * @ORM\JoinColumn(name="id", referencedColumnName="device_id")
     */
    protected $config_records;

    /**
     * @ORM\OneToMany(targetEntity="\Device\Entity\Record\DeviceReceiveRecord", mappedBy="device")
     * @ORM\JoinColumn(name="id", referencedColumnName="device_id")
     * @ORM\OrderBy({"id" = "DESC"})
     */
    protected $receive_records;

    /**
     * Device constructor.
     */
    public function __construct() {
        $this->config_records = new ArrayCollection();
        $this->receive_records = new ArrayCollection();
    }

    // getArrayCopy
    public function getArrayCopy() {
        return get_object_vars($this);
    }

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
    public function getDeviceUniqueId() {
        return $this->device_unique_id;
    }

    /**
     * @param mixed $device_unique_id
     */
    public function setDeviceUniqueId($device_unique_id) {
        $this->device_unique_id = $device_unique_id;
    }

    /**
     * @return mixed
     */
    public function getDateImplemented() {
        return $this->date_implemented;
    }

    /**
     * @param mixed $date_implemented
     */
    public function setDateImplemented($date_implemented) {
        $this->date_implemented = $date_implemented;
    }

    /**
     * @return mixed
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status) {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image) {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type) {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user) {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getReceiveRecords() {
        return $this->receive_records;
    }

    /**
     * @param mixed $receive_records
     */
    public function setReceiveRecords($receive_records) {
        $this->receive_records = $receive_records;
    }

    /**
     * @return mixed
     */
    public function getConfigRecords() {
        return $this->config_records;
    }

    /**
     * @param mixed $config_records
     */
    public function setConfigRecords($config_records) {
        $this->config_records = $config_records;
    }

    public function addConfigRecord($config_record) {
        $this->config_records[] = $config_record;
    }



}