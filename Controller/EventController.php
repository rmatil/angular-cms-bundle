<?php


namespace rmatil\CmsBundle\Controller;


use rmatil\CmsBundle\Constants\HttpStatusCodes;
use rmatil\CmsBundle\Exception\EntityInvalidException;
use rmatil\CmsBundle\Exception\EntityNotFoundException;
use rmatil\CmsBundle\Exception\EntityNotInsertedException;
use rmatil\CmsBundle\Exception\EntityNotUpdatedException;
use rmatil\CmsBundle\Model\EventDTO;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class EventController extends Controller {

    /**
     * @return JsonResponse
     *
     * @Route("/events", name="rmatil_cms_get_events", methods={"GET"})
     */
    public function getEventsAction() {
        $responseFactory = $this->get('rmatil_cms.factory.json_response');
        $events = $this->get('rmatil_cms.data_accessor.event')->getAll();

        return $responseFactory->createResponse($events);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     *
     * @Route("/events/{id}", name="rmatil_cms_get_event", methods={"GET"})
     */
    public function getEventByIdAction($id) {
        $responseFactory = $this->get('rmatil_cms.factory.json_response');

        try {
            $article = $this->get('rmatil_cms.data_accessor.event')->getById($id);

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
     * @Route("/events/{id}", name="rmatil_cms_update_event", methods={"PUT"})
     */
    public function updateEventAction($id, Request $request) {
        $responseFactory = $this->get('rmatil_cms.factory.json_response');

        /** @var \rmatil\CmsBundle\Model\EventDTO $eventDto */
        $eventDto = $this->get('jms_serializer')->deserialize(
            $request->getContent(),
            EventDTO::class,
            'json'
        );

        $eventDto->setId($id);

        try {
            $obj = $this->get('rmatil_cms.data_accessor.event')->update($eventDto);

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
     * @Route("/events", name="rmatil_cms_insert_events", methods={"POST"})
     */
    public function insertEventAction(Request $request) {
        $responseFactory = $this->get('rmatil_cms.factory.json_response');

        /** @var \rmatil\CmsBundle\Model\EventDTO $eventDto */
        $eventDto = $this->get('jms_serializer')->deserialize(
            $request->getContent(),
            EventDTO::class,
            'json'
        );

        try {

            $article = $this->get('rmatil_cms.data_accessor.event')->insert($eventDto);

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
     * @Route("/events/{id}", name="rmatil_cms_delete_event", methods={"DELETE"})
     */
    public function deleteEventByIdAction($id) {
        $responseFactory = $this->get('rmatil_cms.factory.json_response');

        try {

            $this->get('rmatil_cms.data_accessor.event')->delete($id);

        } catch (EntityNotFoundException $enfe) {
            return $responseFactory->createNotFoundResponse($enfe->getMessage());
        }

        return $responseFactory->createResponseWithCode(HttpStatusCodes::NO_CONTENT, "");
    }
}
