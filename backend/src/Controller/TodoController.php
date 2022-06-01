<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

// use Entity\User;
use App\Entity\Todo;
use App\Entity\TodoList;
use App\Repository\UserRepository;
use App\Repository\TodoRepository;
use App\Repository\TodoListRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\SerializerInterface;


class TodoController extends AbstractController
{
    // Requete pour la creation d'une nouvelle todolist
    #[Route('/list', name: 'create_todo_list', methods: ['POST'])]
    public function createTodoList(ManagerRegistry $doctrine, Request $request, SerializerInterface $serializer, UserRepository $repository): Response
    {   
        $entityManager = $doctrine->getManager();
        $data = json_decode($request->getContent());

        // Creer la todo, set le titre, et l'utilistateur auquel elle appartient
        $todoList = new TodoList();
        $todoList->setTitle($data->title);
        // Trouve l'utilisateur par son token, et set le proprietaire de la todolist
        $user = $repository->findOneBy(['token'=> $data->token]);
        $todoList->setOwner($user);

        $entityManager->persist($todoList);
        $entityManager->flush();

        // Renvoie la nouvelle todolist
        return new JsonResponse(json_decode($serializer->serialize($todoList, 'json', ['groups' => ['list']])));
    }

    // Supprime une todolist par son ID
    // Methode DELETE permet de supprimer de la donne en BDD
    #[Route('/list', name: 'delete_todo_list', methods: ['DELETE'])]
    public function deleteTodoList(ManagerRegistry $doctrine, Request $request, SerializerInterface $serializer, TodoListRepository $repository, UserRepository $userRepository): Response
    {   
        $entityManager = $doctrine->getManager();
        $data = json_decode($request->getContent());
        // Trouve la todolit par son id
        $todoList = $repository->findOneById($data->id);
        // Supprime la todolist
        $entityManager->remove($todoList);
        $entityManager->flush();
        $user = $userRepository->findOneBy(['token'=> $data->token]);
        return new JsonResponse();
    }

    // Requete pour creer un todo
    #[Route('/list/todo', name: 'create_todo', methods: ['POST'])]
    public function createTodo(ManagerRegistry $doctrine, Request $request, SerializerInterface $serializer, TodoListRepository $repository): Response
    {
        $entityManager = $doctrine->getManager();
        $data = json_decode($request->getContent());
        
        // Trouve la todolist dans laquelle ajouter un todo
        $todoList = $repository->findOneById($data->todoListId);
        // Creer un todo
        $todo = new Todo();
        // Set la valeur et la list auquel appartient le todo
        $todo->setValue($data->value);
        $todo->setTodolist($todoList);
        
        // Valide et envoie la donne en BDD
        $entityManager->persist($todo);
        $entityManager->flush();
        // Recupere la todolist avec la nouvelle todo
        $todoList = $repository->findOneById($data->todoListId);
        
        // Renvoie la todolist modifie
        return new JsonResponse(json_decode($serializer->serialize($todoList, 'json', ['groups' => ['list']])));
    }

    // Requete pour mettre a jour un todo
    // Method PUT permet de modifie de la donne en BDD
    #[Route('/list/todo', name: 'update_todo', methods: ['PUT'])]
    public function updateTodo(ManagerRegistry $doctrine, Request $request, SerializerInterface $serializer, TodoListRepository $todoListRepository, TodoRepository $todoRepository): Response
    {
        $entityManager = $doctrine->getManager();
        $data = json_decode($request->getContent());

        // Trouve la todolist
        $todoList = $todoListRepository->findOneById($data->todoListId);
        // Trouve le todo
        $todo = $todoRepository->findOneById($data->id);
        // Modifie le todo
        $todo->setValue($data->value);
        $todo->setIsDone($data->isDone);

        // Valide et envoie les nouvelles donnes en BDD
        $entityManager->persist($todo);
        $entityManager->flush();
        
        // Recupere et renvoie la todolist modifie
        $todoList = $todoListRepository->findOneById($data->todoListId);
        return new JsonResponse(json_decode($serializer->serialize($todoList, 'json', ['groups' => ['list']])));
    }

    // Supprime un todo
    #[Route('/list/todo', name: 'delete_todo', methods: ['DELETE'])]
    public function deleteTodo(ManagerRegistry $doctrine, Request $request, SerializerInterface $serializer, TodoRepository $todoRepository, TodoListRepository $todoListRepository): Response
    {   
        $entityManager = $doctrine->getManager();
        $data = json_decode($request->getContent());
        
        // Trouve le todo
        $todo = $todoRepository->findOneById($data->id);
        $todoListId = $todo->getTodolist()->getId();
        // Valide supprime et envoie la suppression en BDD
        $entityManager->remove($todo);
        $entityManager->flush();

        // Recupere la todolist avec le todo supprime
        $todoList = $todoListRepository->findOneById($todoListId);
        return new JsonResponse(json_decode($serializer->serialize($todoList, 'json', ['groups' => ['list']])));
    }
}
