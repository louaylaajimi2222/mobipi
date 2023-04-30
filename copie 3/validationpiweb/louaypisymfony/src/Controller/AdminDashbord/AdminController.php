<?php

namespace App\Controller\AdminDashbord;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/profil', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }
    #[Route('/dashbord1', name: 'app_dash1')]
    public function index1(UserRepository $repo): Response
    {  
        $list=$repo->findAllWithoutAdmin();

        
        return $this->render('admin/dashbord1.html.twig', [ 'list' => $list ] );
    }

   
}
