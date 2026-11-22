<?php


class Location
{
    
    public function __construct(
        private Client $client,
        private Vehicule $vehicule,
        private int $jours,
        private float $montantTTC,
        private ?string $dateDebut = null
    ) {
        
        if ($this->dateDebut === null) {
            $this->dateDebut = date('d/m/Y');
        }
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getVehicule(): Vehicule
    {
        return $this->vehicule;
    }

    public function getJours(): int
    {
        return $this->jours;
    }

    public function getMontantTTC(): float
    {
        return $this->montantTTC;
    }

    public function getDateDebut(): string
    {
        return $this->dateDebut;
    }

    
    public function __toString(): string
    {
        return $this->client->getNomComplet()
            . ' - ' . $this->vehicule->getMarque() . ' ' . $this->vehicule->getModele()
            . ' (' . $this->vehicule->getImmatriculation() . ')'
            . ' - ' . $this->jours . ' jours'
            . ' - ' . number_format($this->montantTTC, 2, '.', '') . ' €';
    }
}