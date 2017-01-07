<?php


namespace rmatil\CmsBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class FileController extends Controller {

    /**
     * @Route("/files", name="rmatil_cms_get_files", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getEventsAction() {
        return $this->render('rmatilCmsBundle:File:upload.html.twig');
    }

    /**
     * @Route("/files/{id}", name="rmatil_cms_get_file", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getEventsByIdAction($id) {
        $event = $this->get('doctrine.orm.default_entity_manager')->getRepository(EntityNames::EVENT)->findOneBy(['id' => $id]);

        return $this->render('rmatilCmsBundle:File:upload.html.twig', ['event' => $event]);
    }


    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     *
     * @Route("/files", name="rmatil_cms_insert_file", methods={"POST"})
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

        var_dump($request->files->all());
        var_dump($request->request->all());die;
    }
}
