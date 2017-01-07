<?php


namespace rmatil\CmsBundle\Model;


use DateTime;
use JMS\Serializer\Annotation\MaxDepth;
use JMS\Serializer\Annotation\Type;

class EventDTO {

    /**
     * Id of the Event
     *
     * @Type("integer")
     *
     * @var integer
     */
    protected $id;

    /**
     * The author of this article
     *
     * @Type("rmatil\CmsBundle\Model\UserDTO")
     * @MaxDepth(1)
     *
     * @var \rmatil\CmsBundle\Model\UserDTO
     */
    protected $author;

    /**
     * The author of this article
     *
     * @Type("rmatil\CmsBundle\Model\LocationDTO")
     * @MaxDepth(2)
     *
     * @var \rmatil\CmsBundle\Model\LocationDTO
     */
    protected $location;

    /**
     * A file attached to this event
     *
     * @Type("rmatil\CmsBundle\Model\FileDTO")
     * @MaxDepth(2)
     *
     * @var \rmatil\CmsBundle\Model\FileDTO
     */
    protected $file;

    /**
     * The name of the event
     *
     * @ORM\Column(type="string")
     *
     * @Type("string")
     *
     * @var string
     */
    protected $name;

    /**
     * The content of the event
     *
     * @Type("string")
     *
     * @var string
     */
    protected $content;

    /**
     * @Type("string")
     *
     * @var string
     */
    protected $additionalInfo;

    /**
     * @Type("rmatil\CmsBundle\Model\RepeatOptionDTO")
     *
     * @var RepeatOptionDTO
     */
    protected $repeatOption;

    /**
     * DateTime object of the start date
     *
     * @Type("DateTime<'Y-m-d\TH:i:sP', 'UTC'>")
     *
     * @var \DateTime
     */
    protected $startDate;

    /**
     * DateTime object of the end date
     *
     * @Type("DateTime<'Y-m-d\TH:i:sP', 'UTC'>")
     *
     * @var \DateTime
     */
    protected $endDate;

    /**
     * DateTime object of the last edit date
     *
     * @ORM\Column(type="datetime")
     *
     * @Type("DateTime<'Y-m-d\TH:i:sP', 'UTC'>")
     *
     * @var \DateTime
     */
    protected $lastEditDate;

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
     * The user group which is allowed to access this event.
     *
     * @Type("rmatil\CmsBundle\Model\UserGroupDTO")
     * @MaxDepth(1)
     *
     * @var UserGroupDTO
     */
    protected $allowedUserGroup;

    /**
     * Url name for the event
     *
     * @ORM\Column(type="string")
     *
     * @Type("string")
     *
     * @var string
     */
    protected $urlName;

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
     * @return \rmatil\CmsBundle\Model\UserDTO
     */
    public function getAuthor(): ?UserDTO {
        return $this->author;
    }

    /**
     * @param \rmatil\CmsBundle\Model\UserDTO $author
     */
    public function setAuthor(UserDTO $author = null) {
        $this->author = $author;
    }

    /**
     * @return \rmatil\CmsBundle\Model\LocationDTO
     */
    public function getLocation(): ?LocationDTO {
        return $this->location;
    }

    /**
     * @param \rmatil\CmsBundle\Model\LocationDTO $location
     */
    public function setLocation(LocationDTO $location = null) {
        $this->location = $location;
    }

    /**
     * @return \rmatil\CmsBundle\Model\FileDTO
     */
    public function getFile(): ?FileDTO {
        return $this->file;
    }

    /**
     * @param \rmatil\CmsBundle\Model\FileDTO $file
     */
    public function setFile(FileDTO $file = null) {
        $this->file = $file;
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
     * @return \DateTime
     */
    public function getStartDate(): ?DateTime {
        return $this->startDate;
    }

    /**
     * @param \DateTime $startDate
     */
    public function setStartDate(DateTime $startDate = null) {
        $this->startDate = $startDate;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate(): ?DateTime {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     */
    public function setEndDate(DateTime $endDate = null) {
        $this->endDate = $endDate;
    }

    /**
     * @return string
     */
    public function getContent(): ?string {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content = null) {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getAdditionalInfo(): ?string {
        return $this->additionalInfo;
    }

    /**
     * @param string $additionalInfo
     */
    public function setAdditionalInfo(string $additionalInfo = null) {
        $this->additionalInfo = $additionalInfo;
    }

    /**
     * @return RepeatOptionDTO
     */
    public function getRepeatOption(): ?RepeatOptionDTO {
        return $this->repeatOption;
    }

    /**
     * @param RepeatOptionDTO $repeatOption
     */
    public function setRepeatOption(RepeatOptionDTO $repeatOption = null) {
        $this->repeatOption = $repeatOption;
    }

    /**
     * @return \DateTime
     */
    public function getLastEditDate(): ?DateTime {
        return $this->lastEditDate;
    }

    /**
     * @param \DateTime $lastEditDate
     */
    public function setLastEditDate(DateTime $lastEditDate = null) {
        $this->lastEditDate = $lastEditDate;
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
     * @return UserGroupDTO
     */
    public function getAllowedUserGroup(): ?UserGroupDTO {
        return $this->allowedUserGroup;
    }

    /**
     * @param UserGroupDTO $allowedUserGroup
     */
    public function setAllowedUserGroup(UserGroupDTO $allowedUserGroup = null) {
        $this->allowedUserGroup = $allowedUserGroup;
    }

    /**
     * @return string
     */
    public function getUrlName(): ?string {
        return $this->urlName;
    }

    /**
     * @param string $urlName
     */
    public function setUrlName(string $urlName = null) {
        $this->urlName = $urlName;
    }
}
