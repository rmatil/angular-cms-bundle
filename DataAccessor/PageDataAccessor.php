<?php


namespace rmatil\CmsBundle\DataAccessor;


use DateTime;
use DateTimeZone;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use rmatil\CmsBundle\Constants\EntityNames;
use rmatil\CmsBundle\Entity\Language;
use rmatil\CmsBundle\Exception\EntityInvalidException;
use rmatil\CmsBundle\Exception\EntityNotDeletedException;
use rmatil\CmsBundle\Exception\EntityNotFoundException;
use rmatil\CmsBundle\Exception\EntityNotInsertedException;
use rmatil\CmsBundle\Exception\EntityNotUpdatedException;
use rmatil\CmsBundle\Mapper\PageMapper;
use rmatil\CmsBundle\Model\PageDTO;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class PageDataAccessor extends DataAccessor {

    /**
     * @var PageMapper
     */
    protected $pageMapper;

    public function __construct(EntityManagerInterface $em, PageMapper $pageMapper, TokenStorageInterface $tokenStorage, LoggerInterface $logger) {
        parent::__construct(EntityNames::PAGE, $em, $tokenStorage, $logger);

        $this->pageMapper = $pageMapper;
    }

    public function getAll() {
        return $this->pageMapper->entitiesToDtos(parent::getAll());
    }

    public function getById($id) {
        return $this->pageMapper->entityToDto(parent::getById($id));
    }

    public function update($pageDto) {
        if ( ! ($pageDto instanceof PageDTO)) {
            throw new EntityInvalidException(sprintf('Required object of type "%s" but got "%s"', PageDTO::class, get_class($pageDto)));
        }

        $page = $this->pageMapper->dtoToEntity($pageDto);

        /** @var \rmatil\CmsBundle\Entity\Page $dbPage */
        $dbPage = $this->em->getRepository(EntityNames::PAGE)->find($page->getId());

        if (null === $dbPage) {
            throw new EntityNotFoundException(sprintf('Entity "%s" with id "%s" not found', $this->entityName, $page->getId()));
        }

        if ($page->getLanguage() instanceof Language) {
            $page->setLanguage(
                $this->em->getRepository(EntityNames::LANGUAGE)->find($page->getLanguage()->getId())
            );
        }

        // author is current logged in user
        $page->setAuthor(
            $this->em->getRepository(EntityNames::USER)->findOneBy(
                ['username' => $this->tokenStorage->getToken()->getUsername()]
            )
        );

        // remove all articles, then add only these who are checked
        foreach ($dbPage->getArticles()->toArray() as $article) {
            $dbArticle = $this->em->getRepository(EntityNames::ARTICLE)->find($article->getId());
            $dbArticle->setPage(null);
        }
        $dbPage->setArticles(null);

        $dbArticles = new ArrayCollection();
        if (null !== $page->getArticles()) {
            foreach ($page->getArticles() as $article) {
                $dbArticle = $this->em->getRepository(EntityNames::ARTICLE)->find($article->getId());

                if (null !== $dbArticle) {
                    $dbArticle->setPage($dbPage);
                    $dbArticles->add($dbArticle);
                }
            }
        }
        $dbPage->setArticles($dbArticles);

        // Note: we prevent updating title and url name due to the uniqid
        // stored in url-name. Otherwise, permanent links would fail
        $dbPage->setAuthor($page->getAuthor());
        $dbPage->setLanguage($page->getLanguage());
        $dbPage->setParent($page->getParent());
        $dbPage->setCreationDate($page->getCreationDate());
        $dbPage->setIsPublished($page->getIsPublished());
        $dbPage->setLastEditDate($page->getLastEditDate());
        $dbPage->setIsStartPage($page->getIsStartPage());

        $now = new DateTime('now', new DateTimeZone("UTC"));
        $dbPage->setLastEditDate($now);

        $allowedUserGroup = $page->getAllowedUserGroup();
        if (null !== $allowedUserGroup) {
            $dbPage->setAllowedUserGroup(
                $this->em->getRepository(EntityNames::USER_GROUP)->find($page->getAllowedUserGroup()->getId())
            );
        } else {
            $dbPage->setAllowedUserGroup(null);
        }

        try {
            $this->em->flush();
        } catch (DBALException $dbalex) {
            $this->logger->error($dbalex);

            throw new EntityNotUpdatedException($dbalex->getMessage());
        }

        return $this->pageMapper->entityToDto($dbPage);
    }

    public function insert($pageDto) {
        if ( ! ($pageDto instanceof PageDTO)) {
            throw new EntityInvalidException(sprintf('Required object of type "%s" but got "%s"', PageDTO::class, get_class($pageDto)));
        }

        $page = $this->pageMapper->dtoToEntity($pageDto);

        // author is current logged in user
        $page->setAuthor(
            $this->em->getRepository(EntityNames::USER)->findOneBy(
                ['username' => $this->tokenStorage->getToken()->getUsername()]
            )
        );

        if ($page->getLanguage() instanceof Language) {
            $page->setLanguage(
                $this->em->getRepository(EntityNames::LANGUAGE)->find($page->getLanguage()->getId())
            );
        }

        $origArticles = new ArrayCollection();
        $articleRepository = $this->em->getRepository(EntityNames::ARTICLE);
        // get origArticles
        if (null !== $page->getArticles()) {
            foreach ($page->getArticles() as $article) {
                /** @var \rmatil\CmsBundle\Entity\Article $origArticle */
                $origArticle = $articleRepository->findOneBy(['id' => $article->getId()]);
                if (null !== $origArticle) {
                    $origArticle->setPage($page);
                    $origArticles->add($origArticle);
                }
            }
        }
        $page->setArticles($origArticles);

        $now = new DateTime('now', new DateTimeZone('UTC'));
        $page->setLastEditDate($now);
        $page->setCreationDate($now);

        $allowedUserGroup = $page->getAllowedUserGroup();
        if (null !== $allowedUserGroup) {
            $page->setAllowedUserGroup(
                $this->em->getRepository(EntityNames::USER_GROUP)->find($page->getAllowedUserGroup()->getId())
            );
        }

        $uniqid = uniqid();
        $page->setUrlName(sprintf('%s-%s', $page->getUrlName(), $uniqid));

        $this->em->persist($page);

        try {
            $this->em->flush();
        } catch (DBALException $dbalex) {
            $this->logger->error($dbalex);

            throw new EntityNotInsertedException(sprintf('Could not insert entity "%s"', $this->entityName));
        }

        return $this->pageMapper->entityToDto($page);
    }

    public function delete($id) {
        $dbPage = $this->em->getRepository(EntityNames::PAGE)->find($id);

        if (null === $dbPage) {
            throw new EntityNotFoundException(sprintf('Could not foudn Entity "%s" with id "%s"', $this->entityName, $id));
        }

        // remove all articles
        foreach ($dbPage->getArticles() as $article) {
            $article->setPage(null);
        }

        $this->em->remove($dbPage);

        try {
            $this->em->flush();
        } catch (DBALException $dbalex) {
            $this->logger->error($dbalex);

            throw new EntityNotDeletedException($dbalex->getMessage());
        }
    }
}
