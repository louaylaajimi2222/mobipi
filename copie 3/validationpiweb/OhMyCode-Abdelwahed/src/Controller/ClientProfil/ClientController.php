<?php

namespace App\Controller\ClientProfil;


use App\Entity\User;
use App\Form\UpdateType;
use App\Entity\Categorie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Vich\UploaderBundle\Handler\UploadHandler;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
#[Route('/client')]
class ClientController extends AbstractController
{
    #[Route('/update/{id}', name: 'update_client')]
    public function update (Request $request ,UserPasswordHasherInterface $userPasswordHasher,User $user , EntityManagerInterface $entityManager,ManagerRegistry $doctrine): Response
    {
       
        $form = $this->createForm(UpdateType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $photo = $form->get('photo')->getData();
                // encode the plain password
                if ($photo) {
                    $photoName = uniqid().'.'.$photo->guessExtension();
                    $photo->move(
                        $this->getParameter('photos_directory'),
                        $photoName
                    );
                    $user->setPhoto($photoName);
                }
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
                
                $entityManager->flush();
                // do anything else you need here, like send an email

               
        $repository=$doctrine->getRepository(Categorie::class);
        $categorie=$repository->findAll();
            }
            return $this->render('profil/update.html.twig', [
                'registrationForm' => $form->createView(),'categorie' => $categorie,
             
            ]);
        }
       
    
}
