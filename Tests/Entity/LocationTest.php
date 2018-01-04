<?php


namespace rmatil\CmsBundle\Tests\Entity;


use PHPUnit\Framework\TestCase;
use rmatil\CmsBundle\Entity\Location;

class LocationTest extends TestCase {

    /**
     * @var Location
     */
    private $location;

    public function setUp() {
        $this->location = new Location();
    }

    /**
     * @dataProvider  dataProvider
     */
    public function testAccessors($id, $name, $address, $longitude, $latitude) {
        $this->location->setId($id);
        $this->location->setName($name);
        $this->location->setAddress($address);
        $this->location->setLongitude($longitude);
        $this->location->setLatitude($latitude);

        $this->assertEquals($id, $this->location->getId());
        $this->assertEquals($name, $this->location->getName());
        $this->assertEquals($address, $this->location->getAddress());
        $this->assertEquals($longitude, $this->location->getLongitude());
        $this->assertEquals($latitude, $this->location->getLatitude());
    }

    public function dataProvider() {
        return [
            [1, 'Fitzgerald Street', 'Fitzgeraldstreet 12', '123', '456'],
            [1, 'Rheinbachstrasse 12', 'Rheinbachstrasse 15, 8000 Zürich', '123', '456']
        ];
    }
}
