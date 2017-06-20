<?php


namespace rmatil\CmsBundle\Controller;


use rmatil\CmsBundle\Constants\HttpStatusCodes;
use rmatil\CmsBundle\Exception\EntityInvalidException;
use rmatil\CmsBundle\Exception\EntityNotFoundException;
use rmatil\CmsBundle\Exception\EntityNotInsertedException;
use rmatil\CmsBundle\Exception\EntityNotUpdatedException;
use rmatil\CmsBundle\Model\MediaTagDTO;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MediaTagController extends Controller {

    /**
     * @return JsonResponse
     *
     * @Route("/media-tags", name="rmatil_cms_get_media_tags", methods={"GET"})
     */
    public function getMediaTagsAction() {
        $responseFactory = $this->get('rmatil_cms.factory.json_response');
        $mediaTags = $this->get('rmatil_cms.data_accessor.media_tag')->getAll();

        return $responseFactory->createResponse($mediaTags);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     *
     * @Route("/media-tags/{id}", name="rmatil_cms_get_media_tag", methods={"GET"})
     */
    public function getMediaTagByIdAction($id) {
        $responseFactory = $this->get('rmatil_cms.factory.json_response');

        try {
            $article = $this->get('rmatil_cms.data_accessor.media_tag')->getById($id);

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
     * @Route("/media-tags/{id}", name="rmatil_cms_update_media_tag", methods={"PUT"})
     */
    public function updateArticleAction($id, Request $request) {
        $responseFactory = $this->get('rmatil_cms.factory.json_response');

        /** @var \rmatil\CmsBundle\Model\MediaTagDTO $mediaTagDto */
        $mediaTagDto = $this->get('jms_serializer')->deserialize(
            $request->getContent(),
            MediaTagDTO::class,
            'json'
        );

        $mediaTagDto->setId($id);

        try {
            $obj = $this->get('rmatil_cms.data_accessor.media_tag')->update($mediaTagDto);

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
     * @Route("/media-tags", name="rmatil_cms_insert_media_tag", methods={"POST"})
     */
    public function insertArticleAction(Request $request) {
        $responseFactory = $this->get('rmatil_cms.factory.json_response');

        /** @var \rmatil\CmsBundle\Model\MediaTagDTO $mediaTagDto */
        $mediaTagDto = $this->get('jms_serializer')->deserialize(
            $request->getContent(),
            MediaTagDTO::class,
            'json'
        );

        try {

            $mediaTag = $this->get('rmatil_cms.data_accessor.media_tag')->insert($mediaTagDto);

            return $responseFactory->createResponseWithCode(HttpStatusCodes::CREATED, $mediaTag);

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
