<?php


namespace rmatil\CmsBundle\Tests\Entity;


use PHPUnit\Framework\TestCase;
use rmatil\CmsBundle\Entity\File;
use rmatil\CmsBundle\Entity\User;
use Symfony\Component\HttpFoundation\File\File as SymfonyFile;

class FileTest extends TestCase {

    private static $FILE_NAME = __DIR__ . '/rmatil_cms_someFile.txt';

    /**
     * @var File
     */
    private $file;

    public function setUp() {
        $this->file = new File();
    }

    /**
     * @dataProvider dataProvider
     */
    public function testAccessors($id, $name, $description, $filePath, $file, $author, $creationDate) {
        $this->file->setId($id);
        $this->file->setName($name);
        $this->file->setDescription($description);
        $this->file->setFile($filePath);
        $this->file->setFilePath($file);
        $this->file->setAuthor($author);
        $this->file->setCreationDate($creationDate);

        $this->assertEquals($id, $this->file->getId());
        $this->assertEquals($name, $this->file->getName());
        $this->assertEquals($description, $this->file->getDescription());
        $this->assertEquals($file, $this->file->getFilePath());
        $this->assertEquals($filePath, $this->file->getFile());
        $this->assertEquals($author, $this->file->getAuthor());
        $this->assertEquals($creationDate, $this->file->getCreationDate());
    }

    public function dataProvider() {
        // Note, data providers are invoked before setupBeforeClass
        // so we have to create the file here in order to avoid
        // any warnings
        if (file_exists(self::$FILE_NAME)) {
            throw new \Exception('Could not run test since test file already exists');
        }

        file_put_contents(self::$FILE_NAME, '');

        $author = new User();
        $author->setFirstName('Max');
        $author->setLastName('Marley');

        $file = new SymfonyFile(self::$FILE_NAME, 'origName');

        unlink(self::$FILE_NAME);

        return [
            [1, 'wallpaper.jpg', 'A wallpaper', $file, 'wallpaper.jpg', $author, new \DateTime()]
        ];
    }
}
