<?php

namespace GO\CaisseBundle\Controller;

use GO\CaisseBundle\Entity\CaisseUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Caisseuser controller.
 *
 * @Route("caisse_user")
 */
class CaisseUserController extends Controller
{
    /**
     * Lists all caisseUser entities.
     *
     * @Route("/", name="caisse_user_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $caisseUsers = $em->getRepository('GOCaisseBundle:CaisseUser')->findAll();

        return $this->render('@GOCaisse/caisse_user/index.html.twig', array(
            'caisseUsers' => $caisseUsers,
        ));
    }

    /**
     * Creates a new caisseUser entity.
     *
     * @Route("/nouvelle_affectation", name="caisse_user_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $caisseUser = new CaisseUser();
        $caisseUser->setUser($this->getUser())
                    ->setCreatedAt(new \DateTime())
                    ->setDeleted(false);
        $form = $this->createForm('GO\CaisseBundle\Form\CaisseUserType', $caisseUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($caisseUser);
            $em->flush();

            return $this->redirectToRoute('caisse_user_show', array('id' => $caisseUser->getId()));
        }

        return $this->render('@GOCaisse/caisse_user/new.html.twig', array(
            'caisseUser' => $caisseUser,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a caisseUser entity.
     *
     * @Route("/{id}", name="caisse_user_show")
     * @Method("GET")
     */
    public function showAction(CaisseUser $caisseUser)
    {
        $deleteForm = $this->createDeleteForm($caisseUser);

        return $this->render('@GOCaisse/caisse_user/show.html.twig', array(
            'caisseUser' => $caisseUser,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing caisseUser entity.
     *
     * @Route("/{id}/edit", name="caisse_user_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CaisseUser $caisseUser)
    {
        $deleteForm = $this->createDeleteForm($caisseUser);
        $editForm = $this->createForm('GO\CaisseBundle\Form\CaisseUserType', $caisseUser);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('caisse_user_edit', array('id' => $caisseUser->getId()));
        }

        return $this->render('@GOCaisse/caisse_user/edit.html.twig', array(
            'caisseUser' => $caisseUser,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a caisseUser entity.
     *
     * @Route("/{id}", name="caisse_user_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CaisseUser $caisseUser)
    {
        $form = $this->createDeleteForm($caisseUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($caisseUser);
            $em->flush();
        }

        return $this->redirectToRoute('caisse_user_index');
    }

    /**
     * Creates a form to delete a caisseUser entity.
     *
     * @param CaisseUser $caisseUser The caisseUser entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CaisseUser $caisseUser)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('caisse_user_delete', array('id' => $caisseUser->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
