<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Profilo;
use AppBundle\Form\ProfiloType;
use AppBundle\Controller\TokenAuthenticatedController;

/**
 * Profilo controller.
 *
 * @Route("/profilo")
 */
class ProfiloController extends Controller implements TokenAuthenticatedController
{

    /**
     * Lists all Profilo entities.
     *
     * @Route("/", name="profilo")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Profilo')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Profilo entity.
     *
     * @Route("/", name="profilo_create")
     * @Method("POST")
     * @Template("AppBundle:Profilo:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Profilo();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            //return $this->redirect($this->generateUrl('profilo_show', array('id' => $entity->getId1())));
            $response = new Response(json_encode(array('message' => "profilo successfully added!", 'id1' => $entity->getId1())));
            $response->headers->set('Content-Type','application/json');

            return $response;
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Profilo entity.
     *
     * @param Profilo $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Profilo $entity)
    {
        $form = $this->createForm(new ProfiloType(), $entity, array(
            'action' => $this->generateUrl('profilo_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Add'));

        return $form;
    }

    /**
     * Displays a form to create a new Profilo entity.
     *
     * @Route("/new", name="profilo_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Profilo();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Profilo entity.
     *
     * @Route("/{id}", name="profilo_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Profilo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Profilo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Profilo entity.
     *
     * @Route("/{id}/edit", name="profilo_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Profilo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Profilo entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Profilo entity.
    *
    * @param Profilo $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Profilo $entity)
    {
        $form = $this->createForm(new ProfiloType(), $entity, array(
            'action' => $this->generateUrl('profilo_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Profilo entity.
     *
     * @Route("/{id}", name="profilo_update")
     * @Method("PUT")
     * @Template("AppBundle:Profilo:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Profilo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Profilo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('profilo_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Profilo entity.
     *
     * @Route("/{id}", name="profilo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Profilo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Profilo entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('profilo'));
    }

    /**
     * Creates a form to delete a Profilo entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('profilo_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
