<?php

namespace App\Controller\ClientProfil;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/client')]
class ClientController extends AbstractController
{
    #[Route('/update', name: 'update_client')]
    public function index(): Response
    {
        return $this->render('profil/update.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
