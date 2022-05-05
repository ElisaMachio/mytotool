<?php

namespace App\Entity;

use App\Repository\TodoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TodoRepository::class)]
class Todo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $value;

    #[ORM\Column(type: 'boolean')]
    private $isDone;

    #[ORM\ManyToOne(targetEntity: TodoList::class, inversedBy: 'todos')]
    #[ORM\JoinColumn(nullable: false)]
    private $todoList;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getIsDone(): ?bool
    {
        return $this->isDone;
    }

    public function setIsDone(bool $isDone): self
    {
        $this->isDone = $isDone;

        return $this;
    }

    public function getTodolist(): ?TodoList
    {
        return $this->todoList;
    }

    public function setTodolist(?TodoList $todoList): self
    {
        $this->todoList = $todoList;

        return $this;
    }
}
