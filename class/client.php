<?php


class Client
{
    
    private string $nom;
    private string $prenom;
    private string $email;
    private ?string $telephone;

    
    public function __construct(string $nom, string $prenom, string $email, ?string $telephone = null)
    {
        $this->setNom($nom)
            ->setPrenom($prenom)
            ->setEmail($email)
            ->setTelephone($telephone);
    }

    
    public function setNom(string $value): self
    {
        $this->nom = $value;
        return $this;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setPrenom(string $value): self
    {
        $this->prenom = $value;
        return $this;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function setEmail(string $value): self
    {
        
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Email invalide : ' . $value);
        }
        $this->email = $value;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setTelephone(?string $value): self
    {
        $this->telephone = $value;
        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function getNomComplet(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }

    public function __toString(): string
    {
        return $this->getNomComplet() . ' (' . $this->email . ')';
    }
}