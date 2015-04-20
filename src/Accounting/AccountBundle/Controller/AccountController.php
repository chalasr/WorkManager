<?php

namespace Accounting\AccountBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Accounting\AccountBundle\Entity\Account;
use Accounting\AccountBundle\Form\AccountType;

/**
 * Account controller.
 *
 */
class AccountController extends Controller
{

    /**
     * Lists all Account entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AccountingAccountBundle:Account')->findAll();

        return $this->render('AccountingAccountBundle:Account:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Account entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Account();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('account_show', array('id' => $entity->getId())));
        }

        return $this->render('AccountingAccountBundle:Account:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Account entity.
     *
     * @param Account $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Account $entity)
    {
        $form = $this->createForm(new AccountType(), $entity, array(
            'action' => $this->generateUrl('account_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Account entity.
     *
     */
    public function newAction()
    {
        $entity = new Account();
        $form   = $this->createCreateForm($entity);

        return $this->render('AccountingAccountBundle:Account:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Account entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AccountingAccountBundle:Account')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Account entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AccountingAccountBundle:Account:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Account entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AccountingAccountBundle:Account')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Account entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AccountingAccountBundle:Account:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Account entity.
    *
    * @param Account $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Account $entity)
    {
        $form = $this->createForm(new AccountType(), $entity, array(
            'action' => $this->generateUrl('account_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Account entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AccountingAccountBundle:Account')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Account entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('account_edit', array('id' => $id)));
        }

        return $this->render('AccountingAccountBundle:Account:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Account entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AccountingAccountBundle:Account')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Account entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('account'));
    }

    /**
     * Creates a form to delete a Account entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('account_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
