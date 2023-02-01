<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\PostRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(ManagerRegistry $doctrine, PostRepository $postRepository): Response
    {
        $posts = $postRepository->findAll();

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'posts' => $posts
        ]);
    }

    #[Route('/not-allowed', name: 'app_not_allowed')]
    public function notAllowed(): Response
    {
        return $this->render('main/not_allowed.html.twig');
    }
}
