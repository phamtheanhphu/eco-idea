<?php
namespace User\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity()
 * @ORM\Table(name="users")
 */
class User {

    // User status constants.
    const STATUS_ACTIVE = 1; // Active user.
    const STATUS_RETIRED = 2; // Retired user.

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(name="email", length=255)
     */
    protected $email;

    /**
     * @ORM\Column(name="full_name", length=255)
     */
    protected $fullName;

    /**
     * @ORM\Column(name="password")
     */
    protected $password;

    /**
     * @ORM\Column(name="date_created")
     */
    protected $date_created;

    /**
     * @ORM\Column(name="status", nullable=False)
     */
    protected $status;

    /**
     * @ORM\ManyToMany(targetEntity="\User\Entity\Group", inversedBy="groups")
     * @ORM\JoinTable(name="user_group_maps",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id", onDelete="CASCADE")}
     *      )
     */
    protected $groups;

    /**
     * @ORM\OneToMany(targetEntity="\Device\Entity\Device", mappedBy="user")
     * @ORM\JoinColumn(name="id", referencedColumnName="user_id")
     */
    protected $devices;


    /**
     * @ORM\Column(name="pwd_reset_token", nullable=True)
     */
    protected $password_reset_token;

    /**
     * @ORM\Column(name="pwd_reset_token_creation_date", nullable=True)
     */
    protected $pwd_reset_token_creation_date;


    /**
     * User constructor.
     */
    public function __construct() {
        $this->groups = new ArrayCollection();
    }

    /**
     * Returns user ID.
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Sets user ID.
     * @param int $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * Returns email.
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Sets email.
     * @param string $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * Returns full name.
     * @return string
     */
    public function getFullName() {
        return $this->fullName;
    }

    /**
     * Sets full name.
     * @param string $fullName
     */
    public function setFullName($fullName) {
        $this->fullName = $fullName;
    }

    /**
     * Returns status.
     * @return int
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Returns possible statuses as array.
     * @return array
     */
    public static function getStatusList() {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_RETIRED => 'Retired'
        ];
    }

    /**
     * Returns user status as string.
     * @return string
     */
    public function getStatusAsString() {
        $list = self::getStatusList();
        if (isset($list[$this->status]))
            return $list[$this->status];

        return 'Unknown';
    }

    /**
     * Sets status.
     * @param int $status
     */
    public function setStatus($status) {
        $this->status = $status;
    }

    /**
     * Returns password.
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Sets password.
     * @param string $password
     */
    public function setPassword($password) {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getDateCreated() {
        return $this->date_created;
    }

    /**
     * @param mixed $date_created
     */
    public function setDateCreated($date_created) {
        $this->date_created = $date_created;
    }

    /**
     * @return mixed
     */
    public function getGroups() {
        return $this->groups;
    }

    public function getFirstGroup() {
        if ($this->groups != null) {
            return $this->groups[0];
        }
        return null;
    }

    /**
     * @param mixed $groups
     */
    public function setGroups($groups) {
        $this->groups[] = $groups;
    }


    public function addToGroup($group) {
        $this->groups[] = $group;
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
        $this->devices = $devices;
    }

    /**
     * @return mixed
     */
    public function getPasswordResetToken() {
        return $this->password_reset_token;
    }

    /**
     * @param mixed $password_reset_token
     */
    public function setPasswordResetToken($password_reset_token) {
        $this->password_reset_token = $password_reset_token;
    }

    /**
     * @return mixed
     */
    public function getPwdResetTokenCreationDate() {
        return $this->pwd_reset_token_creation_date;
    }

    /**
     * @param mixed $pwd_reset_token_creation_date
     */
    public function setPwdResetTokenCreationDate($pwd_reset_token_creation_date) {
        $this->pwd_reset_token_creation_date = $pwd_reset_token_creation_date;
    }


}



