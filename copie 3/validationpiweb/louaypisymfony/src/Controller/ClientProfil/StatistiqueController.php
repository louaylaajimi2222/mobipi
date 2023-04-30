<?php

namespace App\Controller\ClientProfil;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/client')]
class StatistiqueController extends AbstractController
{
    #[Route('/statistique', name: 'stat')]
    public function index(): Response
    {
        return $this->render('Profil/statistique.html.twig');
    }
}