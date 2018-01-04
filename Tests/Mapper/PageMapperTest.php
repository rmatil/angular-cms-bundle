<?php


namespace rmatil\CmsBundle\Tests\Mapper;


use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use rmatil\CmsBundle\Entity\Article;
use rmatil\CmsBundle\Entity\Language;
use rmatil\CmsBundle\Entity\Page;
use rmatil\CmsBundle\Entity\UserGroup;
use rmatil\CmsBundle\Mapper\ArticleCategoryMapper;
use rmatil\CmsBundle\Mapper\ArticleMapper;
use rmatil\CmsBundle\Mapper\LanguageMapper;
use rmatil\CmsBundle\Mapper\PageMapper;
use rmatil\CmsBundle\Mapper\UserGroupMapper;
use rmatil\CmsBundle\Mapper\UserMapper;

class PageMapperTest extends TestCase {

    /**
     * @var PageMapper
     */
    private $pageMapper;

    /**
     * @var ArticleMapper
     */
    private $articleMapper;

    /**
     * @var LanguageMapper
     */
    private $languageMapper;

    /**
     * @var UserGroupMapper
     */
    private $userGroupMapper;

    /**
     * @var UserMapper
     */
    private $userMapper;
    
    public function setUp() {
        $this->languageMapper = new LanguageMapper();
        $this->userGroupMapper = new UserGroupMapper();
        $this->userMapper = new UserMapper();
        
        $this->articleMapper = new ArticleMapper(
            new ArticleCategoryMapper(),
            $this->languageMapper,
            $this->userGroupMapper,
            $this->userMapper
        );
        
        $this->pageMapper = new PageMapper(
            $this->articleMapper,
            $this->languageMapper,
            $this->userGroupMapper,
            $this->userMapper
        );
    }

    /**
     * @param $entity Page
     *
     * @dataProvider entityProvider
     */
    public function testEntityToDto($entity) {
        $dto = $this->pageMapper->entityToDto($entity);

        $this->assertEquals($entity->getId(), $dto->getId());
        $this->assertEquals($entity->getUrlName(), $dto->getUrlName());
        $this->assertEquals($entity->getAuthor(), $this->userMapper->dtoToEntity($dto->getAuthor()));
        $this->assertEquals($entity->getLanguage(), $this->languageMapper->dtoToEntity($dto->getLanguage()));
        $this->assertEquals($entity->getTitle(), $dto->getTitle());
        $this->assertEquals($entity->getParent(), $this->pageMapper->dtoToEntity($dto->getParent()));
        $this->assertEquals($entity->getLastEditDate(), $dto->getLastEditDate());
        $this->assertEquals($entity->getCreationDate(), $dto->getCreationDate());
        $this->assertEquals($entity->getAllowedUserGroup(), $this->userGroupMapper->dtoToEntity($dto->getAllowedUserGroup()));
        $this->assertEquals($entity->getIsStartPage(), $dto->isIsStartPage());
    }



    public function entityProvider() {
        $lang = new Language();
        $lang->setName('English');

        $parentPage = new Page();
        $parentPage->setUrlName('parent');

        $article = new Article();
        $article->setId(1);
        $article->setTitle('title');

        $articles = new ArrayCollection();
        $articles->add($article);

        $allowedUserGroup = new UserGroup();
        $allowedUserGroup->setName('Member');


        $page = new Page();
        $page->setId(1);
        $page->setUrlName('url-name');
        $page->setLanguage($lang);
        $page->setTitle('title');
        $page->setParent($parentPage);
        $page->setArticles($articles);
        $page->setIsPublished(false);
        $page->setLastEditDate(new DateTime());
        $page->setCreationDate(new DateTime());
        $page->setAllowedUserGroup($allowedUserGroup);
        $page->setIsStartPage(false);

        return [
            [$page]
        ];
    }
}
