<?php

namespace GO\CaisseBundle\Controller;

use GO\CaisseBundle\Entity\Caissier;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Caissier controller.
 *
 * @Route("caissier")
 */
class CaissierController extends Controller
{
    /**
     * Lists all caissier entities.
     *
     * @Route("/", name="caissier_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $caissiers = $em->getRepository('GOCaisseBundle:Caissier')->findAll();

        return $this->render('@GOCaisse/caissier/index.html.twig', array(
            'caissiers' => $caissiers,
        ));
    }

    /**
     * Creates a new caissier entity.
     *
     * @Route("/new", name="caissier_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $caissier = new Caissier();
        $form = $this->createForm('GO\CaisseBundle\Form\CaissierType', $caissier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($caissier);
            $em->flush();

            return $this->redirectToRoute('caissier_show', array('id' => $caissier->getId()));
        }

        return $this->render('@GOCaisse/caissier/new.html.twig', array(
            'caissier' => $caissier,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a caissier entity.
     *
     * @Route("/{id}", name="caissier_show")
     * @Method("GET")
     */
    public function showAction(Caissier $caissier)
    {
        $deleteForm = $this->createDeleteForm($caissier);

        return $this->render('@GOCaisse/caissier/show.html.twig', array(
            'caissier' => $caissier,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing caissier entity.
     *
     * @Route("/{id}/edit", name="caissier_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Caissier $caissier)
    {
        $deleteForm = $this->createDeleteForm($caissier);
        $editForm = $this->createForm('GO\CaisseBundle\Form\CaissierType', $caissier);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('caissier_edit', array('id' => $caissier->getId()));
        }

        return $this->render('@GOCaisse/caissier/edit.html.twig', array(
            'caissier' => $caissier,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a caissier entity.
     *
     * @Route("/{id}", name="caissier_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Caissier $caissier)
    {
        $form = $this->createDeleteForm($caissier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($caissier);
            $em->flush();
        }

        return $this->redirectToRoute('caissier_index');
    }

    /**
     * Creates a form to delete a caissier entity.
     *
     * @param Caissier $caissier The caissier entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Caissier $caissier)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('caissier_delete', array('id' => $caissier->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
