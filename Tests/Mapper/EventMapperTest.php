<?php


namespace rmatil\CmsBundle\Tests\Mapper;


use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use rmatil\CmsBundle\Entity\Event;
use rmatil\CmsBundle\Entity\EventDetail;
use rmatil\CmsBundle\Entity\File;
use rmatil\CmsBundle\Entity\Location;
use rmatil\CmsBundle\Entity\Offer;
use rmatil\CmsBundle\Entity\RepeatOption;
use rmatil\CmsBundle\Entity\User;
use rmatil\CmsBundle\Entity\UserGroup;
use rmatil\CmsBundle\Mapper\EventDetailMapper;
use rmatil\CmsBundle\Mapper\EventMapper;
use rmatil\CmsBundle\Mapper\FileMapper;
use rmatil\CmsBundle\Mapper\LocationMapper;
use rmatil\CmsBundle\Mapper\OfferMapper;
use rmatil\CmsBundle\Mapper\RepeatOptionMapper;
use rmatil\CmsBundle\Mapper\UserGroupMapper;
use rmatil\CmsBundle\Mapper\UserMapper;
use rmatil\CmsBundle\Model\EventDetailDTO;
use rmatil\CmsBundle\Model\EventDTO;
use rmatil\CmsBundle\Model\FileDTO;
use rmatil\CmsBundle\Model\LocationDTO;
use rmatil\CmsBundle\Model\OfferDTO;
use rmatil\CmsBundle\Model\RepeatOptionDTO;
use rmatil\CmsBundle\Model\UserDTO;
use rmatil\CmsBundle\Model\UserGroupDTO;

class EventMapperTest extends TestCase {

    /**
     * @var UserMapper
     */
    private $userMapper;

    /**
     * @var FileMapper
     */
    private $fileMapper;

    /**
     * @var LocationMapper
     */
    private $locationMapper;

    /**
     * @var RepeatOptionMapper
     */
    private $repeatOptionMapper;

    /**
     * @var UserGroupMapper
     */
    private $userGroupMapper;

    /**
     * @var EventMapper
     */
    private $eventMapper;

    /**
     * @var EventDetailMapper
     */
    private $eventDetailMapper;

    public function setUp() {
        $this->userMapper = new UserMapper();
        $this->fileMapper = new FileMapper($this->userMapper);
        $this->locationMapper = new LocationMapper();
        $this->repeatOptionMapper = new RepeatOptionMapper();
        $this->userGroupMapper = new UserGroupMapper();
        $this->eventDetailMapper = new EventDetailMapper(new OfferMapper());

        $this->eventMapper = new EventMapper(
            $this->userMapper,
            $this->fileMapper,
            $this->locationMapper,
            $this->repeatOptionMapper,
            $this->userGroupMapper,
            $this->eventDetailMapper
        );
    }

    /**
     * @dataProvider entityProvider
     *
     * @param $event Event
     */
    public function testEntityToDto($event) {
        $dto = $this->eventMapper->entityToDto($event);

        $this->assertEquals($event->getId(), $dto->getId());
        $this->assertEquals($this->userMapper->entityToDto($event->getAuthor()), $dto->getAuthor());
        $this->assertEquals($this->locationMapper->entityToDto($event->getLocation()), $dto->getLocation());
        $this->assertEquals($this->fileMapper->entityToDto($event->getFile()), $dto->getFile());
        $this->assertEquals($event->getName(), $dto->getName());
        $this->assertEquals($event->getContent(), $dto->getContent());
        $this->assertEquals($event->getAdditionalInfo(), $dto->getAdditionalInfo());
        $this->assertEquals($this->repeatOptionMapper->entityToDto($event->getRepeatOption()), $dto->getRepeatOption());
        $this->assertEquals($event->getStartDate(), $dto->getStartDate());
        $this->assertEquals($event->getEndDate(), $dto->getEndDate());
        $this->assertEquals($event->getLastEditDate(), $dto->getLastEditDate());
        $this->assertEquals($event->getCreationDate(), $dto->getCreationDate());
        $this->assertEquals($this->userGroupMapper->entityToDto($event->getAllowedUserGroup()), $dto->getAllowedUserGroup());
        $this->assertEquals($event->getUrlName(), $dto->getUrlName());
        $this->assertEquals($this->eventDetailMapper->entityToDto($event->getEventDetail()), $dto->getEventDetail());
    }

