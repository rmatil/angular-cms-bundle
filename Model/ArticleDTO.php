<?php


namespace rmatil\CmsBundle\Model;


use DateTime;
use JMS\Serializer\Annotation\MaxDepth;
use JMS\Serializer\Annotation\Type;

class ArticleDTO {

    /**
     * Id of the article
     *
     * @Type("integer")
     *
     * @var integer
     */
    protected $id;

    /**
     * Url name for the article
     *
     * @Type("string")
     *
     * @var string
     */
    protected $urlName;

    /**
     * The category to which the article belongs
     *
     * @Type("rmatil\CmsBundle\Model\ArticleCategoryDTO")
     * @MaxDepth(2)
     *
     * @var ArticleCategoryDTO
     */
    protected $category;

    /**
     * The author of this article
     *
     * @Type("rmatil\CmsBundle\Model\UserDTO")
     * @MaxDepth(1)
     *
     * @var UserDTO
     */
    protected $author;

    /**
     * The language of this article
     *
     * @Type("rmatil\CmsBundle\Model\LanguageDTO")
     * @MaxDepth(2)
     *
     * @var LanguageDTO
     */
    protected $language;

    /**
     * Title of the article
     *
     * @Type("string")
     *
     * @var string
     */
    protected $title;

    /**
     * Body of the article
     *
     * @Type("string")
     *
     * @var string
     */
    protected $content;

    /**
     * DateTime object of the last edit date
     * May be null
     *
     * @Type("DateTime<'Y-m-d\TH:i:sP', 'UTC'>")
     *
     * @var DateTime
     */
    protected $lastEditDate;

    /**
     * DateTime object of the creation date
     * May be null
     *
     * @Type("DateTime<'Y-m-d\TH:i:sP', 'UTC'>")
     *
     * @var DateTime
     */
    protected $creationDate;

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
    public function getUrlName(): ?string {
        return $this->urlName;
    }

    /**
     * @param string $urlName
     */
    public function setUrlName(string $urlName = null) {
        $this->urlName = $urlName;
    }

    /**
     * @return ArticleCategoryDTO
     */
    public function getCategory(): ?ArticleCategoryDTO {
        return $this->category;
    }

    /**
     * @param ArticleCategoryDTO $category
     */
    public function setCategory(ArticleCategoryDTO $category = null) {
        $this->category = $category;
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
     * @return LanguageDTO
     */
    public function getLanguage(): ?LanguageDTO {
        return $this->language;
    }

    /**
     * @param LanguageDTO $language
     */
    public function setLanguage(LanguageDTO $language = null) {
        $this->language = $language;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title = null) {
        $this->title = $title;
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
     * @return DateTime
     */
    public function getLastEditDate(): ?DateTime {
        return $this->lastEditDate;
    }

    /**
     * @param DateTime $lastEditDate
     */
    public function setLastEditDate(DateTime $lastEditDate = null) {
        $this->lastEditDate = $lastEditDate;
    }

    /**
     * @return DateTime
     */
    public function getCreationDate(): ?DateTime {
        return $this->creationDate;
    }

    /**
     * @param DateTime $creationDate
     */
    public function setCreationDate(DateTime $creationDate = null) {
        $this->creationDate = $creationDate;
    }
}
