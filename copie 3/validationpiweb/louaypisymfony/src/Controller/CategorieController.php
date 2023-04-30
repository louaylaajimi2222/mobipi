<?php

namespace App\Controller;


use COM;
use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\ProduitRepository;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'app_categorie')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository=$doctrine->getRepository(Categorie::class);
       $categorie=$repository->findAll();
    
        return $this->render('categorie/index.html.twig', [
            'categorie' => $categorie,
        ]);
    }
    #[Route('/addcat', name: 'app_cat')]
    public function ajoutcat(ManagerRegistry $doctrine, Request $request): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération de l'image
            $imageFile = $form->get('image')->getData();
    
            if ($imageFile) {
                // Génération d'un nom de fichier unique
                $newFilename = uniqid().'.'.$imageFile->guessExtension();
            
                // Déplacement du fichier dans le répertoire public/uploads/categorie
                $imageFile->move(
                    $this->getParameter('uploads_directory').'/categorie',
                    $newFilename
                );
            
                // Attribution du nom de fichier à la propriété "image" de l'entité
                $categorie->setImage('categorie/'.$newFilename);
            }
            
    
            $manager = $doctrine->getManager();
            $manager->persist($categorie);
            $manager->flush();
    
            return $this->redirectToRoute('app_categorie');
        }
    
        return $this->render('categorie/addcategorie.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/cat/delete/{id}', name: 'categorie.delete')]
    public function deleteCategorie(ManagerRegistry $doctrine, $id): Response
    {

        $repository = $doctrine->getRepository(Categorie::class);//recuperer les instances de la bd
        $categorie = $repository->find($id);//Cette ligne récupère l'instance de la classe Etudiant qui correspond à l'identifiant $id passé en paramètre.

        $manager = $doctrine->getManager();
        $manager->remove($categorie);//Cette ligne supprime l'instance de la classe Etudiant

        $manager->flush();
        $this->addFlash("error", "categorie a ete supprimer avec succes");
        return $this->redirectToRoute('app_categorie');
    }
    #[Route('/edit/{id}', name: 'categorie.edit')]
    public function edit(Categorie $categorie, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Check if the form is submitted and valid
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Update the Categorie entity with the form data
            $entityManager->persist($categorie);
            $entityManager->flush();
    
            // Redirect to the categorie index page
            return $this->redirectToRoute('app_categorie');
        }
    
        // Render the edit form template with the form instance
        return $this->render('categorie/editcat.html.twig', [
            'form' => $form->createView(),
            'categorie' => $categorie,
        ]);
    }
    
    #[Route('/all', name: 'app_all')]
    public function index1(ManagerRegistry $doctrine): Response
    {$repository = $doctrine->getRepository(Categorie::class);

        $repository=$doctrine->getRepository(Categorie::class);
        $categorie=$repository->findAll();
     
         return $this->render('categorie/allcategories.html.twig', [
             'categorie' => $categorie,
         ]);
    }
    #[Route('/acc', name: 'app_article')]
    public function acceuil(): Response
    {
        return $this->render('acceuil.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }
    

    #[Route('/homes', name: 'hm')]
    public function allcat(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Categorie::class);
        $categorie = $repository->findAll();
    
        dump($categorie); // Debug the "categorie" variable
    
        return $this->render('home.html.twig', [
            'categorie' => $categorie,
        ]);
    }
    #[Route('/acc', name: 'app_article')]
    public function acceuils(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Categorie::class);
        $categorie = $repository->findAll();
        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ArticleController',
            'categorie' => $categorie,
        ]);
    }
    
}
