<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Plateforme;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Plateforme controller.
 *
 * @Route("plateforme")
 */
class PlateformeController extends Controller
{
    /**
     * Lists all plateforme entities.
     *
     * @Route("/", name="plateforme_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $plateformes = $em->getRepository('AppBundle:Plateforme')->findAll();

        return $this->render('@App/plateforme/index.html.twig', array(
            'plateformes' => $plateformes,
        ));
    }

    /**
     * Creates a new plateforme entity.
     *
     * @Route("/new", name="plateforme_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $plateforme = new Plateforme();
        $form = $this->createForm('AppBundle\Form\PlateformeType', $plateforme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($plateforme);
            $em->flush();

            return $this->redirectToRoute('plateforme_show', array('id' => $plateforme->getId()));
        }

        return $this->render('@App/plateforme/new.html.twig', array(
            'plateforme' => $plateforme,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a plateforme entity.
     *
     * @Route("/{id}", name="plateforme_show")
     * @Method("GET")
     */
    public function showAction(Plateforme $plateforme)
    {
        $deleteForm = $this->createDeleteForm($plateforme);

        return $this->render('@App/plateforme/show.html.twig', array(
            'plateforme' => $plateforme,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing plateforme entity.
     *
     * @Route("/{id}/edit", name="plateforme_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Plateforme $plateforme)
    {
        $deleteForm = $this->createDeleteForm($plateforme);
        $editForm = $this->createForm('AppBundle\Form\PlateformeType', $plateforme);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('plateforme_edit', array('id' => $plateforme->getId()));
        }

        return $this->render('@App/plateforme/edit.html.twig', array(
            'plateforme' => $plateforme,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a plateforme entity.
     *
     * @Route("/{id}", name="plateforme_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Plateforme $plateforme)
    {
        $form = $this->createDeleteForm($plateforme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($plateforme);
            $em->flush();
        }

        return $this->redirectToRoute('plateforme_index');
    }

    /**
     * Creates a form to delete a plateforme entity.
     *
     * @param Plateforme $plateforme The plateforme entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Plateforme $plateforme)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('plateforme_delete', array('id' => $plateforme->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
