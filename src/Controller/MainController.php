<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Repository\BrandRepository;
use App\Repository\ComputerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ComputerRepository $computerRepository, BrandRepository $brandRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'computers' => $computerRepository->findAll(),
            'brands' => $brandRepository->findAll(),
        ]);
    }

    #[Route('/tab/{id}', name: 'tab', methods: ['GET'])]
    public function tab(Brand $brand, ComputerRepository $computerRepository, BrandRepository $brandRepository): Response
    {
        return $this->render('main/tab.html.twig', [
            'marq' => $brand,
            'computers' => $computerRepository->findAll(),
            'brands' => $brandRepository->findAll(),
        ]);
    }
}
