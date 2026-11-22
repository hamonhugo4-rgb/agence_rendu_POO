<?php


class Utilitaire extends Vehicule implements Entretenable
{
    const SEUIL_ENTRETIEN = 10000;
    const FRAIS_NETTOYAGE = 50;

    
    public function __construct(
        string $immatriculation,
        string $marque,
        string $modele,
        float $tarifJournalier,
        private float $volume,
        private int $kmDepuisEntretien = 0
    ) {
        parent::__construct($immatriculation, $marque, $modele, $tarifJournalier);
    }

    public function getVolume(): float
    {
        return $this->volume;
    }

    public function getKmDepuisEntretien(): int
    {
        return $this->kmDepuisEntretien;
    }

    public function getType(): string
    {
        return 'Utilitaire';
    }

    
    public function calculerPrixHT(int $jours): float
    {
        return $this->tarifJournalier * $jours + self::FRAIS_NETTOYAGE;
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

    
    public function __toString(): string
    {
        return parent::__toString() . '<p>Volume : ' . $this->volume . ' m³</p>';
    }
}