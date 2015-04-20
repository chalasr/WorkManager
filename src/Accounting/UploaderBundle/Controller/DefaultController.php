<?php

namespace Accounting\UploaderBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Accounting\UploaderBundle\Entity\File;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AccountingUploaderBundle:Default:index.html.twig', array('name' => $name));
    }

    /**
    * @Template()
    */
    public function uploadAction()
    {
        $document = new File();
        $form = $this->createFormBuilder($document)
           ->add('file')
           ->add('name')
           ->getForm();

        if ($this->getRequest()->isMethod('POST')) {
           $form->handleRequest($this->getRequest());
           if ($form->isValid()) {
               $em = $this->getDoctrine()->getManager();

               $document->upload();

               $em->persist($document);
               $em->flush();

               $this->redirect($this->generateUrl('accounting_account_homepage'));
           }
        }

        return array('form' => $form->createView());
    }


}
