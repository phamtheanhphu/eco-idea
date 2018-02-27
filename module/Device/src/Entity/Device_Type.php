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
 * @ORM\Table(name="device_types")
 */
class Device_Type {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(name="name", type="string", length=255, unique=True, nullable=False)
     */
    protected $name;

    /**
     * @ORM\Column(name="description", nullable=True)
     */
    protected $description;

    /**
     * @ORM\OneToMany(targetEntity="\Device\Entity\Device", mappedBy="type")
     * @ORM\JoinColumn(name="id", referencedColumnName="device_type_id")
     */
    protected $devices;

    /**
     * Device_Type constructor.
     */
    public function __construct() {
        $this->devices = new ArrayCollection();
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
    public function getName() {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name) {
        $this->name = $name;
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
    public function getDevices() {
        return $this->devices;
    }

    /**
     * @param mixed $devices
     */
    public function setDevices($devices) {
        $this->devices[] = $devices;
    }


}