<?php

namespace App\Controller;

use doctrine;
use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use App\Repository\CategorieRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitController extends AbstractController
{
    private $registry;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }
    
    #[Route('/produit', name: 'app_service')]
    public function index(ManagerRegistry $doctrine): Response
    {
        
        $repository=$doctrine->getRepository(Produit::class);
       $produit=$repository->findAll();
        return $this->render('produit/index.html.twig', [
            'controller_name' => 'ProduitController','produit' => $produit,
        ]);
    }

    #[Route('/articlec', name: 'app')]
    public function index2(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Produit::class);
        $articles = $repository->findAll();

        return $this->render('crud.html.twig', [
            'controller_name' => 'ArticleController',
            'article' => $articles,
        ]);
    }

    #[Route('/addp', name: 'app_prod')]
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

        return $this->render('produit/ajoutp.html.twig', [
            'controller_name' => 'ArticleController',
            'form' => $form->createView(),
        ]);
    } 

    #[Route('/mag', name: 'app')]
    public function magasin(ManagerRegistry $doctrine): Response
    {
        
        $repository=$doctrine->getRepository(Produit::class);
        $produit=$repository->findAll();
         return $this->render('produit/magasin.html.twig', [
             'controller_name' => 'ProduitController','produit' => $produit,
         ]);
    }

    #[Route('/prod/delete/{id}', name: 'produit.delete')]
    public function deleteproduit(ManagerRegistry $doctrine, $id): Response
    {

        $repository = $doctrine->getRepository(Produit::class);//recuperer les instances de la bd
        $produit = $repository->find($id);//Cette ligne récupère l'instance de la classe Etudiant qui correspond à l'identifiant $id passé en paramètre.

        $manager = $doctrine->getManager();
        $manager->remove($produit);//Cette ligne supprime l'instance de la classe Etudiant

        $manager->flush();
        $this->addFlash("error", "categorie a ete supprimer avec succes");
        return $this->redirectToRoute('app_prod');
    }
   #[Route('/allbyc/{id}', name: 'allbyc')]
    public function getallbycategorie($id, ProduitRepository $productRepository, CategorieRepository $categorieRepository): Response
    {
        // On récupère la catégorie correspondante à l'id
        $categorie = $categorieRepository->find($id);
    
        // On récupère les produits liés à la catégorie
        $produit = $productRepository->findBy(['categorie' => $categorie]);
    
        return $this->render('produit/list.html.twig', [
            'produit' => $produit,
            'categorie' => $categorie,
        ]);
    }
    #[Route('/allbycs/{id}', name: 'allbycs')]
    public function getallbycategories($id, ProduitRepository $productRepository, CategorieRepository $categorieRepository): Response
    {
        // On récupère la catégorie correspondante à l'id
        $categorie = $categorieRepository->find($id);
    
        // On récupère les produits liés à la catégorie
        $produit = $productRepository->findBy(['categorie' => $categorie]);
    
        return $this->render('produit/list.html.twig', [
            'produit' => $produit,
            'categorie' => $categorie,
        ]);
    }
    #[Route('/details', name: 'details')]
    public function details(ManagerRegistry $doctrine): Response
    {
       
        $repository=$doctrine->getRepository(Produit::class);
       $produit=$repository->findAll();
        return $this->render('produit/detailsp.html.twig', [
            'controller_name' => 'ProduitController','produit' => $produit,
        ]);
    }
    
    
}
