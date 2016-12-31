<?php

namespace rmatil\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity
 * @ORM\Table(name="events")
 *
 * @Vich\Uploadable
 **/
class Event {

    /**
     * Id of the Event
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     *
     * @var integer
     */
    protected $id;

    /**
     * The author of this article
     *
     * @ORM\ManyToOne(targetEntity="User")
     *
     * @var \rmatil\CmsBundle\Entity\User
     */
    protected $author;

    /**
     * The author of this article
     *
     * @ORM\ManyToOne(targetEntity="Location")
     *
     * @var \rmatil\CmsBundle\Entity\Location
     */
    protected $location;

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
     * The name of the event
     *
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $name;

    /**
     * The content of the event
     *
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string
     */
    protected $content;

    /**
     * Some additional info of the event
     *
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string
     */
    protected $additionalInfo;

    /**
     * Repeat options for event
     *
     * @ORM\ManyToOne(targetEntity="RepeatOption")
     *
     * @var \rmatil\CmsBundle\Entity\RepeatOption
     */
    protected $repeatOption;

    /**
     * DateTime object of the start date
     *
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    protected $startDate;

    /**
     * DateTime object of the end date
     *
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    protected $endDate;

    /**
     * DateTime object of the last edit date
     *
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    protected $lastEditDate;

    /**
     * DateTime object of the creation date
     *
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    protected $creationDate;

    /**
     * The user group which is allowed to access this event.
     *
     * @ORM\ManyToOne(targetEntity="UserGroup")
     *
     * @var \rmatil\CmsBundle\Entity\UserGroup
     */
    protected $allowedUserGroup;

    /**
     * Url name for the event
     *
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $urlName;


    /**
     * Gets the The author of this article.
     *
     * @return \rmatil\CmsBundle\Entity\User
     */
    public function getAuthor() {
        return $this->author;
    }

    /**
     * Sets the The author of this article.
     *
     * @param \rmatil\CmsBundle\Entity\User $author the author
     */
    public function setAuthor(User $author = null) {
        $this->author = $author;
    }

    /**
     * Gets the The author of this article.
     *
     * @return \rmatil\CmsBundle\Entity\Location
     */
    public function getLocation() {
        return $this->location;
    }

    /**
     * Sets the The author of this article.
     *
     * @param \rmatil\CmsBundle\Entity\Location $location the location
     */
    public function setLocation(Location $location = null) {
        $this->location = $location;
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
     * Gets the The name of the event.
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Sets the The name of the event.
     *
     * @param string $name the name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Gets the Repeat options for event.
     *
     * @return \rmatil\CmsBundle\Entity\RepeatOption
     */
    public function getRepeatOption() {
        return $this->repeatOption;
    }

    /**
     * Sets the Repeat options for event.
     *
     * @param \rmatil\CmsBundle\Entity\RepeatOption $repeatOption the repeat option
     */
    public function setRepeatOption(RepeatOption $repeatOption = null) {
        $this->repeatOption = $repeatOption;
    }

    /**
     * Gets the DateTime object of the start date.
     *
     * @return \DateTime
     */
    public function getStartDate() {
        return $this->startDate;
    }

    /**
     * Sets the DateTime object of the start date.
     *
     * @param \DateTime $startDate the start date
     */
    public function setStartDate(\DateTime $startDate = null) {
        $this->startDate = $startDate;
    }

    /**
     * Gets the DateTime object of the end date.
     *
     * @return \DateTime
     */
    public function getEndDate() {
        return $this->endDate;
    }

    /**
     * Sets the DateTime object of the end date.
     *
     * @param \DateTime $endDate the end date
     */
    public function setEndDate(\DateTime $endDate = null) {
        $this->endDate = $endDate;
    }

    /**
     * Gets the The description of the event.
     *
     * @return string
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * Sets the The description of the event.
     *
     * @param string $content the description
     */
    public function setContent($content) {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getAdditionalInfo(): string {
        return $this->additionalInfo;
    }

    /**
     * @param string $additionalInfo
     */
    public function setAdditionalInfo(string $additionalInfo) {
        $this->additionalInfo = $additionalInfo;
    }

    /**
     * Gets the DateTime object of the last edit date.
     *
     * @return \DateTime
     */
    public function getLastEditDate() {
        return $this->lastEditDate;
    }

    /**
     * Sets the DateTime object of the last edit date.
     *
     * @param \DateTime $lastEditDate the last edit date
     */
    public function setLastEditDate(\DateTime $lastEditDate = null) {
        $this->lastEditDate = $lastEditDate;
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

    /**
     * Gets the Id of the Event.
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Sets the Id of the Event.
     *
     * @param integer $id the id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * Get the user group which are allowed to access this event
     *
     * @return UserGroup
     */
    public function getAllowedUserGroup() {
        return $this->allowedUserGroup;
    }

    /**
     * Set the user group which is allowed to access this event.
     *
     * @param UserGroup $allowedUserGroup The user group which may access this event
     */
    public function setAllowedUserGroup($allowedUserGroup) {
        $this->allowedUserGroup = $allowedUserGroup;
    }

    /**
     * @return string
     */
    public function getUrlName() {
        return $this->urlName;
    }

    /**
     * @param string $urlName
     */
    public function setUrlName($urlName) {
        $this->urlName = $urlName;
    }
}
