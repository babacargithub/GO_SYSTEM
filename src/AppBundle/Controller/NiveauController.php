<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Niveau;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Niveau controller.
 *
 * @Route("niveau")
 */
class NiveauController extends Controller
{
    /**
     * Lists all niveau entities.
     *
     * @Route("/", name="niveau_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $niveaus = $em->getRepository('AppBundle:Niveau')->findAll();

        return $this->render('@App/niveau/index.html.twig', array(
            'niveaus' => $niveaus,
        ));
    }

    /**
     * Creates a new niveau entity.
     *
     * @Route("/new", name="niveau_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $niveau = new Niveau();
        $form = $this->createForm('AppBundle\Form\NiveauType', $niveau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($niveau);
            $em->flush();

            return $this->redirectToRoute('niveau_show', array('id' => $niveau->getId()));
        }

        return $this->render('@App/niveau/new.html.twig', array(
            'niveau' => $niveau,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a niveau entity.
     *
     * @Route("/{id}", name="niveau_show")
     * @Method("GET")
     */
    public function showAction(Niveau $niveau)
    {
        $deleteForm = $this->createDeleteForm($niveau);

        return $this->render('@App/niveau/show.html.twig', array(
            'niveau' => $niveau,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing niveau entity.
     *
     * @Route("/{id}/edit", name="niveau_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Niveau $niveau)
    {
        $deleteForm = $this->createDeleteForm($niveau);
        $editForm = $this->createForm('AppBundle\Form\NiveauType', $niveau);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('niveau_edit', array('id' => $niveau->getId()));
        }

        return $this->render('@App/niveau/edit.html.twig', array(
            'niveau' => $niveau,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a niveau entity.
     *
     * @Route("/{id}", name="niveau_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Niveau $niveau)
    {
        $form = $this->createDeleteForm($niveau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($niveau);
            $em->flush();
        }

        return $this->redirectToRoute('niveau_index');
    }

    /**
     * Creates a form to delete a niveau entity.
     *
     * @param Niveau $niveau The niveau entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Niveau $niveau)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('niveau_delete', array('id' => $niveau->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
