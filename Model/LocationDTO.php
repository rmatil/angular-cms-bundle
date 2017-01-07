<?php


namespace rmatil\CmsBundle\Model;

use JMS\Serializer\Annotation\Type;

class LocationDTO {

    /**
     * @Type("integer")
     *
     * @var integer
     */
    private $id;

    /**
     * @Type("string")
     *
     * @var string
     */
    private $name;

    /**
     * @Type("string")
     *
     * @var string
     */
    private $address;

    /**
     * @Type("double")
     *
     * @var float
     */
    private $longitude;

    /**
     * @Type("double")
     *
     * @var float
     */
    private $latitude;

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
    public function getName(): ?string {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name = null) {
        $this->name = $name;
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
     * @return float
     */
    public function getLongitude(): ?float {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     */
    public function setLongitude(float $longitude = null) {
        $this->longitude = $longitude;
    }

    /**
     * @return float
     */
    public function getLatitude(): ?float {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     */
    public function setLatitude(float $latitude = null) {
        $this->latitude = $latitude;
    }
}
