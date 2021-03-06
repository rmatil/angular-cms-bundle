<?php


namespace rmatil\CmsBundle\Controller;


use DateTime;
use DateTimeZone;
use rmatil\CmsBundle\Constants\HttpStatusCodes;
use rmatil\CmsBundle\Entity\Article;
use rmatil\CmsBundle\Exception\EntityInvalidException;
use rmatil\CmsBundle\Exception\EntityNotFoundException;
use rmatil\CmsBundle\Exception\EntityNotInsertedException;
use rmatil\CmsBundle\Exception\EntityNotUpdatedException;
use rmatil\CmsBundle\Model\ArticleDTO;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends Controller {

    /**
     * @return JsonResponse
     *
     * @Route("/articles", name="rmatil_cms_get_articles", methods={"GET"})
     */
    public function getArticlesAction() {
        $responseFactory = $this->get('rmatil_cms.factory.json_response');
        $articles = $this->get('rmatil_cms.data_accessor.article')->getAll();

        return $responseFactory->createResponse($articles);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     *
     * @Route("/articles/{id}", name="rmatil_cms_get_article", methods={"GET"})
     */
    public function getArticleByIdAction($id) {
        $responseFactory = $this->get('rmatil_cms.factory.json_response');

        try {
            $article = $this->get('rmatil_cms.data_accessor.article')->getById($id);

            return $responseFactory->createResponse($article);
        } catch (EntityNotFoundException $ex) {
            return $responseFactory->createNotFoundResponse($ex->getMessage());
        }
    }

    /**
     * @param         $id
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @Route("/articles/{id}", name="rmatil_cms_update_article", methods={"PUT"})
     */
    public function updateArticleAction($id, Request $request) {
        $responseFactory = $this->get('rmatil_cms.factory.json_response');

        /** @var \rmatil\CmsBundle\Model\ArticleDTO $articleDto */
        $articleDto = $this->get('jms_serializer')->deserialize(
            $request->getContent(),
            ArticleDTO::class,
            'json'
        );

        $articleDto->setId($id);

        try {
            $obj = $this->get('rmatil_cms.data_accessor.article')->update($articleDto);

            return $responseFactory->createResponse($obj);

        } catch (EntityInvalidException $eie) {
            return $responseFactory->createErrorResponse(HttpStatusCodes::BAD_REQUEST, $eie->getMessage());
        } catch (EntityNotFoundException $enfe) {
            return $responseFactory->createNotFoundResponse($enfe->getMessage());
        } catch (EntityNotUpdatedException $enue) {
            return $responseFactory->createErrorResponse(HttpStatusCodes::CONFLICT, $enue->getMessage());
        }
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @Route("/articles", name="rmatil_cms_insert_article", methods={"POST"})
     */
    public function insertArticleAction(Request $request) {
        $responseFactory = $this->get('rmatil_cms.factory.json_response');

        /** @var \rmatil\CmsBundle\Model\ArticleDTO $articleDto */
        $articleDto = $this->get('jms_serializer')->deserialize(
            $request->getContent(),
            ArticleDTO::class,
            'json'
        );

        $now = new DateTime('now', new DateTimeZone('UTC'));
        $articleDto->setLastEditDate($now);
        $articleDto->setCreationDate($now);

        try {

            $article = $this->get('rmatil_cms.data_accessor.article')->insert($articleDto);

            return $responseFactory->createResponseWithCode(HttpStatusCodes::CREATED, $article);

        } catch (EntityNotInsertedException $enie) {
            return $responseFactory->createErrorResponse(HttpStatusCodes::CONFLICT, $enie->getMessage());
        }
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     *
     * @Route("/articles/{id}", name="rmatil_cms_delete_article", methods={"DELETE"})
     */
    public function deleteArticleByIdAction($id) {
        $responseFactory = $this->get('rmatil_cms.factory.json_response');

        try {

            $this->get('rmatil_cms.data_accessor.article')->delete($id);

        } catch (EntityNotFoundException $enfe) {
            return $responseFactory->createNotFoundResponse($enfe->getMessage());
        }

        return $responseFactory->createResponseWithCode(HttpStatusCodes::NO_CONTENT, "");
    }
}
