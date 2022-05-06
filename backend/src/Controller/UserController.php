<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Entity\User;
use Doctrine\Persistence\ManagerRegistry;

class UserController extends AbstractController
{
    #[Route('/user', name: 'create_user', methods: ['POST'])]
    public function createUser(ManagerRegistry $doctrine, Request $request): Response
    {
        $entityManager = $doctrine->getManager();

        $data = json_decode($request->getContent());
        
        $user = new User();
        $user->setUsername($data->username);
        $user->setPassword($data->password);

        $entityManager->persist($user);
        $entityManager->flush();

        return new Response(json_encode($user));
    }
}
