<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Page;
use Symfony\Component\HttpFoundation\Request;

class PageController extends AbstractController
{
    /**
     * @Route("/page", name="page")
     */
     /**
     * @Route("/page/{id}", name="une_page")
     */

     public function index(Request $request)
    {
        //Connexion à la BDD
        $pdo = $this->getDoctrine()->getManager();

        $tache = new Tache();

        $form = $this->createForm(TacheType::class, $tache);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $pdo->persist($tache);
            $pdo->flush();
        }

        $tache = $pdo->getRepository(Tache::class)->findAll();

        return $this->render('tache/index.html.twig', [
            'taches' => $tache,
            'form_ajout' => $form->createView(),
        ]);
    }

    public function tache(Tache $tache=null, Request $request){


    if($tache != null){
                
        $form = $this->createForm(UtilisateurType::class, $tache);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $pdo = $this->getDoctrine()->getManager();
            $pdo->persist($tache);
            $pdo->flush();
        }

        return $this->render('page/index.html.twig', [
            'tache' => $tache,
            'form_edit' => $form->createView(),
            
            
        ]);

        }
        else{
                
                return $this->redirectToRoute('tache');

        }

    }

    public function __toString(){
        return $this->getUtilisateur();
    }
}
