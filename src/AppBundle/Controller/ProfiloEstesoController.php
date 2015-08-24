<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\ProfiloEsteso;
use AppBundle\Form\ProfiloEstesoType;

/**
 * ProfiloEsteso controller.
 *
 * @Route("/profiloesteso")
 */
class ProfiloEstesoController extends Controller implements TokenAuthenticatedController
{

    /**
     * Lists all ProfiloEsteso entities.
     *
     * @Route("/", name="profiloesteso")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:ProfiloEsteso')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new ProfiloEsteso entity.
     *
     * @Route("/", name="profiloesteso_create")
     * @Method("POST")
     * @Template("AppBundle:ProfiloEsteso:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new ProfiloEsteso();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            //return $this->redirect($this->generateUrl('profiloesteso_show', array('id' => $entity->getId())));
            $response = new Response(json_encode(array('message' => 'profilo esteso successfully added!','id2' => $entity->getId2())));
            $response->headers->set('Content-Type','application/json');
            return $response;
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a ProfiloEsteso entity.
     *
     * @param ProfiloEsteso $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ProfiloEsteso $entity)
    {
        $form = $this->createForm(new ProfiloEstesoType(), $entity, array(
            'action' => $this->generateUrl('profiloesteso_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Add'));

        return $form;
    }

    /**
     * Displays a form to create a new ProfiloEsteso entity.
     *
     * @Route("/new", name="profiloesteso_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ProfiloEsteso();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a ProfiloEsteso entity.
     *
     * @Route("/{id}", name="profiloesteso_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:ProfiloEsteso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProfiloEsteso entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ProfiloEsteso entity.
     *
     * @Route("/{id}/edit", name="profiloesteso_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:ProfiloEsteso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProfiloEsteso entity.');
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
    * Creates a form to edit a ProfiloEsteso entity.
    *
    * @param ProfiloEsteso $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ProfiloEsteso $entity)
    {
        $form = $this->createForm(new ProfiloEstesoType(), $entity, array(
            'action' => $this->generateUrl('profiloesteso_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing ProfiloEsteso entity.
     *
     * @Route("/{id}", name="profiloesteso_update")
     * @Method("PUT")
     * @Template("AppBundle:ProfiloEsteso:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:ProfiloEsteso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProfiloEsteso entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('profiloesteso_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a ProfiloEsteso entity.
     *
     * @Route("/{id}", name="profiloesteso_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:ProfiloEsteso')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ProfiloEsteso entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('profiloesteso'));
    }

    /**
     * Creates a form to delete a ProfiloEsteso entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('profiloesteso_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
