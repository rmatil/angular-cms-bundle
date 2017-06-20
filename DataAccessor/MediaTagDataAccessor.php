<?php


namespace rmatil\CmsBundle\DataAccessor;


use DateTime;
use DateTimeZone;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use rmatil\CmsBundle\Constants\EntityNames;
use rmatil\CmsBundle\Entity\Article;
use rmatil\CmsBundle\Entity\ArticleCategory;
use rmatil\CmsBundle\Entity\File;
use rmatil\CmsBundle\Entity\Language;
use rmatil\CmsBundle\Entity\MediaTag;
use rmatil\CmsBundle\Exception\EntityInvalidException;
use rmatil\CmsBundle\Exception\EntityNotFoundException;
use rmatil\CmsBundle\Exception\EntityNotInsertedException;
use rmatil\CmsBundle\Exception\EntityNotUpdatedException;
use rmatil\CmsBundle\Mapper\ArticleMapper;
use rmatil\CmsBundle\Mapper\MediaTagMapper;
use rmatil\CmsBundle\Model\ArticleDTO;
use rmatil\CmsBundle\Model\MediaTagDTO;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class MediaTagDataAccessor extends DataAccessor {

    protected $mediaTagMapper;

    public function __construct(EntityManagerInterface $em, MediaTagMapper $mediaTagMapper, TokenStorageInterface $tokenStorage, LoggerInterface $logger) {
        parent::__construct(MediaTag::class, $em, $tokenStorage, $logger);

        $this->mediaTagMapper = $mediaTagMapper;
    }

    public function getAll() {
        return $this->mediaTagMapper->entitiesToDtos(parent::getAll());
    }

    public function getById($id) {
        return $this->mediaTagMapper->entityToDto(parent::getById($id));
    }

    public function update($mediaTagDto) {
        if ( ! ($mediaTagDto instanceof MediaTagDTO)) {
            throw new EntityInvalidException(sprintf('Required object of type "%s" but got "%s"', MediaTagDTO::class, get_class($mediaTagDto)));
        }

        $mediaTag = $this->mediaTagMapper->dtoToEntity($mediaTagDto);

        /** @var MediaTag $dbTag */
        $dbTag = $this->em->getRepository($this->entityName)->find($mediaTag->getId());

        if (null === $dbTag) {
            throw new EntityNotFoundException(sprintf('Entity "%s" with id "%s" not found', $this->entityName, $mediaTag->getId()));
        }

        /** @var \rmatil\CmsBundle\Entity\File $file */
        foreach ($dbTag->getFiles() as $file) {
            $file->removeTag($dbTag);
            $dbTag->removeFile($file);
        }

        foreach ($mediaTag->getFiles() as $file) {
            if ($file->getId() !== null) {
                $dbFile = $this->em->getRepository(File::class)->find($file->getId());

                if (null !== $dbFile) {
                    $dbTag->addFile($dbFile);
                }
            }
        }


        try {
            $this->em->flush();

        } catch (DBALException $dbalex) {
            $this->logger->error($dbalex);

            throw new EntityNotUpdatedException(sprintf('Could not update entity "%s" with id "%s"', $this->entityName, $mediaTag->getId()));
        }

        return $this->mediaTagMapper->entityToDto($dbTag);
    }

    public function insert($mediaTagDto) {
        if ( ! ($mediaTagDto instanceof MediaTagDTO)) {
            throw new EntityInvalidException(sprintf('Required object of type "%s" but got "%s"', MediaTagDTO::class, get_class($mediaTagDto)));
        }

        $mediaTag = $this->mediaTagMapper->dtoToEntity($mediaTagDto);

        $dbFiles = new ArrayCollection();
        foreach ($mediaTagDto->getFiles() as $file) {
            $dbFile = $this->em->getRepository(File::class)->find($file->getId());

            if (null !== $dbFile) {
                $mediaTag->addFile($dbFile);

                $dbFiles->add($dbFile);
            }
        }
        $mediaTag->setFiles($dbFiles);

        $this->em->persist($mediaTag);

        try {
            $this->em->flush();

        } catch (DBALException $dbalex) {
            $this->logger->error($dbalex);

            throw new EntityNotInsertedException(sprintf('Could not insert entity "%s"', $this->entityName));
        }

        return $this->mediaTagMapper->entityToDto($mediaTag);
    }

}
