<?php


namespace rmatil\CmsBundle\Mapper;


use rmatil\CmsBundle\Entity\Location;
use rmatil\CmsBundle\Exception\MapperException;
use rmatil\CmsBundle\Model\LocationDTO;

class LocationMapper extends AbstractMapper {

    /**
     * {@inheritdoc}
     *
     * @return LocationDTO
     */
    public function entityToDto($location) {
        if (null === $location) {
            return null;
        }

        if ( ! ($location instanceof Location)) {
            throw new MapperException(sprintf('Required object of type "%s" but got "%s"', Location::class, get_class($location)));
        }

        $locationDto = new LocationDTO();
        $locationDto->setId($location->getId());
        $locationDto->setName($location->getName());
        $locationDto->setAddress($location->getAddress());
        $locationDto->setLongitude($location->getLongitude());
        $locationDto->setLatitude($location->getLatitude());

        return $locationDto;
    }

    /**
     * {@inheritdoc}
     *
     * @return Location
     */
    public function dtoToEntity($locationDto) {
        if (null === $locationDto) {
            return null;
        }

        if ( ! ($locationDto instanceof LocationDTO)) {
            throw new MapperException(sprintf('Required object of type "%s" but got "%s"', LocationDTO::class, get_class($locationDto)));
        }

        $location = new Location();
        $location->setId($locationDto->getId());
        $location->setName($locationDto->getName());
        $location->setAddress($locationDto->getAddress());
        $location->setLongitude($locationDto->getLongitude());
        $location->setLatitude($locationDto->getLatitude());

        return $location;
    }
}
