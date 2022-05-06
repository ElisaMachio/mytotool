<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;

use SecurityLib\Strength;
use RandomLib\Factory;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;

class AuthController extends AbstractController
{   
    #[Route('/auth/login', name: 'login', methods: ['POST'])]
    public function login(ManagerRegistry $doctrine, Request $request, SerializerInterface $serializer, UserRepository $repository): Response
    {
        $entityManager = $doctrine->getManager();

        $data = json_decode($request->getContent());
        
        $user = $repository->findOneBy(['username'=> $data->username]); 

        $factory = new PasswordHasherFactory([
            'common' => ['algorithm' => 'bcrypt'],
            'memory-hard' => ['algorithm' => 'sodium'],
        ]);
        
        // Retrieve the right password hasher by its name
        $passwordHasher = $factory->getPasswordHasher('common');

        if (!$passwordHasher->verify($user->getPassword(), $data->password)) {
            throw new AccessDeniedHttpException();
        }
        else {
            $factory = new Factory;
            $generator = $factory->getGenerator(new Strength(Strength::MEDIUM));
            $user->setToken($generator->generateString(32, 'abcdef'));
        }

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(json_decode($serializer->serialize($user, 'json')));
    }
 
    #[Route('/auth/register', name: 'register', methods: ['POST'])]
    public function register(ManagerRegistry $doctrine, SerializerInterface $serializer, Request $request): Response
    {
        $entityManager = $doctrine->getManager();

        $data = json_decode($request->getContent());
        
        $user = new User();
        $user->setUsername($data->username);

        $factory = new PasswordHasherFactory([
            'common' => ['algorithm' => 'bcrypt'],
            'memory-hard' => ['algorithm' => 'sodium'],
        ]);
        
        // Retrieve the right password hasher by its name
        $passwordHasher = $factory->getPasswordHasher('common');
        $hash = $passwordHasher->hash($data->password); // returns a bcrypt hash
        $user->setPassword($hash);

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(json_decode($serializer->serialize($user, 'json')));
    }
}