    /**
     * @dataProvider dtoProvider
     *
     * @param $dto EventDTO
     */
    public function testDtoToEntity($dto) {
        $event = $this->eventMapper->dtoToEntity($dto);

        $this->assertEquals($dto->getId(), $event->getId());
        $this->assertEquals($this->userMapper->dtoToEntity($dto->getAuthor()), $event->getAuthor());
        $this->assertEquals($this->locationMapper->dtoToEntity($dto->getLocation()), $event->getLocation());
        $this->assertEquals($this->fileMapper->dtoToEntity($dto->getFile()), $event->getFile());
        $this->assertEquals($dto->getName(), $event->getName());
        $this->assertEquals($dto->getContent(), $event->getContent());
        $this->assertEquals($dto->getAdditionalInfo(), $event->getAdditionalInfo());
        $this->assertEquals($this->repeatOptionMapper->dtoToEntity($dto->getRepeatOption()), $event->getRepeatOption());
        $this->assertEquals($dto->getStartDate(), $event->getStartDate());
        $this->assertEquals($dto->getEndDate(), $event->getEndDate());
        $this->assertEquals($dto->getLastEditDate(), $event->getLastEditDate());
        $this->assertEquals($dto->getCreationDate(), $event->getCreationDate());
        $this->assertEquals($this->userGroupMapper->dtoToEntity($dto->getAllowedUserGroup()), $event->getAllowedUserGroup());
        $this->assertEquals($dto->getUrlName(), $event->getUrlName());
        $this->assertEquals($this->eventDetailMapper->dtoToEntity($dto->getEventDetail()), $event->getEventDetail());
    }

    public function entityProvider() {
        $author = new User();
        $author->setId(1);
        $location = new Location();
        $location->setId(1);
        $file = new File();
        $file->setId(1);
        $option = new RepeatOption();
        $option->setId(1);
        $userGroup = new UserGroup();
        $userGroup->setId(1);
        $eventDetail = new EventDetail();
        $eventDetail->setOffers(new ArrayCollection([new Offer()]));

        $event = new Event();
        $event->setId(1);
        $event->setAuthor($author);
        $event->setLocation($location);
        $event->setFile($file);
        $event->setName('name');
        $event->setContent('content');
        $event->setAdditionalInfo('info');
        $event->setRepeatOption($option);
        $event->setStartDate(new DateTime());
        $event->setEndDate(new DateTime());
        $event->setLastEditDate(new DateTime());
        $event->setCreationDate(new DateTime());
        $event->setAllowedUserGroup($userGroup);
        $event->setUrlName('url-name');
        $event->setEventDetail($eventDetail);

        return [
            [$event]
        ];
    }

    public function dtoProvider() {
        $author = new UserDTO();
        $eventDetail = new EventDetailDTO();
        $eventDetail->setOffers([new OfferDTO()]);

        $dto = new EventDTO();
        $dto->setId(1);
        $dto->setAuthor($author);
        $dto->setLocation(new LocationDTO());
        $dto->setFile(new FileDTO());
        $dto->setName('name');
        $dto->setContent('content');
        $dto->setAdditionalInfo('add info');
        $dto->setRepeatOption(new RepeatOptionDTO());
        $dto->setStartDate(new DateTime());
        $dto->setEndDate(new DateTime());
        $dto->setLastEditDate(new DateTime());
        $dto->setCreationDate(new DateTime());
        $dto->setAllowedUserGroup(new UserGroupDTO());
        $dto->setUrlName('url-name');
        $dto->setEventDetail($eventDetail);

        return [
            [$dto]
        ];
    }
}
