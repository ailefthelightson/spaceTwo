<?php

namespace App\Controller;

use App\Entity\Trips;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $trips = $doctrine->getRepository(Trips::class)->findAll();

        return $this->render('index/index.html.twig', [
        "trips" => $trips      
      ]);
    }
    #[Route('details/{id}', name: 'app_index_details')]
    public function details(ManagerRegistry $doctrine, $id): Response
    {
        $trip = $doctrine->getRepository(Trips::class)->find($id);

        return $this->render('index/details.html.twig', [
        "trip" => $trip     
      ]);
    }
}
