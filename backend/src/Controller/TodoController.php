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
    #[Route('/list', name: 'create_todo_list', methods: ['POST'])]
    public function createTodoList(ManagerRegistry $doctrine, Request $request, SerializerInterface $serializer, UserRepository $repository): Response
    {   
        $entityManager = $doctrine->getManager();
        $data = json_decode($request->getContent());

        $todoList = new TodoList();
        $todoList->setTitle($data->title);
        $user = $repository->findOneBy(['token'=> $data->token]);
        $todoList->setOwner($user);

        $entityManager->persist($todoList);
        $entityManager->flush();

        return new JsonResponse(json_decode($serializer->serialize($todoList, 'json', ['groups' => ['list']])));
    }

    #[Route('/list', name: 'delete_todo_list', methods: ['DELETE'])]
    public function deleteTodoList(ManagerRegistry $doctrine, Request $request, SerializerInterface $serializer, TodoListRepository $repository, UserRepository $userRepository): Response
    {   
        $entityManager = $doctrine->getManager();
        $data = json_decode($request->getContent());
        $todoList = $repository->findOneById($data->id);
        $entityManager->remove($todoList);
        $entityManager->flush();
        $user = $userRepository->findOneBy(['token'=> $data->token]);
        return new JsonResponse();
    }

    #[Route('/list/todo', name: 'create_todo', methods: ['POST'])]
    public function createTodo(ManagerRegistry $doctrine, Request $request, SerializerInterface $serializer, TodoListRepository $repository): Response
    {   
        $entityManager = $doctrine->getManager();
        $data = json_decode($request->getContent());
        
        $todoList = $repository->findOneById($data->todoListId);
        $todo = new Todo();
        $todo->setValue($data->value);
        $todo->setTodolist($todoList);
        
        $entityManager->persist($todo);
        $entityManager->flush();
        $todoList = $repository->findOneById($data->todoListId);
        
        return new JsonResponse(json_decode($serializer->serialize($todoList, 'json', ['groups' => ['list']])));
    }

    #[Route('/list/todo', name: 'update_todo', methods: ['PUT'])]
    public function updateTodo(ManagerRegistry $doctrine, Request $request, SerializerInterface $serializer, TodoListRepository $todoListRepository, TodoRepository $todoRepository): Response
    {
        $entityManager = $doctrine->getManager();
        $data = json_decode($request->getContent());

        $todoList = $todoListRepository->findOneById($data->todoListId);
        $todo = $todoRepository->findOneById($data->id);
        $todo->setValue($data->value);
        $todo->setIsDone($data->isDone);

        $entityManager->persist($todo);
        $entityManager->flush();
        $todoList = $todoListRepository->findOneById($data->todoListId);
        
        return new JsonResponse(json_decode($serializer->serialize($todoList, 'json', ['groups' => ['list']])));
    }

    #[Route('/list/todo', name: 'delete_todo', methods: ['DELETE'])]
    public function deleteTodo(ManagerRegistry $doctrine, Request $request, SerializerInterface $serializer, TodoRepository $todoRepository, TodoListRepository $todoListRepository): Response
    {   
        $entityManager = $doctrine->getManager();
        $data = json_decode($request->getContent());
        
        $todo = $todoRepository->findOneById($data->id);
        $todoListId = $todo->getTodolist()->getId();
        $entityManager->remove($todo);
        $entityManager->flush();
        $todoList = $todoListRepository->findOneById($todoListId);

        return new JsonResponse(json_decode($serializer->serialize($todoList, 'json', ['groups' => ['list']])));
    }
}
