<?php


class Voiture extends Vehicule implements Entretenable
{
    const SEUIL_ENTRETIEN = 15000;

    
    public function __construct(
        string $immatriculation,
        string $marque,
        string $modele,
        float $tarifJournalier,
        private int $nbPlaces,
        private int $kmDepuisEntretien = 0
    ) {
        
        parent::__construct($immatriculation, $marque, $modele, $tarifJournalier);
    }

    public function getNbPlaces(): int
    {
        return $this->nbPlaces;
    }

    public function getKmDepuisEntretien(): int
    {
        return $this->kmDepuisEntretien;
    }

    public function getType(): string
    {
        return 'Voiture';
    }

   
    public function calculerPrixHT(int $jours): float
    {
        $tarif = $this->tarifJournalier;
        if ($this->nbPlaces > 5) {
            $tarif += 10;
        }
        return $tarif * $jours;
    }

    
    public function ajouterKilometres(int $km): self
    {
        $this->kmDepuisEntretien += $km;
        return $this;
    }

    public function besoinEntretien(): bool
    {
        return $this->kmDepuisEntretien >= self::SEUIL_ENTRETIEN;
    }

    public function entretenir(): void
    {
        $this->kmDepuisEntretien = 0;
        $this->ajouterHistorique('Entretien effectué');
    }
}