<?php


namespace rmatil\CmsBundle\Mapper;


use rmatil\CmsBundle\Entity\Event;
use rmatil\CmsBundle\Exception\MapperException;
use rmatil\CmsBundle\Model\EventDTO;

class EventMapper extends AbstractMapper {

    protected $userMapper;
    protected $fileMapper;
    protected $locationMapper;
    protected $repeatOptionMapper;
    protected $userGroupMapper;

    public function __construct(UserMapper $userMapper, FileMapper $fileMapper, LocationMapper $locationMapper, RepeatOptionMapper $repeatOptionMapper, UserGroupMapper $userGroupMapper) {
        $this->userMapper = $userMapper;
        $this->fileMapper = $fileMapper;
        $this->locationMapper = $locationMapper;
        $this->repeatOptionMapper = $repeatOptionMapper;
        $this->userGroupMapper = $userGroupMapper;
    }

    /**
     * {@inheritdoc}
     *
     * @param $event Event
     *
     * @return EventDTO
     */
    public function entityToDto($event) {
        if (null === $event) {
            return null;
        }

        if ( ! ($event instanceof Event)) {
            throw new MapperException(sprintf('Required object of type "%s" but got "%s"', Event::class, get_class($event)));
        }

        $dto = new EventDTO();
        $dto->setId($event->getId());
        $dto->setAuthor($this->userMapper->entityToDto($event->getAuthor()));
        $dto->setLocation($this->locationMapper->entityToDto($event->getLocation()));
        $dto->setFile($this->fileMapper->entityToDto($event->getFile()));
        $dto->setName($event->getName());
        $dto->setContent($event->getContent());
        $dto->setAdditionalInfo($event->getAdditionalInfo());
        $dto->setRepeatOption($this->repeatOptionMapper->entityToDto($event->getRepeatOption()));
        $dto->setStartDate($event->getStartDate());
        $dto->setEndDate($event->getEndDate());
        $dto->setLastEditDate($event->getLastEditDate());
        $dto->setCreationDate($event->getCreationDate());
        $dto->setAllowedUserGroup($this->userGroupMapper->entityToDto($event->getAllowedUserGroup()));
        $dto->setUrlName($event->getUrlName());

        return $dto;
    }

    /**
     * {@inheritdoc}
     *
     * @param $dto EventDTO
     *
     * @return Event
     */
    public function dtoToEntity($eventDto) {
        if (null === $eventDto) {
            return null;
        }

        if ( ! ($eventDto instanceof EventDTO)) {
            throw new MapperException(sprintf('Required object of type "%s" but got "%s"', Event::class, get_class($eventDto)));
        }

        $event = new Event();
        $event->setId($eventDto->getId());
        $event->setAuthor($this->userMapper->dtoToEntity($eventDto->getAuthor()));
        $event->setLocation($this->locationMapper->dtoToEntity($eventDto->getLocation()));
        $event->setFile($this->fileMapper->dtoToEntity($eventDto->getFile()));
        $event->setName($eventDto->getName());
        $event->setContent($eventDto->getContent());
        $event->setAdditionalInfo($eventDto->getAdditionalInfo());
        $event->setRepeatOption($this->repeatOptionMapper->dtoToEntity($eventDto->getRepeatOption()));
        $event->setStartDate($eventDto->getStartDate());
        $event->setEndDate($eventDto->getEndDate());
        $event->setLastEditDate($eventDto->getLastEditDate());
        $event->setCreationDate($eventDto->getCreationDate());
        $event->setAllowedUserGroup($this->userGroupMapper->dtoToEntity($eventDto->getAllowedUserGroup()));
        $event->setUrlName($eventDto->getUrlName());

        return $event;
    }
}
