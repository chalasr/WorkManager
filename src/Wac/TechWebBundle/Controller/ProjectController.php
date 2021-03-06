<?php

namespace Wac\TechWebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Wac\TechWebBundle\Entity\Listing;
use Wac\TechWebBundle\Entity\Project;
use Wac\TechWebBundle\Form\ProjectType;

/**
 * Project controller.
 */
class ProjectController extends Controller
{
    /**
     * Lists all Project entities.
     */
    public function indexAction()
    {
        $currentUser = $this->get('security.context')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $projects = $currentUser->getProjects();

        return $this->render('WacTechWebBundle:Default:index.html.twig', array(
          'projects' => $projects,
      ));
    }
    /**
     * Creates a new Project entity.
     */
    public function createAction(Request $request)
    {
        $entity = new Project();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $todoList = new Listing();
            $todoList->setName('To Do');
            $todoList->setProject($entity);
            $em->persist($todoList);

            $doingList = new Listing();
            $doingList->setName('Doing');
            $doingList->setProject($entity);
            $em->persist($doingList);

            $doneList = new Listing();
            $doneList->setName('Done');
            $doneList->setProject($entity);
            $em->persist($doneList);

            $currentUser = $this->get('security.context')->getToken()->getUser();
            $entity->addUser($currentUser);

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('project_show', array('id' => $entity->getId())));
        }

        return $this->render('WacTechWebBundle:Project:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Project entity.
     *
     * @param Project $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Project $entity)
    {
        $form = $this->createForm(new ProjectType(), $entity, array(
            'action' => $this->generateUrl('project_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Project entity.
     */
    public function newAction()
    {
        $entity = new Project();
        $form   = $this->createCreateForm($entity);

        return $this->render('WacTechWebBundle:Project:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Project entity.
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WacTechWebBundle:Project')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Project entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('WacTechWebBundle:Project:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Project entity.
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WacTechWebBundle:Project')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Project entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('WacTechWebBundle:Project:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Project entity.
     *
     * @param Project $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Project $entity)
    {
        $form = $this->createForm(new ProjectType(), $entity, array(
            'action' => $this->generateUrl('project_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Project entity.
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WacTechWebBundle:Project')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Project entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('project_edit', array('id' => $id)));
        }

        return $this->render('WacTechWebBundle:Project:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Project entity.
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('WacTechWebBundle:Project')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Project entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('project'));
    }

    /**
     * Creates a form to delete a Project entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('project_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr' => ['class' => 'btn btn-default btn-sm']))
            ->getForm()
        ;
    }

     /**
      * Members.
      */

     /**
      * Get all members by project entity.
      *
      * @param $projectId The project entity id
      */
     public function listMembersAction($projectId)
     {
         $em = $this->getDoctrine()->getManager();
         $project = $em->getRepository('WacTechWebBundle:Project')->find($projectId);
         $users   = $em->getRepository('WacTechWebBundle:User')->findAll();
         $members = $project->getUsers();
         $membersArray = $members->toArray();
         $countUsers = count($members);
         for ($i = 0; $i < $countUsers; ++$i) {
             $member = $membersArray[$i]->getUsername();
             $user = $users[$i]->getUsername();
             if ($user == $member) {
                 unset($users[$i]);
             }
         }
         if (!$project) {
             throw $this->createNotFoundException('Unable to find Project.');
         }

         $addMemberForm = $this->createAddMemberForm($projectId);
         $removeMemberForm = $this->createRemoveMemberForm($projectId);

         return $this->render('WacTechWebBundle:Project:members.html.twig', array(
           'users'         => $users,
           'projectId'     => $projectId,
           'members'       => $members,
           'add_member'    => $addMemberForm->createView(),
           'remove_member' => $removeMemberForm->createView(),
       ));
     }

     /**
      * Creates a form to add a member to project.
      */
     private function createAddMemberForm($projectId)
     {
         return $this->createFormBuilder()
             ->setAction($this->generateUrl('project_add_member', array('projectId' => $projectId)))
             ->setMethod('POST')
             ->add('submit', 'submit', array('label' => 'Add selected user to project'))
             ->getForm();
     }

     /**
      *Add member to project.
      */
     public function addMemberAction(Request $request, $projectId)
     {
         $em = $this->getDoctrine()->getManager();

         $form = $this->createAddMemberForm($projectId);
         $form->handleRequest($request);
         $form = $request->request->get('form');
         $user = $form['userId'];
         $project = $em->getRepository('WacTechWebBundle:Project')->find($projectId);
         $members = $project->getUsers()->toArray();

         for ($i = 0; $i < sizeof($members); ++$i) {
             if ($members[$i]->getId() == $user) {
                 throw $this->createNotFoundException('Cet utilisateur est déjà membre du projet');
             }
         }

         $member = $em->getRepository('WacTechWebBundle:User')->find($user);
         $project->addUser($member);

         $em->persist($project);
         $em->flush();

         return $this->redirect($this->generateUrl('project_members', array('projectId' => $projectId)));
     }

     /**
      * Creates a form to add a member to project.
      */
     private function createRemoveMemberForm($projectId)
     {
         return $this->createFormBuilder()
             ->setAction($this->generateUrl('project_remove_member', array('projectId' => $projectId)))
             ->setMethod('DELETE')
             ->add('submit', 'submit', array('label' => 'Remove'))
             ->getForm();
     }

     /**
      *Add member to project.
      */
     public function removeMemberAction(Request $request, $projectId)
     {
         $em = $this->getDoctrine()->getManager();

         $form = $this->createRemoveMemberForm($projectId);
         $form->handleRequest($request);
         $form = $request->request->get('form');
         $user = $form['userId'];
         $member = $em->getRepository('WacTechWebBundle:User')->find($user);

         $project = $em->getRepository('WacTechWebBundle:Project')->find($projectId);
         $members = $project->getUsers()->toArray();

         $project->removeUser($member);

         $em->persist($project);
         $em->flush();

         return $this->redirect($this->generateUrl('project_members', array('projectId' => $projectId)));
     }
}
