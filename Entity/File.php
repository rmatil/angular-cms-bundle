<?php

namespace rmatil\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\MaxDepth;
use JMS\Serializer\Annotation\Type;

/**
 * @ORM\Entity
 * @ORM\Table(name="files")
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
     * The link to this file
     *
     * @ORM\Column(type="string")
     *
     * @Type("string")
     *
     * @var string
     */
    protected $link;

    /**
     * The local path to this file
     *
     * @ORM\Column(type="string")
     *
     * @Type("string")
     *
     * @var string
     */
    protected $localPath;

    /**
     * The link to a thumbnail of this file
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Type("string")
     *
     * @var string
     */
    protected $thumbnailLink;

    /**
     * The local path to the thumbnail of this file
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Type("string")
     *
     * @var string
     */
    protected $localThumbnailPath;

    /**
     * The files extension
     *
     * @ORM\Column(type="string")
     *
     * @Type("string")
     *
     * @var string
     */
    protected $extension;

    /**
     * The size of the event in bytes
     *
     * @ORM\Column(type="integer")
     *
     * @Type("integer")
     *
     * @var integer
     */
    protected $size;

    /**
     * The dimensions of this file, if present, as string
     *
     * @ORM\Column(type="string")
     *
     * @Type("string")
     *
     * @var string
     */
    protected $dimensions;

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
     * Gets the The link to this file.
     *
     * @return string
     */
    public function getLink() {
        return $this->link;
    }

    /**
     * Sets the The link to this file.
     *
     * @param string $link the link
     */
    public function setLink($link) {
        $this->link = $link;
    }

    /**
     * Gets the The local path to this file.
     *
     * @return string
     */
    public function getLocalPath() {
        return $this->localPath;
    }

    /**
     * Sets the The local path to this file.
     *
     * @param string $localPath the local path
     */
    public function setLocalPath($localPath) {
        $this->localPath = $localPath;
    }

    /**
     * Gets the The link to a thumbnail of this file.
     *
     * @return string
     */
    public function getThumbnailLink() {
        return $this->thumbnailLink;
    }

    /**
     * Sets the The link to a thumbnail of this file.
     *
     * @param string $thumbnailLink the thumbnail link
     */
    public function setThumbnailLink($thumbnailLink) {
        $this->thumbnailLink = $thumbnailLink;
    }

    /**
     * Gets the The local path to the thumbnail of this file.
     *
     * @return string
     */
    public function getLocalThumbnailPath() {
        return $this->localThumbnailPath;
    }

    /**
     * Sets the The local path to the thumbnail of this file.
     *
     * @param string $localThumbnailPath the local thumbnail path
     */
    public function setLocalThumbnailPath($localThumbnailPath) {
        $this->localThumbnailPath = $localThumbnailPath;
    }

    /**
     * Gets the The files extension.
     *
     * @return string
     */
    public function getExtension() {
        return $this->extension;
    }

    /**
     * Sets the The files extension.
     *
     * @param string $extension the extension
     */
    public function setExtension($extension) {
        $this->extension = $extension;
    }

    /**
     * Gets the The size of the event in bytes.
     *
     * @return integer
     */
    public function getSize() {
        return $this->size;
    }

    /**
     * Sets the The size of the event in bytes.
     *
     * @param integer $size the size
     */
    public function setSize($size) {
        $this->size = $size;
    }

    /**
     * Gets the The dimensions of this file, if present, as string.
     *
     * @return string
     */
    public function getDimensions() {
        return $this->dimensions;
    }

    /**
     * Sets the The dimensions of this file, if present, as string.
     *
     * @param string $dimensions the dimensions
     */
    public function setDimensions($dimensions) {
        $this->dimensions = $dimensions;
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
