<?php


namespace rmatil\CmsBundle\Mapper;


use Doctrine\Common\Collections\ArrayCollection;
use rmatil\CmsBundle\Entity\EventDetail;
use rmatil\CmsBundle\Exception\MapperException;
use rmatil\CmsBundle\Model\EventDetailDTO;

class EventDetailMapper extends AbstractMapper {

    protected $offerMapper;

    public function __construct(OfferMapper $offerMapper) {
        $this->offerMapper = $offerMapper;
    }

    /**
     * {@inheritdoc}
     *
     * @param $eventDetail EventDetail
     *
     * @return \rmatil\CmsBundle\Model\EventDetailDTO
     */
    public function entityToDto($eventDetail) {
        if (null === $eventDetail) {
            return null;
        }

        if ( ! ($eventDetail instanceof EventDetail)) {
            throw new MapperException(sprintf('Required object of type "%s" but got "%s"', EventDetail::class, get_class($eventDetail)));
        }

        $dto = new EventDetailDTO();
        $dto->setId($eventDetail->getId());
        $dto->setColor($eventDetail->getColor());
        $dto->setOffers($this->offerMapper->entitiesToDtos($eventDetail->getOffers()->toArray()));

        return $dto;
    }

    /**
     * {@inheritdoc}
     *
     * @param $dto EventDetailDTO
     *
     * @return EventDetail
     */
    public function dtoToEntity($eventDetailDto) {
        if (null === $eventDetailDto) {
            return null;
        }

        if ( ! ($eventDetailDto instanceof EventDetailDTO)) {
            throw new MapperException(sprintf('Required object of type "%s" but got "%s"', EventDetailDTO::class, get_class($eventDetailDto)));
        }

        $eventDetail = new EventDetail();
        $eventDetail->setId($eventDetailDto->getId());
        $eventDetail->setColor($eventDetailDto->getColor());
        $eventDetail->setOffers(new ArrayCollection($this->offerMapper->dtosToEntities($eventDetailDto->getOffers())));

        return $eventDetail;
    }
}
