<?php


namespace rmatil\CmsBundle\Tests\Mapper;


use PHPUnit_Framework_TestCase;
use rmatil\CmsBundle\Entity\Location;
use rmatil\CmsBundle\Mapper\LocationMapper;
use rmatil\CmsBundle\Model\LocationDTO;

class LocationMapperTest extends PHPUnit_Framework_TestCase {

    /**
     * @var LocationMapper
     */
    private $locationMapper;

    public function setUp() {
        $this->locationMapper = new LocationMapper();
    }

    /**
     * @param $entity Location
     *
     * @dataProvider entityProvider
     */
    public function testEntityToDto($entity) {
        $dto = $this->locationMapper->entityToDto($entity);

        $this->assertEquals($entity->getId(), $dto->getId());
        $this->assertEquals($entity->getName(), $dto->getName());
        $this->assertEquals($entity->getAddress(), $dto->getAddress());
        $this->assertEquals($entity->getLongitude(), $dto->getLongitude());
        $this->assertEquals($entity->getLatitude(), $dto->getLatitude());
    }

    /**
     * @param $dto LocationDTO
     *
     * @dataProvider dtoProvider
     */
    public function testDtoToEntity($dto) {
        $entity = $this->locationMapper->dtoToEntity($dto);

        $this->assertEquals($dto->getId(), $entity->getId());
        $this->assertEquals($dto->getName(), $entity->getName());
        $this->assertEquals($dto->getAddress(), $entity->getAddress());
        $this->assertEquals($dto->getLongitude(), $entity->getLongitude());
        $this->assertEquals($dto->getLatitude(), $entity->getLatitude());
    }

    public function entityProvider() {
       $location = new Location();
       $location->setId(1);
       $location->setName('Some Name');
       $location->setAddress('Some Address, Somewhere');
       $location->setLongitude(124);
       $location->setLatitude(12.445);

        return [
            [$location]
        ];
    }

    public function dtoProvider() {
        $dto = new LocationDTO();
        $dto->setId(2);
        $dto->setName('Rio de Janeiro');
        $dto->setAddress('Rio D Janeiro, Brasilia');
        $dto->setLongitude(456.33);
        $dto->setLatitude(892.23);

        return [
            [$dto]
        ];
    }
}
