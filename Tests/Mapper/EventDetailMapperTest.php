<?php


namespace rmatil\CmsBundle\Tests\Mapper;


use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use rmatil\CmsBundle\Entity\Event;
use rmatil\CmsBundle\Entity\EventDetail;
use rmatil\CmsBundle\Entity\Offer;
use rmatil\CmsBundle\Mapper\EventDetailMapper;
use rmatil\CmsBundle\Mapper\OfferMapper;
use rmatil\CmsBundle\Model\EventDetailDTO;
use rmatil\CmsBundle\Model\OfferDTO;

class EventDetailMapperTest extends TestCase {

    /**
     * @var OfferMapper
     */
    private $offerMapper;

    /**
     * @var EventDetailMapper
     */
    private $eventDetailMapper;

    public function setUp() {
        $this->offerMapper = new OfferMapper();
        $this->eventDetailMapper = new EventDetailMapper($this->offerMapper);
    }

    /**
     * @param $entity \rmatil\CmsBundle\Entity\EventDetail
     *
     * @dataProvider entityProvider
     */
    public function testEntityToDto($entity) {
        $dto = $this->eventDetailMapper->entityToDto($entity);

        $this->assertEquals($entity->getId(), $dto->getId());
        $this->assertEquals($entity->getColor(), $dto->getColor());
        $this->assertEquals($this->offerMapper->entitiesToDtos($entity->getOffers()->toArray()), $dto->getOffers());
    }

    /**
     * @param $dto \rmatil\CmsBundle\Model\EventDetailDTO
     *
     * @dataProvider dtoProvider
     */
    public function testDtoToEntity($dto) {
        $entity = $this->eventDetailMapper->dtoToEntity($dto);

        $this->assertEquals($dto->getId(), $entity->getId());
        $this->assertEquals($dto->getColor(), $entity->getColor());
        $this->assertEquals($this->offerMapper->dtosToEntities($dto->getOffers()), $entity->getOffers()->toArray());
    }

    public function entityProvider() {
        $eventDetail = new EventDetail();
        $eventDetail->setId(1);
        $eventDetail->setColor("#123");
        $eventDetail->setEvent(new Event());
        $eventDetail->setOffers(new ArrayCollection([new Offer()]));

        return [
            [$eventDetail]
        ];
    }

    public function dtoProvider() {
        $eventDetailDto = new EventDetailDTO();
        $eventDetailDto->setId(2);
        $eventDetailDto->setColor("#123");
        $eventDetailDto->setOffers([new OfferDTO()]);


        return [
            [$eventDetailDto]
        ];
    }
}
