<?php


namespace rmatil\CmsBundle\Mapper;


use Doctrine\Common\Collections\ArrayCollection;
use rmatil\CmsBundle\Entity\MediaTag;
use rmatil\CmsBundle\Exception\MapperException;
use rmatil\CmsBundle\Model\MediaTagDTO;

class MediaTagMapper extends AbstractMapper {

    private $fileMapper;

    public function __construct(FileMapper $fileMapper) {
        $this->fileMapper = $fileMapper;
    }

    public function entityToDto($mediaTag) {
        if (null === $mediaTag) {
            return null;
        }

        if ( ! ($mediaTag instanceof MediaTag)) {
            throw new MapperException(sprintf('Required object of type "%s" but got "%s"', MediaTag::class, get_class($mediaTag)));
        }

        $mediaTagDto = new MediaTagDTO();
        $mediaTagDto->setId($mediaTag->getId());
        $mediaTagDto->setName($mediaTag->getName());
        $mediaTagDto->setFiles($this->fileMapper->entitiesToDtos($mediaTag->getFiles()->toArray()));

        return $mediaTagDto;
    }

    public function dtoToEntity($mediaTagDto) {
        if (null === $mediaTagDto) {
            return null;
        }

        if ( ! ($mediaTagDto instanceof MediaTagDTO)) {
            throw new MapperException(sprintf('Required object of type "%s" but got "%s"', MediaTagDTO::class, get_class($mediaTagDto)));
        }

        $mediaTag = new MediaTag();
        $mediaTag->setId($mediaTagDto->getId());
        $mediaTag->setName($mediaTagDto->getName());
        $mediaTag->setFiles(new ArrayCollection($this->fileMapper->dtosToEntities($mediaTagDto->getFiles())));

        return $mediaTag;
    }
}
