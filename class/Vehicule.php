<?php


abstract class Vehicule implements Louable
{
    use HistoriqueTrait;

    
    const TVA = 1.20;

    
    private static int $nbVehicules = 0;

       private string $immatriculation;
    private string $marque;
    private string $modele;
    
    protected float $tarifJournalier;
    private bool $disponible = true;

    
    public function __construct(string $immatriculation, string $marque, string $modele, float $tarifJournalier)
    {
        $this->setImmatriculation($immatriculation)
            ->setMarque($marque)
            ->setModele($modele)
            ->setTarifJournalier($tarifJournalier);

        self::$nbVehicules++;
    }

        public static function getNbVehicules(): int
    {
        return self::$nbVehicules;
    }

    
    public function setImmatriculation(string $value): self
    {
        
        if (!preg_match('/^[A-Z]{2}-[0-9]{3}-[A-Z]{2}$/', $value)) {
            throw new InvalidArgumentException('Immatriculation invalide : ' . $value);
        }
        $this->immatriculation = $value;
        return $this;
    }

    public function getImmatriculation(): string
    {
        return $this->immatriculation;
    }

    public function setMarque(string $value): self
    {
        $this->marque = $value;
        return $this;
    }

    public function getMarque(): string
    {
        return $this->marque;
    }

    public function setModele(string $value): self
    {
        $this->modele = $value;
        return $this;
    }

    public function getModele(): string
    {
        return $this->modele;
    }

    public function setTarifJournalier(float $value): self
    {
        
        if ($value <= 0) {
            throw new InvalidArgumentException('Le tarif journalier doit être supérieur à 0');
        }
        $this->tarifJournalier = $value;
        return $this;
    }

    public function getTarifJournalier(): float
    {
        return $this->tarifJournalier;
    }

    public function setDisponible(bool $value): self
    {
        $this->disponible = $value;
        return $this;
    }

    public function getDisponible(): bool
    {
        return $this->disponible;
    }

    
    final public function louer(int $jours): float
    {
        
        if (!$this->disponible || $jours < 1) {
            return 0;
        }

        
        $prixTTC = round($this->calculerPrixHT($jours) * self::TVA, 2);

        $this->disponible = false;
        $this->ajouterHistorique('Loué ' . $jours . ' jour(s) pour ' . $prixTTC . ' € TTC');

        return $prixTTC;
    }

    
    public function rendre(): void
    {
        $this->disponible = true;
        $this->ajouterHistorique('Véhicule rendu');
    }

    public function estDisponible(): bool
    {
        return $this->disponible;
    }

    
    abstract public function calculerPrixHT(int $jours): float;

    abstract public function getType(): string;

   
    public function __toString(): string
    {
        $tarifTTC = round($this->tarifJournalier * self::TVA, 2);

        return '<h3>' . $this->getType() . '</h3>'
            . '<p>' . $this->marque . ' ' . $this->modele . '</p>'
            . '<p>Immatriculation : ' . $this->immatriculation . '</p>'
            . '<p>Tarif journalier : ' . $tarifTTC . ' € TTC</p>'
            . '<p>' . ($this->disponible ? 'Disponible' : 'Indisponible') . '</p>';
    }
}