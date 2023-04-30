<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Categorie;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository=$doctrine->getRepository(Categorie::class);
       $categorie=$repository->findAll();
       $repository=$doctrine->getRepository(Produit::class);
       $produit=$repository->findAll();
        return $this->render('Home/index.html.twig', [
            'categorie' => $categorie,'produit' => $produit
        ]);
    }
}