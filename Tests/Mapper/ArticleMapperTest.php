<?php


namespace rmatil\CmsBundle\Tests\Mapper;


use DateTime;
use PHPUnit_Framework_TestCase;
use rmatil\CmsBundle\Entity\Article;
use rmatil\CmsBundle\Entity\ArticleCategory;
use rmatil\CmsBundle\Entity\Language;
use rmatil\CmsBundle\Entity\Page;
use rmatil\CmsBundle\Entity\User;
use rmatil\CmsBundle\Entity\UserGroup;
use rmatil\CmsBundle\Mapper\ArticleCategoryMapper;
use rmatil\CmsBundle\Mapper\ArticleMapper;
use rmatil\CmsBundle\Mapper\LanguageMapper;
use rmatil\CmsBundle\Mapper\UserGroupMapper;
use rmatil\CmsBundle\Mapper\UserMapper;
use rmatil\CmsBundle\Model\ArticleCategoryDTO;
use rmatil\CmsBundle\Model\ArticleDTO;
use rmatil\CmsBundle\Model\LanguageDTO;
use rmatil\CmsBundle\Model\UserDTO;
use rmatil\CmsBundle\Model\UserGroupDTO;

class ArticleMapperTest extends PHPUnit_Framework_TestCase {

    /**
     * @var ArticleMapper
     */
    private $articleMapper;

    /**
     * @var ArticleCategoryMapper
     */
    private $articleCategoryMapper;

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
        $this->articleCategoryMapper = new ArticleCategoryMapper();
        $this->languageMapper = new LanguageMapper();
        $this->userGroupMapper = new UserGroupMapper();
        $this->userMapper = new UserMapper();

        $this->articleMapper = new ArticleMapper(
            $this->articleCategoryMapper,
            $this->languageMapper,
            $this->userGroupMapper,
            $this->userMapper
        );
    }

    /**
     * @param $entity Article
     *
     * @dataProvider entityProvider
     */
    public function testEntityToDto($entity) {
        $dto = $this->articleMapper->entityToDto($entity);

        $this->assertEquals($entity->getId(), $dto->getId());
        $this->assertEquals($entity->getUrlName(), $dto->getUrlName());
        $this->assertEquals($this->articleCategoryMapper->entityToDto($entity->getCategory()), $dto->getCategory());
        $this->assertEquals($this->userMapper->entityToDto($entity->getAuthor()), $dto->getAuthor());
        $this->assertEquals($this->languageMapper->entityToDto($entity->getLanguage()), $dto->getLanguage());
        $this->assertEquals($entity->getTitle(), $dto->getTitle());
        $this->assertEquals($entity->getContent(), $dto->getContent());
        $this->assertEquals($entity->getLastEditDate(), $dto->getLastEditDate());
        $this->assertEquals($entity->getCreationDate(), $dto->getCreationDate());
        $this->assertEquals($entity->getIsPublished(), $dto->isPublished());
        $this->assertEquals($this->userGroupMapper->entityToDto($entity->getAllowedUserGroup()), $dto->getAllowedUserGroup());
    }

    /**
     * @param $dto ArticleDTO
     *
     * @dataProvider dtoProvider
     */
    public function testDtoToEntity($dto) {
        $entity = $this->articleMapper->dtoToEntity($dto);

        $this->assertEquals($dto->getId(), $entity->getId());
        $this->assertEquals($dto->getUrlName(), $entity->getUrlName());
        $this->assertEquals($dto->getCategory(), $this->articleCategoryMapper->entityToDto($entity->getCategory()));
        $this->assertEquals($dto->getAuthor(), $this->userMapper->entityToDto($entity->getAuthor()));
        $this->assertEquals($dto->getLanguage(), $this->languageMapper->entityToDto($entity->getLanguage()));
        $this->assertEquals($dto->getTitle(), $entity->getTitle());
        $this->assertEquals($dto->getContent(), $entity->getContent());
        $this->assertEquals($dto->getLastEditDate(), $entity->getLastEditDate());
        $this->assertEquals($dto->getCreationDate(), $entity->getCreationDate());
        $this->assertEquals($dto->isPublished(), $entity->getIsPublished());
        $this->assertEquals($dto->getAllowedUserGroup(), $this->userGroupMapper->entityToDto($entity->getAllowedUserGroup()));
    }

    public function entityProvider() {
        $category = new ArticleCategory();
        $category->setName('Teasers');

        $author = new User();
        $author->setFirstName('Ding');
        $author->setLastName('Dong');

        $language = new Language();
        $language->setName('English');

        $allowedUserGroup = new UserGroup();
        $allowedUserGroup->setName('Member');

        $article = new Article();
        $article->setId(1);
        $article->setUrlName('url-name');
        $article->setCategory($category);
        $article->setAuthor($author);
        $article->setLanguage($language);
        $article->setTitle('title');
        $article->setContent('content');
        $article->setLastEditDate(new DateTime());
        $article->setCreationDate(new DateTime());
        $article->setIsPublished(false);
        $article->setAllowedUserGroup($allowedUserGroup);

        return [
            [$article]
        ];
    }

    public function dtoProvider() {
        $categoryDto = new ArticleCategoryDTO();
        $categoryDto->setName('dto-category');

        $authorDto = new UserDTO();
        $authorDto->setFirstName('Do');
        $authorDto->setLastName('Tr');
        $authorDto->setRoles(['ROLE_USER']);

        $langDto = new LanguageDTO();
        $langDto->setName('English DTO');

        $allowedUserGroup = new UserGroupDTO();
        $allowedUserGroup->setName('user group dto');

        $dto = new ArticleDTO();
        $dto->setId(1);
        $dto->setUrlName('url-name');
        $dto->setCategory($categoryDto);
        $dto->setAuthor($authorDto);
        $dto->setLanguage($langDto);
        $dto->setTitle('title');
        $dto->setContent('content');
        $dto->setLastEditDate(new DateTime());
        $dto->setCreationDate(new DateTime());
        $dto->setIsPublished(false);
        $dto->setAllowedUserGroup($allowedUserGroup);

        return [
            [$dto]
        ];
    }
}
