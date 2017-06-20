<?php


namespace rmatil\CmsBundle\Model;

use DateTime;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\MaxDepth;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\HttpFoundation\File\File;

class FileDTO {

    /**
     * @Type("integer")
     *
     * @var integer
     */
    private $id;

    /**
     * @Type("string")
     *
     * @var string
     */
    private $name;

    /**
     * @Type("string")
     *
     * @var string
     */
    private $description;

    /**
     * @Serializer\Exclude()
     *
     * @var File
     */
    private $file;

    /**
     * @Type("string")
     *
     * @var string
     */
    private $path;

    /**
     * @Type("rmatil\CmsBundle\Model\UserDTO")
     * @MaxDepth(1)
     *
     * @var UserDTO
     */
    private $author;

    /**
     * @Type("DateTime<'Y-m-d\TH:i:sP', 'UTC'>")
     *
     * @var \DateTime
     */
    private $creationDate;

    /**
     * @Serializer\Exclude()
     *
     * @var \rmatil\CmsBundle\Model\MediaTagDTO[]
     */
    private $tags;

    public function __construct() {
        $this->tags = [];
    }

    /**
     * @return int
     */
    public function getId(): ?int {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id = null) {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): ?string {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name = null) {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description = null) {
        $this->description = $description;
    }

    /**
     * @return File
     */
    public function getFile(): ?File {
        return $this->file;
    }

    /**
     * @param File $file
     */
    public function setFile(File $file = null) {
        $this->file = $file;
    }

    /**
     * @return string
     */
    public function getPath(): ?string {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path = null) {
        $this->path = $path;
    }

    /**
     * @return UserDTO
     */
    public function getAuthor(): ?UserDTO {
        return $this->author;
    }

    /**
     * @param UserDTO $author
     */
    public function setAuthor(UserDTO $author = null) {
        $this->author = $author;
    }

    /**
     * @return \DateTime
     */
    public function getCreationDate(): ?DateTime {
        return $this->creationDate;
    }

    /**
     * @param \DateTime $creationDate
     */
    public function setCreationDate(DateTime $creationDate = null) {
        $this->creationDate = $creationDate;
    }

    /**
     * @return \rmatil\CmsBundle\Model\MediaTagDTO[]
     */
    public function getTags(): ?array {
        return $this->tags;
    }

    /**
     * @param \rmatil\CmsBundle\Model\MediaTagDTO[] $tags
     */
    public function setTags(array $tags = null) {
        $this->tags = $tags;
    }


}
