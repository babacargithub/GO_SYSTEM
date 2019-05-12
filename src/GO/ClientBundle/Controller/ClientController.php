<?php

namespace GO\ClientBundle\Controller;

use GO\ClientBundle\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GO\ClientBundle\Form as GOClientForm;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as FOSREST;


/**
 * Client controller.
 *
 * @Route("client")
 */
class ClientController extends Controller
{
    public function menuVerticalAction(Request $req)
    {
       $liste =array(
           array("libelle"=>"Nouveau Client", "id"=>"", "href"=>$this->generateUrl("client_new")),
           array("libelle"=>"Recherche Client", "id"=>"", "href"=>$this->generateUrl("client_search"))
           )
               ;
           
     
            
        return $this->render('_sidebar_design.html.twig', array("menu_vertical"=>$liste));
    }
    /**
     * Lists all client entities.
     *
     * @Route("/", name="crm_client_index")
     * @Route("/", name="client_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

       
        return $this->render('@GOClient/client/_main_layout.html.twig', array(
            
        ));
    }

    /**
     * Creates a new client entity.
     *
     * @Route("/new", name="client_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $client = new Client();
        $form = $this->createForm('GO\ClientBundle\Form\ClientType', $client);
        $client->setCreatedAt(new \DateTime());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($client);
            $em->flush();

            return $this->redirectToRoute('client_show', array('id' => $client->getId()));
        }

        return $this->render('@GOClient/client/new.html.twig', array(
            'client' => $client,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a client entity.
     *
     * @Route("/{id}", name="client_show")
     * @Method("GET")
     * @FOSREST\View()
     */
    public function showAction(Client $client)
    {
        $deleteForm = $this->createDeleteForm($client);
        
        return $this->render('@GOClient/client/show.html.twig', array(
            'client' => $client,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing client entity.
     *
     * @Route("/{id}/edit", name="client_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Client $client)
    {
        $deleteForm = $this->createDeleteForm($client);
        $editForm = $this->createForm('GO\ClientBundle\Form\ClientType', $client);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('client_edit', array('id' => $client->getId()));
        }

        return $this->render('@GOClient/client/edit.html.twig', array(
            'client' => $client,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a client entity.
     *
     * @Route("/{id}", name="client_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Client $client)
    {
        $form = $this->createDeleteForm($client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($client);
            $em->flush();
        }

        return $this->redirectToRoute('client_index');
    }

    /**
     * Creates a form to delete a client entity.
     *
     * @param Client $client The client entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Client $client)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('client_delete', array('id' => $client->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
     /**
     * 
     * @param Request $req
     * @Route("/search/", name="client_search")
     */
    public function searchAction(Request $req)
    {
        $data=[];
        $form= $this->createForm(GOClientForm\ClientSearchType::class, $data, ['action'=> $this->generateUrl('client_search')]);
        $form->handleRequest($req);
        if($form->isSubmitted()&&$form->isValid())
        {
            $data=$form->getData();
            $clientRepo=$this->getDoctrine()->getRepository("GOClientBundle:Client");
            $client=null;
            switch ($data['type_search'])
            {
               
                case GOClientForm\ClientSearchType::SEARCH_BY_FIRSTNAME:
                    $client= $clientRepo->findByFirstName($data['value']);
                     break;
                case GOClientForm\ClientSearchType::SEARCH_BY_LASTTNAME:
                 $client= $clientRepo->findByLastName($data['value']);
                    break;
                case GOClientForm\ClientSearchType::SEARCH_BY_TEL:
                    $client= $clientRepo->findByTel($data['value']);
                     break;
                case GOClientForm\ClientSearchType::SEARCH_BY_EMAIL:
                    $client= $clientRepo->findByEmail($data['value']);
                break;
                case GOClientForm\ClientSearchType::SEARCH_BY_SEXE:
                    $client= $clientRepo->findBySexe($data['value']);
                    break;
                case GOClientForm\ClientSearchType::SEARCH_BY_ADRESSE:
                     $client= $clientRepo->findByAdresse($data['value']);
                   break;
                case GOClientForm\ClientSearchType::SEARCH_BY_CATEGORIE:
                    break;
            }
            if(null!=$client)
            {
                if(count($client)==1)
                {
                return $this->redirectToRoute("client_show",['id'=>$client[0]->getId()]);
                }else
                return $this->render("@GOClient/client/liste.html.twig",['clients'=>$client]);
                
            }
            else
            {
                $form->get('value')->addError(new \Symfony\Component\Form\FormError("Aucun client trouvé"));
            }
        }
       return $this->render("@GOClient/client/search.html.twig", ["form"=>$form->createView()]);
    }
}
