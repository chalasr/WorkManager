<?php

namespace Wac\TechWebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $currentUser= $this->get('security.context')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $projects = $currentUser->getProjects();
        return $this->render('WacTechWebBundle:Default:index.html.twig', array(
            'projects' => $projects
        ));
        return $this->render('WacTechWebBundle:Default:index.html.twig', array(''));
    }
}
