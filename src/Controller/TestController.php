<?php

namespace App\Controller;

use App\Entity\Test;
use App\Entity\Trips;
use App\Form\newTrip;
use App\Form\TestType;
use App\Repository\TestRepository;
use App\Repository\TripsRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class TestController extends AbstractController
{
    #[Route('/', name: 'app_test_index', methods: ['GET'])]
    public function index(TestRepository $testRepository): Response
    {
        return $this->render('test/index.html.twig', [
            'tests' => $testRepository->findAll(),
        ]);
    }
    #[Route('/alltrips', name: 'app_test_index_alltrips', methods: ['GET'])]
    public function allTrips(TripsRepository $tripsRepository, UserRepository $userRepository): Response
    {
        return $this->render('test/alltrips.html.twig', [
            
            'trips' => $tripsRepository->findAll(),
            'users' => $userRepository->findAll()
          
        ]);
    }
    #[Route('/createTrip', name: 'app_test_index_createtrips', methods: ['GET'])]
    public function createTrips(ManagerRegistry $doctrine, Request $request ): Response
    {
        $createTrips = new Trips();

        $form = $this->createForm(newTrip::class, $createTrips);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $createTrips = $form->getData();

            return $this->redirectToRoute('/admin');
        }
        return $this->render('newTrip.html.twig', [
            
            'form' => $form,
        ]);            
            
    
    }

    #[Route('/new', name: 'app_test_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TestRepository $testRepository): Response
    {
        $test = new Test();
        $form = $this->createForm(TestType::class, $test);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $testRepository->save($test, true);

            return $this->redirectToRoute('app_test_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('test/new.html.twig', [
            'test' => $test,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_test_show', methods: ['GET'])]
    public function show(Test $test): Response
    {
        return $this->render('test/show.html.twig', [
            'test' => $test,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_test_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Test $test, TestRepository $testRepository): Response
    {
        $form = $this->createForm(TestType::class, $test);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $testRepository->save($test, true);

            return $this->redirectToRoute('app_test_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('test/edit.html.twig', [
            'test' => $test,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_test_delete', methods: ['POST'])]
    public function delete(Request $request, Test $test, TestRepository $testRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$test->getId(), $request->request->get('_token'))) {
            $testRepository->remove($test, true);
        }

        return $this->redirectToRoute('app_test_index', [], Response::HTTP_SEE_OTHER);
    }
}
