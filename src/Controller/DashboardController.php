<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\PostType;
use Doctrine\ORM\EntityManager;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @IsGranted("IS_VALIDATED")
 */
class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(PostRepository $r, Request $request, EntityManagerInterface $entityManager): Response
    {
        $posts = $r->findBy([
            'user' => $this->getUser()
        ]);
        $newPost = new Post;
        $form = $this->createForm(PostType::class, $newPost, ['update' => false]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newPost = $form->getData();
            $newPost->setUser($this->getUser());

            $upload = $form->get('imageFile')->getData();
            $newImageName = uniqid() . '.' . $upload->guessExtension();
            $upload->move('images/posts', $newImageName);
            $newPost->setImageUrl('images/posts/' . $newImageName);

            $selectedCategory = $form->get('category')->getData();
            $newPost->setCategory($selectedCategory);

            $entityManager->persist($newPost);
            $entityManager->flush();

            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('dashboard/index.html.twig', [
            'posts'=> $posts,
            'form' => $form->createView()
        ]);
    }

    #[Route('/dashboard/edit/{id}', name: 'app_dashboard_edit_post')]
    public function editPost(int $id, Request $request, PostRepository $r, EntityManagerInterface $entityManager, ParameterBagInterface $params)
    {
        $post = $r->find($id);

        if (!$post || $post->getUser()->getId() !== $this->getUser()->getId()) {
            return $this->redirectToRoute('app_dashboard');
        }

        $form = $this->createForm(PostType::class, $post, ['update' => true, 'category' => $post->getCategory()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();

            if ($form->get('imageFile')->getData()) {
                // On supprime l'ancienne image
                $oldImage = $params->get('kernel.project_dir') . '\public\\' . $post->getImageUrl();
                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }

                // On ajoute la nouvelle
                $upload = $form->get('imageFile')->getData();
                $newImageName = uniqid() . '.' . $upload->guessExtension();
                $upload->move('images/posts', $newImageName);
                $post->setImageUrl('images/posts/' . $newImageName);
            }

            $selectedCategory = $form->get('category')->getData();
            $post->setCategory($selectedCategory);

            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('dashboard/edit.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/dashboard/delete_post/{id}', name: 'app_dashboard_delete_post')]
    public function deletePost(int $postId, PostRepository $r)
    {
        $r->delete($postId);
    }
}



    