<?php

namespace App\Controller;

use App\Entity\AnnonceListByUser;
use App\Entity\Computer;
use App\Form\ComputerType;
use App\Repository\AnnonceListByUserRepository;
use App\Repository\ComputerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/computer')]
class ComputerController extends AbstractController
{
    #[Route('/', name: 'app_computer_index', methods: ['GET'])]
    public function index(ComputerRepository $computerRepository): Response
    {
        return $this->render('computer/index.html.twig', [
            'computers' => $computerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_computer_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ComputerRepository $computerRepository): Response
    {
        $author = $this->getUser();
        $computer = new Computer();
        $form = $this->createForm(ComputerType::class, $computer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lettres = range('A', 'Z');
            shuffle($lettres);
            $lettre = array_shift($lettres);
            shuffle($lettres);
            $lettre .= array_shift($lettres);
            shuffle($lettres);
            $lettre .= array_shift($lettres);
            $nombre = mt_rand(10, 99);

            $serialNumber = $lettre.$nombre;
            $computer->setSerialNumber($serialNumber);
            $computer->setAuthor($author);
            $computer->setIsVisible(true);
            $computerRepository->save($computer, true);
            return $this->redirectToRoute('app_computer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('computer/new.html.twig', [
            'computer' => $computer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_computer_show', methods: ['GET'])]
    public function show(Computer $computer): Response
    {
        return $this->render('computer/show.html.twig', [
            'computer' => $computer,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_computer_edit', methods: ['GET', 'POST'])]
    public function edit($id, Request $request, Computer $computer, ComputerRepository $computerRepository): Response
    {
        $thisComputer = $computerRepository->find($id);
        $form = $this->createForm(ComputerType::class, $computer);
        $form->handleRequest($request);

        if ($thisComputer->getisVisible() == false) {
            $this->addFlash('Erreur', 'Cet ordinateur n\'existe plus');
            return $this->redirectToRoute('home');
        }
        $form = $this->createForm(ComputerType::class, $computer);
        $form->handleRequest($request);
        $author = $this->getUser();
        if ($author == false) {
            $this->addFlash('Erreur', 'Vous devez avoir un compte pour ajouter un ordinateur');
            return $this->redirectToRoute('home');
        }

        if ($this->container->get('security.authorization_checker')->IsGranted('ROLE_ADMIN') or $computer->getAuthor() == $author) {
            if ($form->isSubmitted() && $form->isValid()) {

                $computerRepository->save($computer, true);
                $this->addFlash('Succès', 'Votre ordinateur a bien été modifié');
                return $this->redirectToRoute('app_computer_index', [], Response::HTTP_SEE_OTHER);
            }
            return $this->renderForm('computer/edit.html.twig', [
                'computer' => $computer,
                'form' => $form,
            ]);
        }
        $this->addFlash('Erreur', 'Vous devez avoir un compte pour ajouter/éditer un ordinateur');
        return $this->redirectToRoute('home');
    }

    #[Route('/{id}', name: 'app_computer_delete', methods: ['POST'])]
    public function delete(Request $request, Computer $computer, ComputerRepository $computerRepository): Response
    {
        $author = $this->getUser();
        if ($author == false) {
            $this->addFlash('Erreur', 'Vous devez avoir un compte pour supprimer un ordinateur');
            return $this->redirectToRoute('home');
        }
        if ($this->container->get('security.authorization_checker')->IsGranted('ROLE_ADMIN') or $computer->getAuthor() == $author) {
            $computer->setIsVisible(false);
            $computerRepository->save($computer);
            $this->addFlash('Succès', 'Votre événement a bien été supprimé !');
        } else {
            $this->addFlash('Erreur', 'Vous n\'êtes pas l\'auteur de cet ordinateur !');
            return $this->redirectToRoute('app_computer_show', ['id' => $computer->getId()]);
        }
        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/fav', name: 'app_computer_fav', methods: ['POST', 'GET'])]
    public function favUserComputer(Computer $computer, AnnonceListByUserRepository $annonceByUserRepo)
    {
        $user = $this->getUser(); 
        if (!$user) return $this->redirectToRoute('app_login');

        if ($computer->isUserfav($user)) {  
            $signedUp = $annonceByUserRepo->findOneBy([
                'annonces' => $computer,
                'users' => $user
            ]);
            $annonceByUserRepo->remove($signedUp); 
            $this->addFlash('Erreur', "Cette annonce n'est plus dans vos favoris");
            return $this->redirectToRoute('home');
        }

        $newFav = new AnnonceListByUser(); 
        $newFav->setComputers($computer)->setUsers($user);

        $annonceByUserRepo->save($newFav);
        $this->addFlash('Succès', "Cette annonce est désormais dans vos favoris");
        return $this->redirectToRoute('home');
    }
}
