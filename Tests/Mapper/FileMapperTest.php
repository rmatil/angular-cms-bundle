<?php


namespace rmatil\CmsBundle\Tests\Mapper;


use PHPUnit_Framework_TestCase;
use rmatil\CmsBundle\Entity\File;
use rmatil\CmsBundle\Entity\User;
use rmatil\CmsBundle\Mapper\FileMapper;
use rmatil\CmsBundle\Mapper\UserMapper;
use rmatil\CmsBundle\Model\FileDTO;
use rmatil\CmsBundle\Model\UserDTO;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileMapperTest extends PHPUnit_Framework_TestCase {

    private static $FILE_NAME = __DIR__ . '/rmatil_cms_someFile.txt';

    /**
     * @var FileMapper
     */
    private $fileMapper;

    /**
     * @var UserMapper
     */
    private $userMapper;


    public function setUp() {
        $this->userMapper = new UserMapper();
        $this->fileMapper = new FileMapper(
            $this->userMapper
        );
    }

    /**
     * @param File $entity
     *
     * @dataProvider entityProvider
     */
    public function testEntityToDto($entity) {
        $dto = $this->fileMapper->entityToDto($entity);

        $this->assertEquals($entity->getId(), $dto->getId());
        $this->assertEquals($entity->getName(), $dto->getName());
        $this->assertEquals($entity->getDescription(), $dto->getDescription());
        $this->assertEquals($entity->getFile(), $dto->getFile());
        $this->assertEquals($entity->getFilePath(), $dto->getPath());
        $this->assertEquals($this->userMapper->entityToDto($entity->getAuthor()), $dto->getAuthor());
        $this->assertEquals($entity->getCreationDate(), $dto->getCreationDate());
    }

    /**
     * @param FileDTO $dto
     *
     * @dataProvider dtoProvider
     */
    public function testDtoToEntity($dto) {
        $entity = $this->fileMapper->dtoToEntity($dto);

        $this->assertEquals($dto->getId(), $entity->getId());
        $this->assertEquals($dto->getName(), $entity->getName());
        $this->assertEquals($dto->getDescription(), $entity->getDescription());
        $this->assertEquals($dto->getFile(), $entity->getFile());
        $this->assertEquals($dto->getPath(), $entity->getFilePath());
        $this->assertEquals($dto->getAuthor(), $this->userMapper->entityToDto($entity->getAuthor()));
        $this->assertEquals($dto->getCreationDate(), $entity->getCreationDate());
    }

    public function entityProvider() {
        // Note, data providers are invoked before setupBeforeClass
        // so we have to create the file here in order to avoid
        // any warnings
        if (file_exists(self::$FILE_NAME)) {
            throw new \Exception('Could not run test since test file already exists');
        }

        file_put_contents(self::$FILE_NAME, '');

        $author = new User();
        $author->setFirstName('Pepper');
        $author->setLastName('Middletoch');

        $file = new File();
        $file->setId(1);
        $file->setName('some name');
        $file->setDescription('description');
        $file->setFile(new UploadedFile(self::$FILE_NAME, 'someFile.txt'));
        $file->setFilePath(self::$FILE_NAME);
        $file->setAuthor($author);
        $file->setCreationDate(new \DateTime());

        unlink(self::$FILE_NAME);

        return [
            [$file]
        ];
    }

    public function dtoProvider() {
        // Note, data providers are invoked before setupBeforeClass
        // so we have to create the file here in order to avoid
        // any warnings
        if (file_exists(self::$FILE_NAME)) {
            throw new \Exception('Could not run test since test file already exists');
        }

        file_put_contents(self::$FILE_NAME, '');

        $author = new UserDTO();
        $author->setFirstName('Peter M.');
        $author->setLastName('Schnitzel');
        $author->setRoles(['ROLE_USER']);

        $fileDto = new FileDTO();
        $fileDto->setId(2);
        $fileDto->setName('FileName');
        $fileDto->setDescription('Description');
        $fileDto->setFile(new UploadedFile(self::$FILE_NAME, 'someFile.txt'));
        $fileDto->setPath(self::$FILE_NAME);
        $fileDto->setAuthor($author);
        $fileDto->setCreationDate(new \DateTime());

        unlink(self::$FILE_NAME);

        return [
            [$fileDto]
        ];
    }
}
