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

// Controller utilise pour l'authentification des utilisateurs
class AuthController extends AbstractController
{   
    // Requete qui permet le login de l'utilisateur
    // /auth/login est la route pour acceder a la requete
    // Method POST permet d'ecrire de la nouvelle donnes en BDD.
    #[Route('/auth/login', name: 'login', methods: ['POST'])]
    public function login(ManagerRegistry $doctrine, Request $request, SerializerInterface $serializer, UserRepository $repository): Response
    {
        // Recupere l'entity manager
        $entityManager = $doctrine->getManager();
        // Decode les donnes recu dans la requete
        $data = json_decode($request->getContent());
        // Recupere un user via son username en BDD
        $user = $repository->findOneBy(['username'=> $data->username]); 

        // Hash du password avec l'algorithme bcrypt par securite
        $factory = new PasswordHasherFactory([
            'common' => ['algorithm' => 'bcrypt'],
            'memory-hard' => ['algorithm' => 'sodium'],
        ]);
        
        // Retrieve the right password hasher by its name
        $passwordHasher = $factory->getPasswordHasher('common');

        // Verifie si le hash du password recu correspond avec le hash en bdd
        if (!$passwordHasher->verify($user->getPassword(), $data->password)) {
            // Si ils ne correspondent pas renvoie une erreur
            throw new AccessDeniedHttpException();
        }
        else {
            // Si ils correspondent genere un token aleatoire pour l'authentification
            $factory = new Factory;
            $generator = $factory->getGenerator(new Strength(Strength::MEDIUM));
            $user->setToken($generator->generateString(32, 'abcdef'));
        }

        // Ecrit la nouvelle donne en BDD
        $entityManager->persist($user);
        // Valide l'ecrite de la donnee
        $entityManager->flush();

        // Renvoie le user en reponse a l'utilisateur
        // Serialize permet de transformer l'utilisateur en objet json
        return new JsonResponse(json_decode($serializer->serialize($user, 'json', ['groups' => ['list']])));
    }
 
    // Requete qui permet l'enregistrement d'un nouvel utilisateur
    #[Route('/auth/register', name: 'register', methods: ['POST'])]
    public function register(ManagerRegistry $doctrine, SerializerInterface $serializer, Request $request): Response
    {
        $entityManager = $doctrine->getManager();
        $data = json_decode($request->getContent());

        // Cree un nouveau user et set son username
        $user = new User();
        $user->setUsername($data->username);

        // Hash du password avec l'algorithme bcrypt par securite
        $factory = new PasswordHasherFactory([
            'common' => ['algorithm' => 'bcrypt'],
            'memory-hard' => ['algorithm' => 'sodium'],
        ]);
        
        // Recupere le bon hasher par son nom
        $passwordHasher = $factory->getPasswordHasher('common');
        $hash = $passwordHasher->hash($data->password); // retourne un hash bcrypt
        $user->setPassword($hash); // Set le password

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(json_decode($serializer->serialize($user, 'json', ['groups' => ['list']])));
    }
}
