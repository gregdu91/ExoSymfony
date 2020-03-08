<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use Symfony\Component\HttpFoundation\Request;

class UtilisateurController extends AbstractController
{
    /**
     * @Route("/", name="utilisateur")
     */
    

    public function index(Request $request)
    {
        //Connexion à la BDD
        $pdo = $this->getDoctrine()->getManager();

        $utilisateur = new Utilisateur();

        $form = $this->createForm(UtilisateurType::class, $utilisateur);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $pdo->persist($utilisateur);
            $pdo->flush();
        }

        $utilisateur = $pdo->getRepository(Utilisateur::class)->findAll();

        return $this->render('utilisateur/index.html.twig', [
            'utilisateurs' => $utilisateur,
            'form_ajout' => $form->createView(),
        ]);
    }

    /**
     * @Route("/utilisateur/{id}", name="un_utilisateur")
     */

    public function utilisateur(Utilisateur $utilisateur=null, Request $request){


    if($utilisateur != null){
                
        $form = $this->createForm(UtilisateurType::class, $utilisateur);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $pdo = $this->getDoctrine()->getManager();
            $pdo->persist($utilisateur);
            $pdo->flush();
        }

        return $this->render('utilisateur/index.html.twig', [
            'utilisateurs' => $utilisateur,
            'form_edit' => $form->createView(),
            
        ]);

        }
        else{
                
                return $this->redirectToRoute('utilisateur');

        }

    }


}
