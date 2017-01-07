<?php

namespace rmatil\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="locations")
 **/
class Location {

    /**
     * Id of the location
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     *
     * @var integer
     */
    protected $id;

    /**
     * name of the location
     *
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $name;

    /**
     * address of the location
     *
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $address;

    /**
     * longitude of the location
     *
     * @ORM\Column(type="float")
     *
     * @var float
     */
    protected $longitude;

    /**
     * latitude of the location
     *
     * @ORM\Column(type="float")
     *
     * @var float
     */
    protected $latitude;

    /**
     * Gets the Id of the location.
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Sets the Id of the location.
     *
     * @param integer $id the id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * Gets the name of the location.
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Sets the name of the location.
     *
     * @param string $name the name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Gets the address of the location.
     *
     * @return string
     */
    public function getAddress() {
        return $this->address;
    }

    /**
     * Sets the address of the location.
     *
     * @param string $address the address
     */
    public function setAddress($address) {
        $this->address = $address;
    }

    /**
     * Gets the longitude of the location.
     *
     * @return float
     */
    public function getLongitude() {
        return $this->longitude;
    }

    /**
     * Sets the longitude of the location.
     *
     * @param float $longitude the longitude
     */
    public function setLongitude($longitude) {
        $this->longitude = $longitude;
    }

    /**
     * Gets the latitude of the location.
     *
     * @return float
     */
    public function getLatitude() {
        return $this->latitude;
    }

    /**
     * Sets the latitude of the location.
     *
     * @param float $latitude the latitude
     */
    public function setLatitude($latitude) {
        $this->latitude = $latitude;
    }
}
