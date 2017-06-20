<?php


namespace rmatil\CmsBundle\Tests\Mapper;


use PHPUnit_Framework_TestCase;
use rmatil\CmsBundle\Entity\File;
use rmatil\CmsBundle\Entity\Location;
use rmatil\CmsBundle\Entity\MediaTag;
use rmatil\CmsBundle\Entity\Offer;
use rmatil\CmsBundle\Mapper\FileMapper;
use rmatil\CmsBundle\Mapper\LocationMapper;
use rmatil\CmsBundle\Mapper\MediaTagMapper;
use rmatil\CmsBundle\Mapper\OfferMapper;
use rmatil\CmsBundle\Mapper\UserMapper;
use rmatil\CmsBundle\Model\FileDTO;
use rmatil\CmsBundle\Model\LocationDTO;
use rmatil\CmsBundle\Model\MediaTagDTO;
use rmatil\CmsBundle\Model\OfferDTO;

class MediaTagMapperTest extends PHPUnit_Framework_TestCase {

    /**
     * @var \rmatil\CmsBundle\Mapper\MediaTagMapper
     */
    private $mediaTagMapper;

    /**
     * @var FileMapper
     */
    private $fileMapper;

    public function setUp() {
        $this->fileMapper = new FileMapper(new UserMapper());
        $this->mediaTagMapper = new MediaTagMapper($this->fileMapper);
    }

    /**
     * @param $entity \rmatil\CmsBundle\Entity\MediaTag
     *
     * @dataProvider entityProvider
     */
    public function testEntityToDto($entity) {
        $dto = $this->mediaTagMapper->entityToDto($entity);

        $this->assertEquals($entity->getId(), $dto->getId());
        $this->assertEquals($entity->getName(), $dto->getName());
        $this->assertEquals($this->fileMapper->entitiesToDtos($entity->getFiles()->toArray()), $dto->getFiles());
    }

    /**
     * @param $dto \rmatil\CmsBundle\Model\MediaTagDTO
     *
     * @dataProvider dtoProvider
     */
    public function testDtoToEntity($dto) {
        $entity = $this->mediaTagMapper->dtoToEntity($dto);

        $this->assertEquals($dto->getId(), $entity->getId());
        $this->assertEquals($dto->getName(), $entity->getName());
        $this->assertEquals($this->fileMapper->dtosToEntities($dto->getFiles()), $entity->getFiles()->toArray());
    }

    public function entityProvider() {
       $mediaTag = new MediaTag();
       $mediaTag->setId(1);
       $mediaTag->setName('Tag');

       $file = new File();
       $file->setName('ding');
       $file->addTag($mediaTag);

       $mediaTag->addFile($file);

        return [
            [$mediaTag]
        ];
    }

    public function dtoProvider() {
        $mediaTagDto = new MediaTagDTO();
        $mediaTagDto->setId(2);
        $mediaTagDto->setName('Tag');

        $fileDto = new FileDTO();
        $fileDto->setName('file');

        $mediaTagDto->setFiles([$fileDto]);

        return [
            [$mediaTagDto]
        ];
    }
}
