<?php


namespace rmatil\CmsBundle\Controller;


use rmatil\CmsBundle\Constants\HttpStatusCodes;
use rmatil\CmsBundle\Exception\EntityNotFoundException;
use rmatil\CmsBundle\Exception\EntityNotInsertedException;
use rmatil\CmsBundle\Model\FileDTO;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class FileController extends Controller {

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/files", name="rmatil_cms_get_files", methods={"GET"})
     */
    public function getFilesAction() {
        $responseFactory = $this->get('rmatil_cms.factory.json_response');
        $files = $this->get('rmatil_cms.data_accessor.file')->getAll();

        return $responseFactory->createResponse($files);
    }

    /**
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/files/{id}", name="rmatil_cms_get_file", methods={"GET"})
     */
    public function getFileByIdAction($id) {
        $responseFactory = $this->get('rmatil_cms.factory.json_response');
        $file = $this->get('rmatil_cms.data_accessor.file')->getById($id);

        return $responseFactory->createResponse($file);
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
        $responseFactory = $this->get('rmatil_cms.factory.json_response');

        if ( ! $request->files->has('file')) {
            return $responseFactory->createErrorResponse(HttpStatusCodes::BAD_REQUEST, 'No file submitted');
        }

        // jms serializer is not able to convert multipart form data just out of the box
        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $request->files->get('file');


        $fileDto = new FileDTO();
        $fileDto->setName($uploadedFile->getClientOriginalName());
        $fileDto->setDescription($request->request->get('description'));
        $fileDto->setFile($uploadedFile);
        $fileDto->setCreationDate($request->request->get('creation_date'));

        $fileDto->setFile($request->files->get('file'));

        try {

            $file = $this->get('rmatil_cms.data_accessor.file')->insert($fileDto);

            return $responseFactory->createResponseWithCode(HttpStatusCodes::CREATED, $file);

        } catch (EntityNotInsertedException $enie) {
            return $responseFactory->createErrorResponse(HttpStatusCodes::CONFLICT, $enie->getMessage());
        }
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     *
     * @Route("/files/{id}", name="rmatil_cms_delete_file", methods={"DELETE"})
     */
    public function deleteFileByIdAction($id) {
        $responseFactory = $this->get('rmatil_cms.factory.json_response');

        try {

            $this->get('rmatil_cms.data_accessor.file')->delete($id);

        } catch (EntityNotFoundException $enfe) {
            return $responseFactory->createNotFoundResponse($enfe->getMessage());
        }

        return $responseFactory->createResponseWithCode(HttpStatusCodes::NO_CONTENT, '');
    }
}
