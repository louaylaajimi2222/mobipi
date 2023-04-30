<?php

namespace App\Controller;

use App\Entity\Categorie;
use doctrine;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Produit;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use App\Repository\ReseventRepository;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
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
        $repository=$doctrine->getRepository(Categorie::class);
        $categorie=$repository->findAll();
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
            'controller_name' => 'ArticleController','categorie' => $categorie,
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
    #[Route('/statistique', name: 'stats', methods: ['GET','POST'])]
    public function stat(EntityManagerInterface $entityManager,Request $request): Response  
    {
        
        $repository = $this->getDoctrine()->getRepository(Service::class);
        $services = $entityManager
            ->getRepository(Service::class)
            ->findAll();

        $em = $this->getDoctrine()->getManager();


        $pr1 = 0;
        $pr2 = 0;


        foreach ($services as $service) {
            if ($service->getNiveau() == "debutant") {
                $pr1 += 1;
            } else if ($service->getNiveau() == "expert") {
                $pr2 += 1;
            }
        }
        

        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            [   ['niveau', 'Nom'],
                [' expert', $pr1],
                ['debutant', $pr2],
               
            ]
        );
        $pieChart->getOptions()->setTitle('statistique a partir des prix');
        $pieChart->getOptions()->setHeight(1000);
        $pieChart->getOptions()->setWidth(1400);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('green');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(30);

       

        return $this->render('produit/stat.html.twig', array('piechart' => $pieChart));
    }
    #[Route('/servicpdf', name: 'app_pdf')]
    public function pdf(ServiceRepository $serviceRepository,ManagerRegistry $doctrine): Response
    {
        $repository=$doctrine->getRepository(Service::class);
        $service=$repository->findAll();
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        $dompdf = new Dompdf($pdfOptions);
        $html = $this->renderView('service/pdf.html.twig', [
            'resevent' => $serviceRepository->findAll(),'service' => $service,
        ]);
        
        
        $dompdf->loadHtml($html);
        
        $dompdf->setPaper('A4', 'portrait');
        
       
        $dompdf->render();
      
        
        $output = $dompdf->output();
        return new Response($output, 200, [
            'Content-Type' => 'application/pdf'
        ]);
    }
    #[Route('/serviced', name: 'app_service')]
    public function index3(ManagerRegistry $doctrine): Response
    { $repository=$doctrine->getRepository(Categorie::class);
        $categorie=$repository->findAll();
        $repository=$doctrine->getRepository(Service::class);
        $service=$repository->findAll();
       
        return $this->render('service/allservice.html.twig', [
            'controller_name' => 'ServiceController','categorie' => $categorie,'service' => $service,
        ]);
    }
    
}

    
    
    
   




      
      
      


// allservices.html.twig