<?php


namespace rmatil\CmsBundle\Tests\Mapper;


use PHPUnit_Framework_TestCase;
use rmatil\CmsBundle\Entity\Location;
use rmatil\CmsBundle\Entity\Offer;
use rmatil\CmsBundle\Mapper\LocationMapper;
use rmatil\CmsBundle\Mapper\OfferMapper;
use rmatil\CmsBundle\Model\LocationDTO;
use rmatil\CmsBundle\Model\OfferDTO;

class OfferMapperTest extends PHPUnit_Framework_TestCase {

    /**
     * @var OfferMapper
     */
    private $offerMapper;

    public function setUp() {
        $this->offerMapper = new OfferMapper();
    }

    /**
     * @param $entity Offer
     *
     * @dataProvider entityProvider
     */
    public function testEntityToDto($entity) {
        $dto = $this->offerMapper->entityToDto($entity);

        $this->assertEquals($entity->getId(), $dto->getId());
        $this->assertEquals($entity->getName(), $dto->getName());
        $this->assertEquals($entity->getAmount(), $dto->getAmount());
        $this->assertEquals($entity->getCurrency(), $dto->getCurrency());
        $this->assertEquals($entity->getUrl(), $dto->getUrl());
    }

    /**
     * @param $dto \rmatil\CmsBundle\Model\OfferDTO
     *
     * @dataProvider dtoProvider
     */
    public function testDtoToEntity($dto) {
        $entity = $this->offerMapper->dtoToEntity($dto);

        $this->assertEquals($dto->getId(), $entity->getId());
        $this->assertEquals($dto->getName(), $entity->getName());
        $this->assertEquals($dto->getAmount(), $entity->getAmount());
        $this->assertEquals($dto->getCurrency(), $entity->getCurrency());
        $this->assertEquals($dto->getUrl(), $entity->getUrl());
    }

    public function entityProvider() {
       $offer = new Offer();
       $offer->setId(1);
       $offer->setName('Some Name');
       $offer->setAmount(1000);
       $offer->setCurrency('CHF');
       $offer->setUrl('url');

        return [
            [$offer]
        ];
    }

    public function dtoProvider() {
        $offerDto = new OfferDTO();
        $offerDto->setId(2);
        $offerDto->setName('Category A');
        $offerDto->setAmount(1000);
        $offerDto->setCurrency('CHF');
        $offerDto->setUrl('url');


        return [
            [$offerDto]
        ];
    }
}
