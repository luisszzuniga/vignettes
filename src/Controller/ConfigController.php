<?php

namespace App\Controller;

use App\Entity\Config;
use App\Form\ConfigType;
use App\Repository\ConfigRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ConfigController extends AbstractController
{
    #[Route('/admin/config', name: 'app_admin_config')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $config = new Config();
        $form = $this->createForm(ConfigType::class, $config);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $config = $form->getData();
            $entityManager->persist($config);
            $entityManager->flush();
            
            return $this->redirectToRoute('app_admin_config');
        }
        return $this->render('admin/config.html.twig', [
            'form' => $form,
            'page' => 'index'
        ]);
        
    }
}