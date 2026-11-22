<?php


final class VeloElectrique extends Vehicule
{
    
    public function __construct(
        string $immatriculation,
        string $marque,
        string $modele,
        float $tarifJournalier,
        private int $autonomie
    ) {
        parent::__construct($immatriculation, $marque, $modele, $tarifJournalier);
    }

    public function getAutonomie(): int
    {
        return $this->autonomie;
    }

    public function getType(): string
    {
        return 'Vélo électrique';
    }

    
    public function calculerPrixHT(int $jours): float
    {
        $prix = $this->tarifJournalier * $jours;
        if ($jours >= 7) {
            $prix = $prix * 0.8;
        }
        return $prix;
    }
}