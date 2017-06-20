<?php


namespace rmatil\CmsBundle\Mapper;


use rmatil\CmsBundle\Entity\Language;
use rmatil\CmsBundle\Entity\Offer;
use rmatil\CmsBundle\Exception\MapperException;
use rmatil\CmsBundle\Model\LanguageDTO;
use rmatil\CmsBundle\Model\OfferDTO;

class OfferMapper extends AbstractMapper {

    public function entityToDto($offer) {
        if (null === $offer) {
            return null;
        }

        if ( ! ($offer instanceof Offer)) {
            throw new MapperException(sprintf('Required object of type "%s" but got "%s"', Offer::class, get_class($offer)));
        }

        $offerDto = new OfferDTO();
        $offerDto->setId($offer->getId());
        $offerDto->setName($offer->getName());
        $offerDto->setAmount($offer->getAmount());
        $offerDto->setCurrency($offer->getCurrency());
        $offerDto->setUrl($offer->getUrl());


        return $offerDto;
    }

    public function dtoToEntity($offerDto) {
        if (null === $offerDto) {
            return null;
        }

        if ( ! ($offerDto instanceof OfferDTO)) {
            throw new MapperException(sprintf('Required object of type "%s" but got "%s"', OfferDTO::class, get_class($offerDto)));
        }

        $offer = new Offer();
        $offer->setId($offerDto->getId());
        $offer->setName($offerDto->getName());
        $offer->setAmount($offerDto->getAmount());
        $offer->setCurrency($offerDto->getCurrency());
        $offer->setUrl($offerDto->getUrl());

        return $offer;
    }
}
