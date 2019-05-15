<?php

namespace GO\ClientBundle\Controller;

use GO\ClientBundle\Entity\CompteClient;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GO\ClientBundle\Form as GOClientForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Compteclient controller.
 *
 * @Route("compte_client")
 */
class CompteClientController extends MainController
{
    
    public function menuVerticalAction(Request $req)
    {
       $liste =array(
           array("libelle"=>"Nouveau Compte", "id"=>"", "href"=>$this->generateUrl("compte_client_new")),
           array("libelle"=>"Liste des Comptes", "id"=>"", "href"=>$this->generateUrl("compte_client_index")),
           array("libelle"=>"Recherche Compte", "id"=>"", "href"=>$this->generateUrl("compte_client_search"))
           )
               ;
           
     
            
        return $this->render('_sidebar_design.html.twig', array("menu_vertical"=>$liste));
    }
    /**
     * Lists all compteClient entities.
     *
     * @Route("/", name="compte_client_index")
     * @Method("GET")
     */
    public function indexAction(Request $req)
    {
        $em = $this->getDoctrine()->getManager();

        $compteClients = $em->getRepository('GOClientBundle:CompteClient')->findAll();

        return $this->render('@GOClient/compte_client/index.html.twig', array(
            'compteClients' => $compteClients,
        ));
    }

    /**
     * Creates a new compteClient entity.
     *
     * @Route("/new", name="compte_client_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $compteClient = (new CompteClient())
        //$compteClient->setClient($this->getDoctrine()->getManager()->getRepository('GOClientBundle:Client')->find(1))
        ->setCreatedBy($this->getUser())
        ->setCreatedAt(new \DateTime());
        $form = $this->createForm('GO\ClientBundle\Form\CompteClientType', $compteClient);
        $form->handleRequest($request);
        $formView=$form->createView();
        if ($form->isSubmitted() && $form->isValid()) {
            $compteClient->generateAccountNumber();
            $em = $this->getDoctrine()->getManager();
            $em->persist($compteClient);
            $em->flush();

            return $this->redirectToRoute('compte_client_show', array('id' => $compteClient->getId()));
        }/* else {
             return $this->render('@GOClient/compte_client/new.html.twig', array(
           
            'form' =>$form
        ));
        }*/

        return $this->render('@GOClient/compte_client/new.html.twig', array(
            'compteClient' => $compteClient,
            'form' => $form,
        ));
    }

    /**
     * Finds and displays a compteClient entity.
     *
     * @Route("/{id}", name="compte_client_show")
     * @Method("GET")
     */
    public function showAction(CompteClient $compteClient)
    {
        $deleteForm = $this->createDeleteForm($compteClient);

        return $this->render('@GOClient/compte_client/show.html.twig', array(
            'compteClient' => $compteClient,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing compteClient entity.
     *
     * @Route("/{id}/edit", name="compte_client_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CompteClient $compteClient)
    {
        $deleteForm = $this->createDeleteForm($compteClient);
        $editForm = $this->createForm('GO\ClientBundle\Form\CompteClientType', $compteClient);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('compte_client_edit', array('id' => $compteClient->getId()));
        }

        return $this->render('@GOClient/compte_client/edit.html.twig', array(
            'compteClient' => $compteClient,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a compteClient entity.
     *
     * @Route("/{id}", name="compte_client_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CompteClient $compteClient)
    {
        $form = $this->createDeleteForm($compteClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($compteClient);
            $em->flush();
        }

        return $this->redirectToRoute('compte_client_index');
    }

    /**
     * Creates a form to delete a compteClient entity.
     *
     * @param CompteClient $compteClient The compteClient entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CompteClient $compteClient)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('compte_client_delete', array('id' => $compteClient->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    /**
     * 
     * @param Request $req
     * @Route("compte_client/search", name="compte_client_search")
     */
    public function searchAction(Request $req)
    {
        $data=[];
        $form= $this->createForm(GOClientForm\CompteClientSearchType::class, $data, ['action'=> $this->generateUrl('compte_client_search')]);
        $form->handleRequest($req);
        if($form->isSubmitted()&&$form->isValid())
        {
            $data=$form->getData();
            $compte= $this->getDoctrine()->getRepository("GOClientBundle:CompteClient")->findOneByNumber($data['value']);
            if(null!=$compte)
            {
                return $this->redirectToRoute("compte_client_show",['id'=>$compte->getId()]);
            }
            else
            {
                $form->get('value')->addError(new \Symfony\Component\Form\FormError("Aucun compte trouvé"));
            }
        }
       return $this->render("@GOClient/compte_client/search.html.twig", ["form"=>$form->createView()]);
    }
    /**
     * 
     * @param Request $req
     * @param type $tel
     * @Route("/details/client/{tel}", name="get_details_by_client_tel", options={"expose"=true})
     */
    public function getDetailsByClientTel(Request $req, $tel)
    {
       if(null==$client= $this->getDoctrine()->getManager()->getRepository("GOClientBundle:Client")->findOneByTel($tel))
       {
           return new Response('Client non trouvé');
       }
        if(null==$compte= $this->getDoctrine()->getManager()->getRepository("GOClientBundle:CompteClient")->findOneByClient($client->getId()))
        {
            return new Response('Compte Client non trouvé');
        }
        
           return $this->render("@GOClient/layout.html.twig",['compte'=>$compte]);  
        
       
    }
}
