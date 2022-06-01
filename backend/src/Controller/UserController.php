<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    // Requete permetant de recuperer les donnees de l'utilisateur connecte
    #[Route('/user/me', name: 'me', methods: ['POST'])]
    public function me(ManagerRegistry $doctrine, Request $request, SerializerInterface $serializer, UserRepository $repository): Response
    {
        $entityManager = $doctrine->getManager();
        $data = json_decode($request->getContent());
        $user = $repository->findOneBy(['token'=> $data->token]);
        return new JsonResponse(json_decode($serializer->serialize($user, 'json', ['groups' => ['list']])));
    }
}
