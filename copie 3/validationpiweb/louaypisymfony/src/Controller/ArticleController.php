<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Produit;
use App\Entity\Service;
use App\Form\ProduitType;
use App\Form\ServiceType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    private $registry;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    #[Route('/articlec', name: 'app')]
    public function index2(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Article::class);
        $articles = $repository->findAll();

        return $this->render('crud.html.twig', [
            'controller_name' => 'ArticleController',
            'article' => $articles,
        ]);
    }

    #[Route('/addp', name: 'app_ser')]
    public function ajoutp(Request $request, ManagerRegistry $doctrine): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les données du formulaire
            $produit = $form->getData();

            // Sauvegarder le produit en base de données
           
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                // Génération d'un nom de fichier unique
                $newFilename = uniqid().'.'.$imageFile->guessExtension();
    
                // Déplacement du fichier dans le répertoire public/uploads
                $imageFile->move(
                    $this->getParameter('uploads_directory'),
                    $newFilename
                );
    
                // Attribution du nom de fichier à la propriété "image" de l'entité
                $produit->setImage($newFilename);
            }
            $entityManager = $doctrine->getManager();
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('app');
        }

        return $this->render('ajoutp.html.twig', [
            'controller_name' => 'ArticleController',
            'form' => $form->createView(),
        ]);
    } #[Route('/adds', name: 'app_ser')]
    public function ajouts(Request $request, ManagerRegistry $doctrine): Response
    {
        $service= new Service();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les données du formulaire
            $service = $form->getData();

            // Sauvegarder le produit en base de données
           
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                // Génération d'un nom de fichier unique
                $newFilename = uniqid().'.'.$imageFile->guessExtension();
    
                // Déplacement du fichier dans le répertoire public/uploads
                $imageFile->move(
                    $this->getParameter('uploads_directory'),
                    $newFilename
                );
    
                // Attribution du nom de fichier à la propriété "image" de l'entité
                $service->setImage($newFilename);
            }
            $entityManager = $doctrine->getManager();
            $entityManager->persist($service);
            $entityManager->flush();

            return $this->redirectToRoute('app_ser');
        }

        return $this->render('ajouts.html.twig', [
            'controller_name' => 'ArticleController',
            'form' => $form->createView(),
        ]);
    }
}
