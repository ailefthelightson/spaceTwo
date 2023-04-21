<?php

namespace App\Controller;

use App\Entity\Trips;
use App\Entity\User;
use Doctrine\ORM\Mapping\Id;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserAccessController extends AbstractController
{
    #[Route('/', name: 'app_user_access')]
    public function index(ManagerRegistry $doctrine): Response
    {

        $trips = $doctrine->getRepository(Trips::class)->findAll();
        // dd($trips);
        return $this->render('user_access/index.html.twig', [
            "trips" => $trips
        ]);
    }

        #[Route('/tripdetails/{id}', name: 'app_user_access_details', methods:["GET"])]
        public function details(ManagerRegistry $doctrine, $id): Response
        {
    
        $trips = $doctrine->getRepository(Trips::class)->find($id);
        // dd($id);
        return $this->render('user_access/details.html.twig', [
            "trips" => $trips
        ]);
    }


}
