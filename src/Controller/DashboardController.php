<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @IsGranted("IS_VALIDATED")
 */
class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(PostRepository  $r, Request $request, EntityManagerInterface $entityManager): Response
    {
        $posts = $r->findAll();
        $newPost = new Post;
        $form = $this->createForm(PostType::class, $newPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dd($request);
            $newPost = $form->getData();
            $newPost->setUser($this->getUser());

            $selectedCategory = $form->get('category')->getData();
            $newPost->setCategory($selectedCategory);

            $entityManager->persist($newPost);
            $entityManager->flush();

            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'posts'=> $posts,
            'form' => $form->createView()
        ]);
    }
}



    