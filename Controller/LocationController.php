<?php


namespace rmatil\CmsBundle\Controller;


use rmatil\CmsBundle\Constants\HttpStatusCodes;
use rmatil\CmsBundle\Exception\EntityInvalidException;
use rmatil\CmsBundle\Exception\EntityNotFoundException;
use rmatil\CmsBundle\Exception\EntityNotInsertedException;
use rmatil\CmsBundle\Exception\EntityNotUpdatedException;
use rmatil\CmsBundle\Model\LocationDTO;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class LocationController extends Controller {

    /**
     * @return JsonResponse
     *
     * @Route("/locations", name="rmatil_cms_get_locations", methods={"GET"})
     */
    public function getLocationsAction() {
        $responseFactory = $this->get('rmatil_cms.factory.json_response');
        $locations = $this->get('rmatil_cms.data_accessor.location')->getAll();

        return $responseFactory->createResponse($locations);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     *
     * @Route("/locations/{id}", name="rmatil_cms_get_location", methods={"GET"})
     */
    public function getLocationByIdAction($id) {
        $responseFactory = $this->get('rmatil_cms.factory.json_response');

        try {
            $location = $this->get('rmatil_cms.data_accessor.location')->getById($id);

            return $responseFactory->createResponse($location);
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
     * @Route("/locations/{id}", name="rmatil_cms_update_location", methods={"PUT"})
     */
    public function updateLocationAction($id, Request $request) {
        $responseFactory = $this->get('rmatil_cms.factory.json_response');

        /** @var \rmatil\CmsBundle\Model\LocationDTO $locationDto */
        $locationDto = $this->get('jms_serializer')->deserialize(
            $request->getContent(),
            LocationDTO::class,
            'json'
        );

        $locationDto->setId($id);

        try {
            $obj = $this->get('rmatil_cms.data_accessor.location')->update($locationDto);

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
     * @Route("/locations", name="rmatil_cms_insert_location", methods={"POST"})
     */
    public function insertLocationAction(Request $request) {
        $responseFactory = $this->get('rmatil_cms.factory.json_response');

        /** @var \rmatil\CmsBundle\Model\LocationDTO $locationDto */
        $locationDto = $this->get('jms_serializer')->deserialize(
            $request->getContent(),
            LocationDTO::class,
            'json'
        );

        try {

            $location = $this->get('rmatil_cms.data_accessor.location')->insert($locationDto);

            return $responseFactory->createResponseWithCode(HttpStatusCodes::CREATED, $location);

        } catch (EntityNotInsertedException $enie) {
            return $responseFactory->createErrorResponse(HttpStatusCodes::CONFLICT, $enie->getMessage());
        }
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     *
     * @Route("/locations/{id}", name="rmatil_cms_delete_location", methods={"DELETE"})
     */
    public function deleteLocationByIdAction($id) {
        $responseFactory = $this->get('rmatil_cms.factory.json_response');

        try {

            $this->get('rmatil_cms.data_accessor.location')->delete($id);

        } catch (EntityNotFoundException $enfe) {
            return $responseFactory->createNotFoundResponse($enfe->getMessage());
        }

        return $responseFactory->createResponseWithCode(HttpStatusCodes::NO_CONTENT, "");
    }
}
