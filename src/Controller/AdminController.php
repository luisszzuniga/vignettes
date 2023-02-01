<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



use App\Entity\User;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'page' => 'index'
        ]);
    }

    #[Route('/admin/users', name: 'app_admin_users')]
    public function users(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();

        return $this->render('admin/users.html.twig', [
            'users' => $users,
            'page' => 'users'
        ]);
    }

    #[Route('/admin/validate_user/{id}', name: 'app_admin_validate_users')]
    public function validateUser(UserRepository $userRepository, User $id) {
        $id->setValidated(true);
        $userRepository->save($id, true);
        return $this->redirectToRoute('app_admin_users');
    }
    
    #[Route('/admin/disabled_user/{id}', name: 'app_admin_disabled_users')]
    public function disabledUser(UserRepository $userRepository, User $id) {
        if($id->setValidated(true)) {
            $id->setValidated(false);
        }
        $userRepository->save($id, true);
        return $this->redirectToRoute('app_admin_users');
    }
}