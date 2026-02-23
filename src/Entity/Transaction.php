<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    private ?PayementMethod $PayementMethod = null;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    private ?User $User = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPayementMethod(): ?PayementMethod
    {
        return $this->PayementMethod;
    }

    public function setPayementMethod(?PayementMethod $PayementMethod): static
    {
        $this->PayementMethod = $PayementMethod;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): static
    {
        $this->User = $User;

        return $this;
    }
}
