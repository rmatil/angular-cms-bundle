<?php


namespace Entity;


use DateTime;
use PHPUnit_Framework_TestCase;
use rmatil\CmsBundle\Entity\Article;
use rmatil\CmsBundle\Entity\ArticleCategory;
use rmatil\CmsBundle\Entity\Language;
use rmatil\CmsBundle\Entity\Page;
use rmatil\CmsBundle\Entity\User;

class ArticleTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Article
     */
    private static $article;

    public function setUp() {
        self::$article = new Article();
    }

    /**
     * @dataProvider dataProvider
     */
    public function testAccessors($id, $urlName, $category, $author, $language, $title, $content, $lastEditDate, $creationDate, $page) {
        self::$article->setId($id);
        self::$article->setUrlName($urlName);
        self::$article->setCategory($category);
        self::$article->setAuthor($author);
        self::$article->setLanguage($language);
        self::$article->setTitle($title);
        self::$article->setContent($content);
        self::$article->setLastEditDate($lastEditDate);
        self::$article->setCreationDate($creationDate);
        self::$article->setPage($page);

        $this->assertEquals($id, self::$article->getId());
        $this->assertEquals($urlName, self::$article->getUrlName());
        $this->assertEquals($category, self::$article->getCategory());
        $this->assertEquals($author, self::$article->getAuthor());
        $this->assertEquals($language, self::$article->getLanguage());
        $this->assertEquals($title, self::$article->getTitle());
        $this->assertEquals($content, self::$article->getContent());
        $this->assertEquals($lastEditDate, self::$article->getLastEditDate());
        $this->assertEquals($creationDate, self::$article->getCreationDate());
        $this->assertEquals($page, self::$article->getPage());
    }

    public function dataProvider() {
        $category = new ArticleCategory();
        $author = new User();
        $language = new Language();
        $page = new Page();

        $yesterday = new DateTime('yesterday');
        $now = new DateTime('now');

        return [
            [1, 'url-name', null, null, null, 'title', 'content', null, null, null],
            [2, 'url-name-2', $category, $author, $language, 'title', 'content', $now, $yesterday, $page]
        ];
    }
}
