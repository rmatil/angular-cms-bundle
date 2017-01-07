<?php

namespace rmatil\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\MaxDepth;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity
 * @ORM\Table(name="files")
 *
 * @Vich\Uploadable
 **/
class File {

    /**
     * Id of the File
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     *
     * @Type("integer")
     *
     * @var integer
     */
    protected $id;

    /**
     * The name of the File
     *
     * @ORM\Column(type="string")
     *
     * @Type("string")
     *
     * @var string
     */
    protected $name;

    /**
     * The description of the File
     *
     * @ORM\Column(type="string")
     *
     * @Type("string")
     *
     * @var string
     */
    protected $description;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * Use this field in the form.
     *
     * @Vich\UploadableField(mapping="event_image", fileNameProperty="file")
     *
     * @var File
     */
    private $filePath;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $file;

    /**
     * Author of this file
     *
     * @ORM\ManyToOne(targetEntity="User")
     *
     * @Type("rmatil\CmsBundle\Entity\User")
     * @MaxDepth(1)
     *
     * @var \rmatil\CmsBundle\Entity\User
     */
    protected $author;

    /**
     * DateTime object of the creation date
     *
     * @ORM\Column(type="datetime")
     *
     * @Type("DateTime<'Y-m-d\TH:i:sP', 'UTC'>")
     *
     * @var \DateTime
     */
    protected $creationDate;

    /**
     * Gets the The id of the File.
     *
     * @return string
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Sets the The id of the File.
     *
     * @param $id integer
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * Gets the The name of the File.
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Sets the The name of the File.
     *
     * @param string $name the name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Gets the The description of the File.
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Sets the The description of the File.
     *
     * @param string $description the description
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|UploadedFile $image
     */
    public function setFilePath(File $image = null) {
        $this->filePath = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->lastEditDate = new \DateTime();
        }
    }

    /**
     * @return File
     */
    public function getFilePath() {
        return $this->filePath;
    }

    /**
     * @return string
     */
    public function getFile() {
        return $this->file;
    }

    /**
     * @param string $file
     */
    public function setFile($file) {
        $this->file = $file;
    }

    /**
     * Gets the Author of this file.
     *
     * @return \rmatil\CmsBundle\Entity\User
     */
    public function getAuthor() {
        return $this->author;
    }

    /**
     * Sets the Author of this file.
     *
     * @param \rmatil\CmsBundle\Entity\User $author the author
     */
    public function setAuthor(User $author = null) {
        $this->author = $author;
    }

    /**
     * Gets the DateTime object of the creation date.
     *
     * @return \DateTime
     */
    public function getCreationDate() {
        return $this->creationDate;
    }

    /**
     * Sets the DateTime object of the creation date.
     *
     * @param \DateTime $creationDate the creation date
     */
    public function setCreationDate(\DateTime $creationDate = null) {
        $this->creationDate = $creationDate;
    }
}
