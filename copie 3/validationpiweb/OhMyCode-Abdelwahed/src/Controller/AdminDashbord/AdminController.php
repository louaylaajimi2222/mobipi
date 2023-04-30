<?php

namespace App\Controller\AdminDashbord;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\DeblockageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

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
    #[Route('/block/{id}', name: 'block_user')]
    public function  block(Request $request  , EntityManagerInterface $entityManager,UserRepository $repo,int $id)
    {
        $user = $repo->find($id);
    if (!$user) {
        throw $this->createNotFoundException('User not found');
    }
        // $minutes = $request->request->get('minutes');
       

        //  $now = new \DateTime();
        //  $blockDuration = new \DateInterval('PT' . $minutes . 'M');
        // $deblockDate = $now->add($blockDuration);
        
        $user->setIsBlock(1);
        // $user->setDateDeblockage($deblockDate);
       
        $entityManager->flush();
        $this->addFlash('success', 'User has been blocked successfully.');
         return $this->redirectToRoute('app_admin');
        }
        #[Route('/deblock/{id}', name: 'deblock_client')]
    public function  deblock(Request $request ,int $id , EntityManagerInterface $entityManager,UserRepository $repo)
    {
       
        $user = $repo->find($id);
        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }
                 $user->setIsBlock(0);
                   
                $entityManager->flush();
               
               return $this ->redirectToRoute('') ;
               $this->addFlash('success', 'User has been locked successfully');
          
          
          
        }
       
   
}
