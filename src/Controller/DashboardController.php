<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\PostType;
<<<<<<< Updated upstream
use App\Repository\GridSizeRepository;
use Doctrine\ORM\EntityManager;
=======
>>>>>>> Stashed changes
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
<<<<<<< Updated upstream
    public function index(PostRepository $r, Request $request, EntityManagerInterface $entityManager, GridSizeRepository $gsr): Response
=======
    public function index(PostRepository  $r, Request $request, EntityManagerInterface $entityManager): Response
>>>>>>> Stashed changes
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

            $defaultGridSize = $gsr->findOneBy([
                'grid_column' => 1,
                'grid_row' => 2
            ]);
            $newPost->setGridSize($defaultGridSize);

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



    