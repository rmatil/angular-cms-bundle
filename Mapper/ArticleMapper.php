<?php


namespace rmatil\CmsBundle\Mapper;


use rmatil\CmsBundle\Constants\EntityNames;
use rmatil\CmsBundle\Entity\Article;
use rmatil\CmsBundle\Exception\MapperException;
use rmatil\CmsBundle\Model\ArticleDTO;

class ArticleMapper extends AbstractMapper {

    protected $articleCategoryMapper;
    protected $languageMapper;
    protected $userGroupMapper;
    protected $userMapper;

    public function __construct(ArticleCategoryMapper $articleCategoryMapper, LanguageMapper $languageMapper, UserGroupMapper $userGroupMapper, UserMapper $userMapper) {
        $this->articleCategoryMapper = $articleCategoryMapper;
        $this->languageMapper = $languageMapper;
        $this->userGroupMapper = $userGroupMapper;
        $this->userMapper = $userMapper;
    }

    public function entityToDto($article) {
        if (null === $article) {
            return null;
        }

        if ( ! ($article instanceof Article)) {
            throw new MapperException(sprintf('Required object of type "%s" but got "%s"', EntityNames::ARTICLE, get_class($article)));
        }

        $articleDto = new ArticleDTO();
        $articleDto->setId($article->getId());
        $articleDto->setUrlName($article->getUrlName());
        $articleDto->setCategory($this->articleCategoryMapper->entityToDto($article->getCategory()));
        $articleDto->setAuthor($this->userMapper->entityToDto($article->getAuthor()));
        $articleDto->setLanguage($this->languageMapper->entityToDto($article->getLanguage()));
        $articleDto->setTitle($article->getTitle());
        $articleDto->setContent($article->getContent());
        $articleDto->setLastEditDate($article->getLastEditDate());
        $articleDto->setCreationDate($article->getCreationDate());
        $articleDto->setIsPublished($article->getIsPublished());
        $articleDto->setAllowedUserGroup($this->userGroupMapper->entityToDto($article->getAllowedUserGroup()));

        return $articleDto;
    }

    public function dtoToEntity($articleDto) {
        if (null === $articleDto) {
            return null;
        }

        if ( ! ($articleDto instanceof ArticleDTO)) {
            throw new MapperException(sprintf('Required object of type "%s" but got "%s"', ArticleDTO::class, get_class($articleDto)));
        }

        $article = new Article();
        $article->setId($articleDto->getId());
        $article->setUrlName($articleDto->getUrlName());
        $article->setCategory($this->articleCategoryMapper->dtoToEntity($articleDto->getCategory()));
        $article->setAuthor($this->userMapper->dtoToEntity($articleDto->getAuthor()));
        $article->setLanguage($this->languageMapper->dtoToEntity($articleDto->getLanguage()));
        $article->setTitle($articleDto->getTitle());
        $article->setContent($articleDto->getContent());
        $article->setLastEditDate($articleDto->getLastEditDate());
        $article->setCreationDate($articleDto->getCreationDate());
        $article->setIsPublished($articleDto->isPublished());
        $article->setAllowedUserGroup($this->userGroupMapper->dtoToEntity($articleDto->getAllowedUserGroup()));


        return $article;
    }
}
