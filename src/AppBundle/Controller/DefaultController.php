<?php

namespace AppBundle\Controller;

use AppBundle\Service\ImportService;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 * @package AppBundle\Controller
 */
class DefaultController extends Controller
{
    /** @var  ImportService $importService */
    protected $importService;

    /**
     * @Route("/", name="import")
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('attach', FileType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Task'))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isValid()) {
            $data = [];
            $importService = $this->getImportService();
            $importService->uploadFile($form->get('attach')->getData());
            $csv = new \SplFileObject($importService->getUploadedCsvName().'csv');
            if ($data['delimiter'] = $importService->getFileDelimiter($csv->current())) {
                $importService->getCsvHeader($csv, $data);

                return $this->forward('AppBundle:Default:step2', ['data' => $data]);
            }

        }

        return $this->render('default/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/2", name="import_step2")
     * @param Request $request
     * @Method("POST")
     * @return Response
     */
    public function step2Action(Request $request)
    {
        $data = $request->get('data');
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $entityFields = $em->getClassMetadata('AppBundle\Entity\Emails')->getFieldNames();
        unset($entityFields[0]);

        return $this->render(':default:step2.html.twig', [
            'data' => $data,
            'entityFields' => $entityFields,
        ]);
    }

    /**
     * @Route("import", name="run_import")
     * @Method("GET")
     * @param Request $request
     * @return Response
     */
    public function startImportAction(Request $request)
    {
        $request->attributes->all();
        $request->get('from_add.toAdd');

        return new Response();
    }

    private function getImportService()
    {
        if (!$this->importService) {
            $this->importService = $this->get('import_email');
        }

        return $this->importService;
    }
}
