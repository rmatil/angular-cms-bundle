<?php


namespace rmatil\CmsBundle\DataAccessor;


use DateTime;
use DateTimeZone;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use rmatil\CmsBundle\Constants\EntityNames;
use rmatil\CmsBundle\Exception\EntityInvalidException;
use rmatil\CmsBundle\Exception\EntityNotInsertedException;
use rmatil\CmsBundle\Mapper\FileMapper;
use rmatil\CmsBundle\Model\FileDTO;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class FileDataAccessor extends DataAccessor {

    /**
     * @var FileMapper
     */
    protected $fileMapper;

    /**
     * @var UploaderHelper
     */
    protected $uploaderHelper;

    public function __construct(EntityManagerInterface $em, FileMapper $fileMapper, UploaderHelper $uploaderHelper, TokenStorageInterface $tokenStorage, LoggerInterface $logger) {
        parent::__construct(EntityNames::FILE, $em, $tokenStorage, $logger);

        $this->fileMapper = $fileMapper;
        $this->uploaderHelper = $uploaderHelper;
    }

    public function getAll() {
        $files = parent::getAll();

        /** @var \rmatil\CmsBundle\Entity\File $file */
        foreach ($files as $file) {
            // resolve absolute web paths
            $file->setFilePath($this->uploaderHelper->asset($file, 'file'));
        }

        return $this->fileMapper->entitiesToDtos($files);
    }

    public function getById($id) {
        $file = parent::getById($id);

        // update path to contain web asset
        $file->setFilePath($this->uploaderHelper->asset($file, 'file'));

        return $this->fileMapper->entityToDto($file);
    }

    public function insert($fileDto) {
        if ( ! ($fileDto instanceof FileDTO)) {
            throw new EntityInvalidException('Required object of type "%s" but got "%s"', FileDTO::class, get_class($fileDto));
        }

        $file = $this->fileMapper->dtoToEntity($fileDto);

        $user = $this->tokenStorage->getToken()->getUser();
        $file->setAuthor(
            $this->em->getRepository(EntityNames::USER)->find($user->getId())
        );

        $now = new DateTime('now', new DateTimeZone('UTC'));
        $file->setCreationDate($now);

        $this->em->persist($file);

        try {
            $this->em->flush();
        } catch (DBALException $dbalex) {
            $this->logger->error($dbalex);

            throw new EntityNotInsertedException(sprintf('Could not insert entity "%s"', $this->entityName));
        }

        // update path to contain web asset
        $file->setFilePath($this->uploaderHelper->asset($file, 'file'));

        return $this->fileMapper->entityToDto($file);
    }
}
