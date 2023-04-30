<?php

namespace App\Controller\ClientProfil;

use App\Entity\Produit;
use App\Entity\Service;
use App\Entity\Categorie;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
#[Route('/client')]
class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository=$doctrine->getRepository(Categorie::class);
        $categorie=$repository->findAll();
        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController','categorie' => $categorie,
        ]);
    }
    #[Route('/article', name: 'article')]
    public function affiche(ManagerRegistry $doctrine): Response
    {
        $repository=$doctrine->getRepository(Categorie::class);
        $categorie=$repository->findAll();
        $repository=$doctrine->getRepository(Produit::class);
        $produit=$repository->findAll();
        $repository=$doctrine->getRepository(Service::class);
        $service=$repository->findAll();
        return $this->render('profil/article.html.twig', [
            'controller_name' => 'ProfilController','categorie' => $categorie,'service' => $service,'produit' => $produit
        ]);
    }
}

