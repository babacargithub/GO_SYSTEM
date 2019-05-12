<?php

namespace GO\CaisseBundle\Controller;

use GO\CaisseBundle\Entity\Shop;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Shop controller.
 *
 * @Route("boutique")
 */
class ShopController extends MainController
{
    public function menuVerticalAction(Request $req)
    {
       $liste =array(
           array("libelle"=>"Liste des Boutiques", "id"=>"", "href"=> $this->generateUrl("boutique_index")),
           array("libelle"=>"Créer Nouveau", "id"=>"", "href"=>$this->generateUrl("boutique_new")));
          
        return $this->render('_sidebar_design.html.twig', array("menu_vertical"=>$liste));
    }
    /**
     * Lists all shop entities.
     *
     * @Route("/", name="boutique_index")
     * @Method("GET")
     */
    public function indexAction(Request $req)
    {
        $em = $this->getDoctrine()->getManager();

        $shops = $em->getRepository('GOCaisseBundle:Shop')->findAll();

        return $this->render('@GOCaisse/shop/index.html.twig', array(
            'shops' => $shops,
        ));
    }

    /**
     * Creates a new shop entity.
     *
     * @Route("/nouveau", name="boutique_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $shop = new Shop();
        $form = $this->createForm('GO\CaisseBundle\Form\ShopType', $shop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($shop);
            $em->flush();

            return $this->redirectToRoute('boutique_show', array('id' => $shop->getId()));
        }

        return $this->render('@GOCaisse/shop/new.html.twig', array(
            'shop' => $shop,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a shop entity.
     *
     * @Route("/{id}", name="boutique_show")
     * @Method("GET")
     */
    public function showAction(Shop $shop)
    {
        $deleteForm = $this->createDeleteForm($shop);

        return $this->render('@GOCaisse/shop/show.html.twig', array(
            'shop' => $shop,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing shop entity.
     *
     * @Route("/{id}/edit", name="boutique_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Shop $shop)
    {
        $deleteForm = $this->createDeleteForm($shop);
        $editForm = $this->createForm('GO\CaisseBundle\Form\ShopType', $shop);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('boutique_edit', array('id' => $shop->getId()));
        }

        return $this->render('@GOCaisse/shop/edit.html.twig', array(
            'shop' => $shop,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a shop entity.
     *
     * @Route("/{id}", name="boutique_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Shop $shop)
    {
        $form = $this->createDeleteForm($shop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($shop);
            $em->flush();
        }

        return $this->redirectToRoute('boutique_index');
    }

    /**
     * Creates a form to delete a shop entity.
     *
     * @param Shop $shop The shop entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Shop $shop)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('boutique_delete', array('id' => $shop->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
