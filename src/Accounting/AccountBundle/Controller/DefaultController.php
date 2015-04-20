<?php

namespace Accounting\AccountBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();

        $accounts = $em->getRepository('AccountingAccountBundle:Account')->findAll();

        return $this->render('AccountingAccountBundle:Default:index.html.twig', array(
            'accounts' => $accounts,
        ));
    }
}
