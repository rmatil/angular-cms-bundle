<?php


namespace rmatil\CmsBundle\Tests\Entity;


use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use rmatil\CmsBundle\Entity\Article;
use rmatil\CmsBundle\Entity\Language;
use rmatil\CmsBundle\Entity\Page;
use rmatil\CmsBundle\Entity\User;
use rmatil\CmsBundle\Entity\UserGroup;

class PageTest extends TestCase {

    /**
     * @var Page
     */
    private $page;

    public function setUp() {
        $this->page = new Page();
    }

    /**
     * @dataProvider dataProvider
     */
    public function testAccessors($id, $urlName, $author, $language, $title, $parent, $articles, $isPublished, $lastEditDate, $creationDate, $allowedUserGroup, $isStartPage) {
        $this->page->setId($id);
        $this->page->setUrlName($urlName);
        $this->page->setAuthor($author);
        $this->page->setLanguage($language);
        $this->page->setTitle($title);
        $this->page->setParent($parent);
        $this->page->setArticles($articles);
        $this->page->setIsPublished($isPublished);
        $this->page->setLastEditDate($lastEditDate);
        $this->page->setCreationDate($creationDate);
        $this->page->setAllowedUserGroup($allowedUserGroup);
        $this->page->setIsStartPage($isStartPage);

        $this->assertEquals($id, $this->page->getId());
        $this->assertEquals($urlName, $this->page->getUrlName());
        $this->assertEquals($author, $this->page->getAuthor());
        $this->assertEquals($language, $this->page->getLanguage());
        $this->assertEquals($title, $this->page->getTitle());
        $this->assertEquals($parent, $this->page->getParent());
        $this->assertEquals($articles, $this->page->getArticles());
        $this->assertEquals($isPublished, $this->page->getIsPublished());
        $this->assertEquals($lastEditDate, $this->page->getLastEditDate());
        $this->assertEquals($creationDate, $this->page->getCreationDate());
        $this->assertEquals($allowedUserGroup, $this->page->getAllowedUserGroup());
        $this->assertEquals($isStartPage, $this->page->getIsStartPage());
    }

    public function dataProvider() {
        $author = new User();
        $author->setId(1);
        $author->setFirstName('Pippa');
        $author->setLastName('Tong');

        $language = new Language();
        $language->setId(1);
        $language->setCode('en');
        $language->setName('English');

        $article1 = new Article();
        $article1->setAuthor($author);

        $articles = new ArrayCollection();
        $articles->add($article1);

        $allowedUserGroup = new UserGroup();
        $allowedUserGroup->setName('Member');

        $parentPage = new Page();
        $parentPage->setTitle('parent');

        return [
            [1, 'url-name', $author, $language, 'title', null, $articles, false, new DateTime(), new DateTime(), $allowedUserGroup, true],
            [2, 'page-2', null, null, 'title2', $parentPage, null, true, null, null, null, false]
        ];
    }
}
