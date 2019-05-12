<?php

namespace GO\ClientBundle\Controller;

use GO\ClientBundle\Entity\CategorieClient;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Categorieclient controller.
 *
 * @Route("categorie_client")
 */
class CategorieClientController extends Controller
{
    /**
     * Lists all categorieClient entities.
     *
     * @Route("/", name="categorie_client_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categorieClients = $em->getRepository('GOClientBundle:CategorieClient')->findAll();

        return $this->render('@GOClient/categorie_client/index.html.twig', array(
            'categorieClients' => $categorieClients,
        ));
    }

    /**
     * Creates a new categorieClient entity.
     *
     * @Route("/new", name="categorie_client_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $categorieClient = new Categorieclient();
        $form = $this->createForm('GO\ClientBundle\Form\CategorieClientType', $categorieClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorieClient);
            $em->flush();

            return $this->redirectToRoute('categorie_client_show', array('id' => $categorieClient->getId()));
        }

        return $this->render('@GOClient/categorie_client/new.html.twig', array(
            'categorieClient' => $categorieClient,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a categorieClient entity.
     *
     * @Route("/{id}", name="categorie_client_show")
     * @Method("GET")
     */
    public function showAction(CategorieClient $categorieClient)
    {
        $deleteForm = $this->createDeleteForm($categorieClient);

        return $this->render('@GOClient/categorie_client/show.html.twig', array(
            'categorieClient' => $categorieClient,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing categorieClient entity.
     *
     * @Route("/{id}/edit", name="categorie_client_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CategorieClient $categorieClient)
    {
        $deleteForm = $this->createDeleteForm($categorieClient);
        $editForm = $this->createForm('GO\ClientBundle\Form\CategorieClientType', $categorieClient);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categorie_client_edit', array('id' => $categorieClient->getId()));
        }

        return $this->render('@GOClient/categorie_client/edit.html.twig', array(
            'categorieClient' => $categorieClient,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a categorieClient entity.
     *
     * @Route("/{id}", name="categorie_client_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CategorieClient $categorieClient)
    {
        $form = $this->createDeleteForm($categorieClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($categorieClient);
            $em->flush();
        }

        return $this->redirectToRoute('categorie_client_index');
    }

    /**
     * Creates a form to delete a categorieClient entity.
     *
     * @param CategorieClient $categorieClient The categorieClient entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CategorieClient $categorieClient)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('categorie_client_delete', array('id' => $categorieClient->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
