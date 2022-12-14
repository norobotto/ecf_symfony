<?php

namespace App\Controller;

use App\Repository\AnnonceListByUserRepository;
use App\Repository\ComputerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function index(ComputerRepository $computerRepository, AnnonceListByUserRepository $annonceByUserRepo): Response
    {
        $author = $this->getUser();
        return $this->render('profil/index.html.twig', [
            'computers' => $computerRepository->findBy([
                'author' => $author,
            ]),
            'computersFav' => $annonceByUserRepo->findBy([
                'users' => $author
            ]),
        ]);
    }
}
