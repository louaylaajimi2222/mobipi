<?php

namespace App\Controller;

use doctrine;
use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use App\Repository\CategorieRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ServiceController extends AbstractController
{
    #[Route('service', name: 'app_service')]
    public function index(ManagerRegistry $doctrine): Response
    {
        
        $repository=$doctrine->getRepository(Service::class);
       $service=$repository->findAll();
        return $this->render('service/magasin.html.twig', [
            'controller_name' => 'ServiceController','service' => $service,
        ]);
    }
    #[Route('/adds', name: 'app_ser')]
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

        return $this->render('service/ajouts.html.twig', [
            'controller_name' => 'ArticleController',
            'form' => $form->createView(),
        ]);
    }
    #[Route('/allbyc/{id}', name: 'allbycservice')]
    public function getAllByCategories($id, $type, ServiceRepository $produitRepository, ServiceRepository $serviceRepository, CategorieRepository $categorieRepository): Response
    {
        // On récupère la catégorie correspondante à l'id
        $categorie = $categorieRepository->find($id);
    
        // On récupère les produits ou les services liés à la catégorie en fonction du type
        
       if ($type == 'service') {
            $items = $serviceRepository->findBy(['categorie' => $categorie]);
        } else {
            throw new \Exception('Type invalide');
        }
    
        return $this->render('produit/list1.html.twig', [
            'items' => $items,
            'categorie' => $categorie,
            'type' => $type
        ]);
    }
    #[Route('/services', name: 'app_allserv')]
    public function index2(ManagerRegistry $doctrine): Response
    {
        
        $repository=$doctrine->getRepository(Service::class);
       $service=$repository->findAll();
        return $this->render('service/allservice.html.twig', [
            'controller_name' => 'ServiceController','service' => $service,
        ]);
    }
    



    #[Route('/allbycs/{id}', name: 'allby')]
    public function getallbycategorieserv($id, ServiceRepository $serviceRepository, CategorieRepository $categorieRepository): Response
    {
        // On récupère la catégorie correspondante à l'id
        $categorie = $categorieRepository->find($id);
    
        // On récupère les produits liés à la catégorie
        $service = $serviceRepository->findBy(['categorie' => $categorie]);
    
        return $this->render('service/allservice.html.twig', [
            'service' => $service,
            'categorie' => $categorie,
        ]);
    }    
}
