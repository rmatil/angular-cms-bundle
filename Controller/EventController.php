<?php


namespace rmatil\CmsBundle\Controller;


use rmatil\CmsBundle\Constants\EntityNames;
use rmatil\CmsBundle\Constants\HttpStatusCodes;
use rmatil\CmsBundle\Entity\Event;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EventController extends Controller {

    /**
     * @Route("/events", name="get_events", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getEventsAction() {
        return $this->render('rmatilCmsBundle:Events:upload.html.twig');
    }

    /**
     * @Route("/events/{id}", name="get_event", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getEventsByIdAction($id) {
        $event = $this->get('doctrine.orm.default_entity_manager')->getRepository(EntityNames::EVENT)->findOneBy(['id' => $id]);

        return $this->render('rmatilCmsBundle:Events:upload.html.twig', ['event' => $event]);
    }


    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     *
     * @Route("/events", name="insert_event", methods={"POST"})
     */
    public function insertEventAction(Request $request) {
        $uploadedFile = null;
        // we only use one file
        foreach ($_FILES as $file) {
            $uploadedFile = new UploadedFile($file['tmp_name'], $file['name'], $file['type'], $file['size'], $file['error'], false);
        }


        if (null === $uploadedFile) {
            throw new \Exception('file not received');
        }

        $event = new Event();
        $event->setFilePath($uploadedFile);
        $event->setName("some name");
        $event->setContent('content');
        $event->setAdditionalInfo('additional info');
        $event->setCreationDate(new \DateTime());
        $event->setLastEditDate(new \DateTime());
        $event->setUrlName('event-1');

        $em = $this->get('doctrine.orm.default_entity_manager');

        $em->persist($event);
        $em->flush();

        return new Response(HttpStatusCodes::CREATED);
    }
}
