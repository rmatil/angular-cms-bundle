<?php


namespace rmatil\CmsBundle\Controller;


use DateTime;
use DateTimeZone;
use rmatil\CmsBundle\Constants\HttpStatusCodes;
use rmatil\CmsBundle\Exception\EntityInvalidException;
use rmatil\CmsBundle\Exception\EntityNotFoundException;
use rmatil\CmsBundle\Exception\EntityNotInsertedException;
use rmatil\CmsBundle\Exception\EntityNotUpdatedException;
use rmatil\CmsBundle\Model\PageDTO;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class PageController extends Controller {

    /**
     * @return JsonResponse
     *
     * @Route("/pages", name="rmatil_cms_get_pages", methods={"GET"})
     */
    public function getPagesAction() {
        $responseFactory = $this->get('rmatil_cms.factory.json_response');
        $pages = $this->get('rmatil_cms.data_accessor.page')->getAll();

        return $responseFactory->createResponse($pages);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     *
     * @Route("/pages/{id}", name="rmatil_cms_get_page", methods={"GET"})
     */
    public function getPageByIdAction($id) {
        $responseFactory = $this->get('rmatil_cms.factory.json_response');

        try {
            $page = $this->get('rmatil_cms.data_accessor.page')->getById($id);

            return $responseFactory->createResponse($page);
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
     * @Route("/pages/{id}", name="rmatil_cms_update_page", methods={"PUT"})
     */
    public function updatePageAction($id, Request $request) {
        $responseFactory = $this->get('rmatil_cms.factory.json_response');

        /** @var \rmatil\CmsBundle\Model\PageDTO $pageDto */
        $pageDto = $this->get('jms_serializer')->deserialize(
            $request->getContent(),
            PageDTO::class,
            'json'
        );

        $pageDto->setId($id);

        try {
            $obj = $this->get('rmatil_cms.data_accessor.page')->update($pageDto);

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
     * @Route("/pages", name="rmatil_cms_insert_page", methods={"POST"})
     */
    public function insertPageAction(Request $request) {
        $responseFactory = $this->get('rmatil_cms.factory.json_response');

        /** @var \rmatil\CmsBundle\Model\PageDTO $pageDto */
        $pageDto = $this->get('jms_serializer')->deserialize(
            $request->getContent(),
            PageDTO::class,
            'json'
        );

        $now = new DateTime('now', new DateTimeZone('UTC'));
        $pageDto->setLastEditDate($now);
        $pageDto->setCreationDate($now);

        try {

            $page = $this->get('rmatil_cms.data_accessor.page')->insert($pageDto);

            return $responseFactory->createResponseWithCode(HttpStatusCodes::CREATED, $page);

        } catch (EntityNotInsertedException $enie) {
            return $responseFactory->createErrorResponse(HttpStatusCodes::CONFLICT, $enie->getMessage());
        }
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     *
     * @Route("/pages/{id}", name="rmatil_cms_delete_page", methods={"DELETE"})
     */
    public function deletePageByIdAction($id) {
        $responseFactory = $this->get('rmatil_cms.factory.json_response');

        try {

            $this->get('rmatil_cms.data_accessor.page')->delete($id);

        } catch (EntityNotFoundException $enfe) {
            return $responseFactory->createNotFoundResponse($enfe->getMessage());
        }

        return $responseFactory->createResponseWithCode(HttpStatusCodes::NO_CONTENT, "");
    }
}
