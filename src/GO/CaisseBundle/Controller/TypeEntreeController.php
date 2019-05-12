<?php

namespace GO\CaisseBundle\Controller;

use GO\CaisseBundle\Entity\TypeEntree;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Typeentree controller.
 *
 * @Route("type_entree")
 */
class TypeEntreeController extends Controller
{
    /**
     * Lists all typeEntree entities.
     *
     * @Route("/", name="type_entree_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $typeEntrees = $em->getRepository('GOCaisseBundle:TypeEntree')->findAll();

        return $this->render('@GOCaisse/typeentree/index.html.twig', array(
            'typeEntrees' => $typeEntrees,
        ));
    }

    /**
     * Creates a new typeEntree entity.
     *
     * @Route("/new", name="type_entree_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $typeEntree = new Typeentree();
        $form = $this->createForm('GO\CaisseBundle\Form\TypeEntreeType', $typeEntree);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeEntree);
            $em->flush();

            return $this->redirectToRoute('type_entree_show', array('id' => $typeEntree->getId()));
        }

        return $this->render('@GOCaisse/typeentree/new.html.twig', array(
            'typeEntree' => $typeEntree,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a typeEntree entity.
     *
     * @Route("/{id}", name="type_entree_show")
     * @Method("GET")
     */
    public function showAction(TypeEntree $typeEntree)
    {
        $deleteForm = $this->createDeleteForm($typeEntree);

        return $this->render('@GOCaisse/typeentree/show.html.twig', array(
            'typeEntree' => $typeEntree,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing typeEntree entity.
     *
     * @Route("/{id}/edit", name="type_entree_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TypeEntree $typeEntree)
    {
        $deleteForm = $this->createDeleteForm($typeEntree);
        $editForm = $this->createForm('GO\CaisseBundle\Form\TypeEntreeType', $typeEntree);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('type_entree_edit', array('id' => $typeEntree->getId()));
        }

        return $this->render('@GOCaisse/typeentree/edit.html.twig', array(
            'typeEntree' => $typeEntree,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a typeEntree entity.
     *
     * @Route("/{id}", name="type_entree_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TypeEntree $typeEntree)
    {
        $form = $this->createDeleteForm($typeEntree);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typeEntree);
            $em->flush();
        }

        return $this->redirectToRoute('type_entree_index');
    }

    /**
     * Creates a form to delete a typeEntree entity.
     *
     * @param TypeEntree $typeEntree The typeEntree entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TypeEntree $typeEntree)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('type_entree_delete', array('id' => $typeEntree->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
