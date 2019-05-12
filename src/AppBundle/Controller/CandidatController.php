<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Candidat;
use AppBundle\Entity\Dossier;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security as Secure;
use Symfony\Component\HttpFoundation\Request;

/**
 * Candidat controller.
 *
 * @Route("candidat")
 */
class CandidatController extends Controller
{
    public function menuVerticalAction()
    {
        $menus=array(
            array("href"=> $this->generateUrl("candidat_new"), "libelle"=>"Ajouter Nouveau"),
            array("href"=> $this->generateUrl("candidat_listes"), "libelle"=>"Listes des Candidats"),
            array("href"=> $this->generateUrl("candidat_searche"), "libelle"=>"Recherche"),
        );
        return $this->render('@App/candidat/menu_vertical.html.twig', array("menus"=>$menus));
    }
    /**
     * Lists all candidat entities.
     *
     * @Route("/", name="candidat_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $candidats = $em->getRepository('AppBundle:Candidat')->findAll();

        return $this->render('@App/candidat/index.html.twig', array(
            'candidats' => $candidats,
        ));
    }
    /**
     * Lists all candidat entities.
     *
     * @Route("/show_all", name="candidat_listes")
     * @Method("GET")
     * @Secure("has_role('ROLE_CONS_CLIENT')")
     */
    public function listeAction()
    {
        $em = $this->getDoctrine()->getManager();

        $candidats = $em->getRepository('AppBundle:Candidat')->findAll();

        return $this->render('@App/candidat/index.html.twig', array(
            'candidats' => $candidats,
        ));
    }

    /**
     * Creates a new candidat entity.
     *
     * @Route("/new", name="candidat_new")
     * @Method({"GET", "POST"})
     * @Secure("has_role('ROLE_GP')")
     * 
     */
    public function newAction(Request $request)
    {
        $candidat = new Candidat();
        
        $form = $this->createForm('AppBundle\Form\CandidatType', $candidat);
         $candidat->setUser($this->getUser());
         $form->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($candidat);
          $em->flush(); 
            /*$dossier=new Dossier();
            $dossier->setCandidat($candidat);
            $dossier->generateNum();
            $currentExercice= $this->getDoctrine()->getManager()->getRepository('AppBundle:Exercice')->find(1);
            $dossier->setExercice($currentExercice);
            $em->persist($dossier);
            $em->flush();  */     

            return $this->redirectToRoute('dossier_new', array('id' => $candidat->getId()));
        }

        return $this->render('@App/candidat/new.html.twig', array(
            'candidat' => $candidat,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a candidat entity.
     *
     * @Route("/{id}", name="candidat_show")
     * @Method("GET")
     * @Secure("has_role('ROLE_GP')")
     */
    public function showAction(Candidat $candidat)
    {
        $deleteForm = $this->createDeleteForm($candidat);

        return $this->render('@App/candidat/show.html.twig', array(
            'candidat' => $candidat,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing candidat entity.
     *
     * @Route("/{id}/edit", name="candidat_edit")
     * @Method({"GET", "POST"})
     * @Secure("has_role('ROLE_DIR_AG')")
     */
    public function editAction(Request $request, Candidat $candidat)
    {
        $deleteForm = $this->createDeleteForm($candidat);
        $editForm = $this->createForm('AppBundle\Form\CandidatType', $candidat);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('candidat_edit', array('id' => $candidat->getId()));
        }

        return $this->render('@App/candidat/edit.html.twig', array(
            'candidat' => $candidat,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a candidat entity.
     *
     * @Route("/delete/{id}", name="candidat_delete")
     * @Secure("has_role('ROLE_DIR_AG')")
     */
    public function deleteAction(Request $request, Candidat $candidat)
    {
        
   $em = $this->getDoctrine()->getManager();
   //removes all child entities referring to this entity 
   foreach($candidat->getDossier()->getCandidatures() as $candidature)
   {
            $em->remove($candidature);
   }
            $em->remove($candidat->getDossier());
            $em->remove($candidat);
            $em->flush();
        
        return $this->redirectToRoute('candidat_listes');
    }
    /**
     * Deletes a candidat entity.
     *
     * @Route("/recherche", name="candidat_searche")
     @Secure("has_role('ROLE_GP')")
     */
    
    public function searchAction(Request $request, Candidat $candidat)
    {
      
     return $this->redirectToRoute('candidat_index');
    }

    /**
     * Creates a form to delete a candidat entity.
     *
     * @param Candidat $candidat The candidat entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Candidat $candidat)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('candidat_delete', array('id' => $candidat->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
