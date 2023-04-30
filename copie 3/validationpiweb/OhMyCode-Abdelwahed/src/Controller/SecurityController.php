<?php

namespace App\Controller;

use Swift_Mailer;
use App\Entity\User;
use App\Entity\Categorie;
use App\Form\ForgetPasswordType;
use Doctrine\Common\Lexer\Token;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\LoginLink\LoginLinkHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\LoginLink\LoginLinkHandlerInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class SecurityController extends AbstractController
{
    #[Route('/security', name: 'app_security')]
    public function index(): Response
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils,ManagerRegistry $doctrine): Response
    {
    $repository=$doctrine->getRepository(Categorie::class);
        $categorie=$repository->findAll();
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error, 'categorie' => $categorie,]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        return $this->redirectToRoute("app_login");
    }


    #[Route(path: '/forget', name: 'app_forget')]
    public function forgetPassword(Request $req, UserRepository $repo, MailerInterface $mailer, TokenGeneratorInterface $tokenGenerator, EntityManagerInterface $em)
    {

        $form = $this->createForm(ForgetPasswordType::class);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->getData();


            $user = $repo->findOneBy(['email' => $email]);
            if (!$user) {
                $this->addFlash('danger', 'cette email  n\'existe pas');
                return $this->redirectToRoute("app_login");
            }

            $token = $tokenGenerator->generateToken();

            try {
                $user->setResetToken($token);
                $em->persist($user);
                $em->flush();

              
            } catch (\Exception  $excep) {
                $this->addFlash('warning', $excep->getMessage());
                return $this->redirectToRoute("app_login");
            }
            // $url = $this->generateUrl('app_reset', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);
               $url='message';
            $email = (new Email())
            ->from('abdousouid007@gmail.com')
            ->to( $user ->getEmail() )
            ->subject(' Subject'.$url)
            ->text(' message')
            ->html('<p>Example message</p>');
                $mailer->send($email);
                
                $this->addFlash('message', 'Email de reinitialization envoyé avec succée !! ');
        }
        return $this->render("security/forget.html.twig",['form'=>$form->createView()]);
    }
    #[Route(path: '/reset', name: 'app_reset')]
    public function reset()
    {

    }
}
