<?php

namespace App\Controller;

use App\Entity\Categorie;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Produit;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository=$doctrine->getRepository( Produit::class);
        $repository=$doctrine->getRepository(Categorie::class);
       $categorie=$repository->findAll();
       $produit=$repository->findAll();
       $type=$repository->findAll();
   
    return $this->render('home.html.twig', [
        'controller_name' => 'CategorieController','categorie' => $categorie,
        'produit' =>$produit ,'type' =>$type,
    ]);
    }
    
}

    