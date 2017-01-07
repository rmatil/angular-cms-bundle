<?php


namespace rmatil\CmsBundle\Model;


use DateTime;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\Type;

class UserDTO {

    /**
     * Id of the user
     *
     * @Type("integer")
     *
     * @var integer
     */
    protected $id;

    /**
     * Firstname of the user
     *
     * @Type("string")
     *
     * @var string
     */
    protected $firstName;

    /**
     * Lastname of the user
     *
     * @Type("string")
     *
     * @var string
     */
    protected $lastName;

    /**
     * Phone number of the user
     *
     * @type("string")
     *
     * @var string
     */
    protected $phoneNumber;

    /**
     * Mobile number of the user
     *
     * @type("string")
     *
     * @var string
     */
    protected $mobileNumber;

    /**
     * Address of the user
     *
     * @type("string")
     *
     * @var string
     */
    protected $address;

    /**
     * Zip code of the place
     *
     * @type("string")
     *
     * @var string
     */
    protected $zipCode;

    /**
     * Place where user is inhabitant
     *
     * @Type("string")
     *
     * @var string
     */
    protected $place;


    /**
     * Email address
     *
     * @Type("string")
     *
     * @var string
     */
    protected $email;

    /**
     * Whether the user is locked
     *
     * @Type("boolean")
     *
     * @var bool
     */
    protected $isLocked;

    /**
     * Whether the user account is expired
     *
     * @Type("boolean")
     *
     * @var bool
     */
    protected $isExpired;

    /**
     * Whether the user account is enabled
     *
     * @Type("boolean")
     *
     * @var bool
     */
    protected $isEnabled;

    /**
     * The date of the last login
     *
     * @Type("DateTime<'Y-m-d\TH:i:sP', 'UTC'>")
     *
     * @var \DateTime
     */
    protected $lastLoginDate;

    /**
     * All roles of the user
     *
     * @Type("array<string>")
     *
     * @var array
     */
    protected $roles = [];

    /**
     * @return int
     */
    public function getId(): ?int {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id = null) {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getFirstName(): ?string {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName = null) {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): ?string {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName = null) {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): ?string {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber(string $phoneNumber = null) {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return mixed
     */
    public function getMobileNumber(): ?string {
        return $this->mobileNumber;
    }

    /**
     * @param string $mobileNumber
     */
    public function setMobileNumber(string $mobileNumber = null) {
        $this->mobileNumber = $mobileNumber;
    }

    /**
     * @return string
     */
    public function getAddress(): ?string {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address = null) {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getZipCode(): ?string {
        return $this->zipCode;
    }

    /**
     * @param string $zipCode
     */
    public function setZipCode(string $zipCode = null) {
        $this->zipCode = $zipCode;
    }

    /**
     * @return string
     */
    public function getPlace(): ?string {
        return $this->place;
    }

    /**
     * @param string $place
     */
    public function setPlace(string $place = null) {
        $this->place = $place;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email = null) {
        $this->email = $email;
    }

    /**
     * @return boolean
     */
    public function isLocked(): ?bool {
        return $this->isLocked;
    }

    /**
     * @param boolean $isLocked
     */
    public function setIsLocked(bool $isLocked = null) {
        $this->isLocked = $isLocked;
    }

    /**
     * @return boolean
     */
    public function isExpired(): ?bool {
        return $this->isExpired;
    }

    /**
     * @param boolean $isExpired
     */
    public function setIsExpired(bool $isExpired = null) {
        $this->isExpired = $isExpired;
    }

    /**
     * @return boolean
     */
    public function isEnabled(): ?bool {
        return $this->isEnabled;
    }

    /**
     * @param boolean $isEnabled
     */
    public function setIsEnabled(bool $isEnabled = null) {
        $this->isEnabled = $isEnabled;
    }

    /**
     * @return \DateTime
     */
    public function getLastLoginDate(): ?DateTime {
        return $this->lastLoginDate;
    }

    /**
     * @param \DateTime $lastLoginDate
     */
    public function setLastLoginDate(DateTime $lastLoginDate = null) {
        $this->lastLoginDate = $lastLoginDate;
    }

    /**
     * @return array
     */
    public function getRoles(): ?array {
        return $this->roles;
    }

    /**
     * @param array $roles
     */
    public function setRoles(array $roles = null) {
        $this->roles = $roles;
    }
}
