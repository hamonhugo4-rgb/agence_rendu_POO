<?php


class Agence
{
    
    private string $nom;
    private array $vehicules = [];
    private array $locations = [];

    public function __construct(string $nom)
    {
        $this->nom = $nom;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getVehicules(): array
    {
        return $this->vehicules;
    }

    public function getLocations(): array
    {
        return $this->locations;
    }

    
    public function ajouterVehicule(Vehicule $vehicule): self
    {
        $this->vehicules[] = $vehicule;
        return $this;
    }

    
    public function getVehiculesDisponibles(): array
    {
        $disponibles = [];
        foreach ($this->vehicules as $vehicule) {
            if ($vehicule->estDisponible()) {
                $disponibles[] = $vehicule;
            }
        }
        return $disponibles;
    }

    
    public function louerVehicule(Client $client, string $immatriculation, int $jours): ?Location
    {
        $vehicule = $this->trouverVehicule($immatriculation);

        if ($vehicule === null || !$vehicule->estDisponible()) {
            return null;
        }

        
        if ($vehicule instanceof Entretenable && $vehicule->besoinEntretien()) {
            return null;
        }

        $prix = $vehicule->louer($jours);
        
        if ($prix == 0) {
            return null;
        }

        $location = new Location($client, $vehicule, $jours, $prix);
        $this->locations[] = $location;

        return $location;
    }

   
    public function rendreVehicule(string $immatriculation, int $kmParcourus = 0): void
    {
        $vehicule = $this->trouverVehicule($immatriculation);
        if ($vehicule === null) {
            return;
        }

        $vehicule->rendre();

        if ($vehicule instanceof Entretenable) {
            $vehicule->ajouterKilometres($kmParcourus);
        }
    }

    
    public function getChiffreAffaires(): float
    {
        $total = 0;
        foreach ($this->locations as $location) {
            $total += $location->getMontantTTC();
        }
        return $total;
    }

    
    public function __serialize(): array
    {
        return [
            'nom' => $this->nom,
            'vehicules' => $this->vehicules,
            'locations' => $this->locations,
        ];
    }

    public function __unserialize(array $data): void
    {
        $this->nom = $data['nom'];
        $this->vehicules = $data['vehicules'];
        $this->locations = $data['locations'];
    }

    
    public function sauvegarder(string $fichier): void
    {
        file_put_contents($fichier, serialize($this));
    }

    
    public static function charger(string $fichier): Agence
    {
        return unserialize(file_get_contents($fichier));
    }

    
    private function trouverVehicule(string $immatriculation): ?Vehicule
    {
        foreach ($this->vehicules as $vehicule) {
            if ($vehicule->getImmatriculation() === $immatriculation) {
                return $vehicule;
            }
        }
        return null;
    }
}