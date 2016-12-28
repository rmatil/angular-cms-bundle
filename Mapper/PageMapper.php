<?php


namespace rmatil\CmsBundle\Mapper;


use Doctrine\Common\Collections\ArrayCollection;
use rmatil\CmsBundle\Entity\Page;
use rmatil\CmsBundle\Exception\MapperException;
use rmatil\CmsBundle\Model\PageDTO;

class PageMapper extends AbstractMapper {

    protected $pageCategoryMapper;
    protected $articleMapper;
    protected $languageMapper;
    protected $userGroupMapper;
    protected $userMapper;

    public function __construct(ArticleMapper $articleMapper, LanguageMapper $languageMapper, UserGroupMapper $userGroupMapper, UserMapper $userMapper) {
        $this->articleMapper = $articleMapper;
        $this->languageMapper = $languageMapper;
        $this->userGroupMapper = $userGroupMapper;
        $this->userMapper = $userMapper;
    }

    public function entityToDto($page) {
        if ( ! ($page instanceof Page)) {
            throw new MapperException(sprintf('Required object of type "%s" but got "%s"', Page::class, get_class($page)));
        }

        $pageDto = new PageDTO();
        $pageDto->setId($page->getId());
        $pageDto->setUrlName($page->getUrlName());
        $pageDto->setAuthor($this->userMapper->entityToDto($page->getAuthor()));
        $pageDto->setLanguage($this->languageMapper->entityToDto($page->getLanguage()));
        $pageDto->setTitle($page->getTitle());

        if (null !== $page->getParent()) {
            $pageDto->setParent($this->entityToDto($page->getParent()));
        }

        $articleDtos = new ArrayCollection();
        foreach ($page->getArticles() as $article) {
            $articleDto = $this->articleMapper->entityToDto($article);
            $articleDtos->add($articleDto);
        }
        $pageDto->setArticles($articleDtos);

        $pageDto->setIsPublished($page->getIsPublished());
        $pageDto->setLastEditDate($page->getLastEditDate());
        $pageDto->setCreationDate($page->getCreationDate());
        $pageDto->setAllowedUserGroup($this->userGroupMapper->entityToDto($page->getAllowedUserGroup()));
        $pageDto->setIsStartPage($page->getIsStartPage());

        return $pageDto;
    }

    public function dtoToEntity($pageDto) {
        if ( ! ($pageDto instanceof PageDTO)) {
            throw new MapperException(sprintf('Required object of type "%s" but got "%s"', PageDTO::class, get_class($pageDto)));
        }

        $page = new Page();
        $page->setId($pageDto->getId());
        $page->setUrlName($pageDto->getUrlName());
        $page->setAuthor($this->userMapper->dtoToEntity($pageDto->getAuthor()));
        $page->setLanguage($this->languageMapper->dtoToEntity($pageDto->getLanguage()));
        $page->setTitle($pageDto->getTitle());

        if (null !== $pageDto->getParent()) {
            $page->setParent($this->dtoToEntity($pageDto->getParent()));
        }

        $articles = new ArrayCollection();
        foreach ($pageDto->getArticles() as $articleDTO) {
            $article = $this->articleMapper->dtoToEntity($articleDTO);
            $articles->add($article);
        }
        $page->setArticles($articles);

        $page->setIsPublished($pageDto->isIsPublished());
        $page->setLastEditDate($pageDto->getLastEditDate());
        $page->setCreationDate($pageDto->getCreationDate());
        $page->setAllowedUserGroup($this->userGroupMapper->dtoToEntity($pageDto->getAllowedUserGroup()));
        $page->setIsStartPage($pageDto->isIsStartPage());

        return $page;
    }
}
