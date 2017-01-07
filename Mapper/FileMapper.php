<?php


namespace rmatil\CmsBundle\Mapper;


use rmatil\CmsBundle\Entity\File;
use rmatil\CmsBundle\Exception\MapperException;
use rmatil\CmsBundle\Model\FileDTO;

class FileMapper extends AbstractMapper {

    private $userMapper;

    /**
     * FileMapper constructor.
     *
     * @param $userMapper UserMapper
     */
    public function __construct(UserMapper $userMapper) {
        $this->userMapper = $userMapper;
    }


    /**
     * {@inheritdoc}
     *
     * @return FileDTO
     */
    public function entityToDto($file) {
        if (null === $file) {
            return null;
        }

        if ( ! ($file instanceof File)) {
            throw new MapperException(sprintf('Required object of type "%s" but got "%s"', File::class, get_class($file)));
        }

        $fileDto = new FileDTO();
        $fileDto->setId($file->getId());
        $fileDto->setName($file->getName());
        $fileDto->setDescription($file->getDescription());
        $fileDto->setFile($file->getFile());
        $fileDto->setPath($file->getFilePath());
        $fileDto->setAuthor($this->userMapper->entityToDto($file->getAuthor()));
        $fileDto->setCreationDate($file->getCreationDate());

        return $fileDto;
    }

    /**
     * {@inheritdoc}
     */
    public function dtoToEntity($fileDto) {
        if (null === $fileDto) {
            return null;
        }

        if ( ! ($fileDto instanceof FileDTO)) {
            throw new MapperException(sprintf('Required object of type "%s" but got "%s"', FileDTO::class, get_class($fileDto)));
        }

        $file = new File();
        $file->setId($fileDto->getId());
        $file->setName($fileDto->getName());
        $file->setDescription($fileDto->getDescription());
        $file->setFile($fileDto->getFile());
        $file->setFilePath($fileDto->getPath());
        $file->setAuthor($this->userMapper->dtoToEntity($fileDto->getAuthor()));
        $file->setCreationDate($fileDto->getCreationDate());

        return $file;
    }
}
