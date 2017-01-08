<?php


namespace rmatil\CmsBundle\DataAccessor;


use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use rmatil\CmsBundle\Constants\EntityNames;
use rmatil\CmsBundle\Entity\Location;
use rmatil\CmsBundle\Exception\EntityInvalidException;
use rmatil\CmsBundle\Exception\EntityNotDeletedException;
use rmatil\CmsBundle\Exception\EntityNotFoundException;
use rmatil\CmsBundle\Exception\EntityNotUpdatedException;
use rmatil\CmsBundle\Mapper\LocationMapper;
use rmatil\CmsBundle\Model\LocationDTO;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class LocationDataAccessor extends DataAccessor {

    protected $locationMapper;

    public function __construct(EntityManagerInterface $em, LocationMapper $locationMapper, TokenStorageInterface $tokenStorage, LoggerInterface $logger) {
        parent::__construct(EntityNames::LOCATION, $em, $tokenStorage, $logger);

        $this->locationMapper = $locationMapper;
    }

    public function getAll() {
        return $this->locationMapper->entitiesToDtos(parent::getAll());
    }

    public function getById($id) {
        return $this->locationMapper->entityToDto(parent::getById($id));
    }

    public function update($locationDto) {
        if ( ! ($locationDto instanceof LocationDTO)) {
            throw new EntityInvalidException(sprintf('Required object of type "%s" but got "%s"', LocationDTO::class, get_class($locationDto)));
        }

        $location = $this->locationMapper->dtoToEntity($locationDto);

        /** @var \rmatil\CmsBundle\Entity\Location $dbLocation */
        $dbLocation = $this->em->getRepository($this->entityName)->find($location->getId());

        if (null === $dbLocation) {
            throw new EntityNotFoundException(sprintf('Entity "%s" with id "%s" not found', $this->entityName, $location->getId()));
        }

        $dbLocation->setName($location->getName());
        $dbLocation->setAddress($location->getAddress());
        $dbLocation->setLongitude($location->getLongitude());
        $dbLocation->setLatitude($location->getLatitude());

        try {
            $this->em->flush();

        } catch (DBALException $dbalex) {
            $this->logger->error($dbalex);

            throw new EntityNotUpdatedException(sprintf('Could not update entity "%s" with id "%s"', $this->entityName, $location->getId()));
        }

        return $this->locationMapper->entityToDto($dbLocation);
    }

    public function insert($locationDto) {
        if ( ! ($locationDto instanceof LocationDTO)) {
            throw new EntityInvalidException(sprintf('Required object of type "%s" but got "%s"', LocationDTO::class, get_class($locationDto)));
        }

        $location = $this->locationMapper->dtoToEntity($locationDto);

        $this->em->persist($location);

        try {
            $this->em->flush();

        } catch (DBALException $dbalex) {
            $this->logger->error($dbalex);

            throw new EntityNotUpdatedException(sprintf('Could not update entity "%s" with id "%s"', $this->entityName, $location->getId()));
        }

        return $this->locationMapper->entityToDto($location);
    }

    public function delete($id) {
        $location = $this->em->getRepository(EntityNames::LOCATION)->find($id);

        if ( ! ($location instanceof Location)) {
            throw new EntityNotFoundException(sprintf('Could not find location with id "%s"', $id));
        }

        /** @var \rmatil\CmsBundle\Entity\Event[] $attachedEvents */
        $attachedEvents = $this->em->getRepository(EntityNames::EVENT)->findBy([
            'location' => $location->getId()
        ]);

        foreach ($attachedEvents as $event) {
            $event->setLocation(null);
        }

        $this->em->remove($location);

        try {
            $this->em->flush();
        } catch (DBALException $dbalex) {
            $this->logger->error($dbalex);

            throw new EntityNotDeletedException(sprintf('Could not delete location with id "%s"', $id));
        }
    }
}
