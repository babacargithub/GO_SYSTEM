<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Exercice;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security as Secure;

use Symfony\Component\HttpFoundation\Request;

/**
 * Exercice controller.
 *
 * @Route("exercice")
 */
class ExerciceController extends Controller
{
    /**
     * Lists all exercice entities.
     *
     * @Route("/", name="exercice_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $exercices = $em->getRepository('AppBundle:Exercice')->findAll();

        return $this->render('@App/exercice/index.html.twig', array(
            'exercices' => $exercices,
        ));
    }

    /**
     * Creates a new exercice entity.
     *
     * @Route("/new", name="exercice_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $exercice = new Exercice();
        $form = $this->createForm('AppBundle\Form\ExerciceType', $exercice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($exercice);
            $em->flush();

            return $this->redirectToRoute('exercice_show', array('id' => $exercice->getId()));
        }

        return $this->render('@App/exercice/new.html.twig', array(
            'exercice' => $exercice,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a exercice entity.
     *
     * @Route("/{id}", name="exercice_show")
     * @Method("GET")
     */
    public function showAction(Exercice $exercice)
    {
        $deleteForm = $this->createDeleteForm($exercice);

        return $this->render('@App/exercice/show.html.twig', array(
            'exercice' => $exercice,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Finds and displays a exercice entity.
     *
     * @Route("/chiffre/{id}", name="exercice_chiffres")
     * @Secure("has_role('ROLE_SUPER_ADMIN')")
     */
    public function chiffresAction(Exercice $ex)
    {
         $exercice=$this->getDoctrine()->getManager()->getRepository('AppBundle:Exercice')->getCurrent();
      return $this->render('@App/exercice/chiffres.html.twig', array(
            'exercice' => $exercice,
            
        ));
    }

    /**
     * Displays a form to edit an existing exercice entity.
     *
     * @Route("/{id}/edit", name="exercice_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Exercice $exercice)
    {
        $deleteForm = $this->createDeleteForm($exercice);
        $editForm = $this->createForm('AppBundle\Form\ExerciceType', $exercice);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('exercice_edit', array('id' => $exercice->getId()));
        }

        return $this->render('@App/exercice/edit.html.twig', array(
            'exercice' => $exercice,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a exercice entity.
     *
     * @Route("/{id}", name="exercice_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Exercice $exercice)
    {
        $form = $this->createDeleteForm($exercice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($exercice);
            $em->flush();
        }

        return $this->redirectToRoute('exercice_index');
    }

    /**
     * Creates a form to delete a exercice entity.
     *
     * @param Exercice $exercice The exercice entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Exercice $exercice)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('exercice_delete', array('id' => $exercice->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
