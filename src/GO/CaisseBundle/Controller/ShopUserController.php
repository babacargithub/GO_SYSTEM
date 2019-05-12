<?php

namespace GO\CaisseBundle\Controller;

use GO\CaisseBundle\Entity\ShopUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Shopuser controller.
 *
 * @Route("shop_user")
 */
class ShopUserController extends Controller
{
    /**
     * Lists all shopUser entities.
     *
     * @Route("/", name="shop_user_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $shopUsers = $em->getRepository('GOCaisseBundle:ShopUser')->findAll();

        return $this->render('@GOCaisse/shop_user/index.html.twig', array(
            'shopUsers' => $shopUsers,
        ));
    }

    /**
     * Creates a new shopUser entity.
     *
     * @Route("/new", name="shop_user_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $shopUser = new Shopuser();
        $form = $this->createForm('GO\CaisseBundle\Form\ShopUserType', $shopUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($shopUser);
            $em->flush();

            return $this->redirectToRoute('shop_user_show', array('id' => $shopUser->getId()));
        }

        return $this->render('@GOCaisse/shop_user/new.html.twig', array(
            'shopUser' => $shopUser,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a shopUser entity.
     *
     * @Route("/{id}", name="shop_user_show")
     * @Method("GET")
     */
    public function showAction(ShopUser $shopUser)
    {
        $deleteForm = $this->createDeleteForm($shopUser);

        return $this->render('@GOCaisse/shop_user/show.html.twig', array(
            'shopUser' => $shopUser,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing shopUser entity.
     *
     * @Route("/{id}/edit", name="shop_user_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ShopUser $shopUser)
    {
        $deleteForm = $this->createDeleteForm($shopUser);
        $editForm = $this->createForm('GO\CaisseBundle\Form\ShopUserType', $shopUser);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('shop_user_edit', array('id' => $shopUser->getId()));
        }

        return $this->render('@GOCaisse/shop_user/edit.html.twig', array(
            'shopUser' => $shopUser,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a shopUser entity.
     *
     * @Route("/{id}", name="shop_user_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ShopUser $shopUser)
    {
        $form = $this->createDeleteForm($shopUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($shopUser);
            $em->flush();
        }

        return $this->redirectToRoute('shop_user_index');
    }

    /**
     * Creates a form to delete a shopUser entity.
     *
     * @param ShopUser $shopUser The shopUser entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ShopUser $shopUser)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('shop_user_delete', array('id' => $shopUser->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
