<?php

require_once './interfaces/Louable.php';
require_once './interfaces/Entretenable.php';
require_once './traits/HistoriqueTrait.php';
require_once './class/Vehicule.php';
require_once './class/Voiture.php';
require_once './class/Utilitaire.php';
require_once './class/VeloElectrique.php';


$clio = new Voiture('AB-123-CD', 'Renault', 'Clio', 42, 5);
$espace = new Voiture('EF-456-GH', 'Renault', 'Espace', 60, 7);

echo Vehicule::getNbVehicules();   
echo $clio;                        
echo $clio->louer(3);              
echo $clio->louer(1);              
echo $espace->louer(3);            
$clio->rendre();
$clio->ajouterKilometres(16000);
var_dump($clio->besoinEntretien()); 
$clio->entretenir();
var_dump($clio->besoinEntretien()); 
echo $clio->afficherHistorique();

try {
    new Voiture('abc', 'Renault', 'Clio', 42, 5);
} catch (InvalidArgumentException $e) {
    echo $e->getMessage();          
}

$master = new Utilitaire('IJ-789-KL', 'Renault', 'Master', 80, 12);
echo $master;               
echo $master->louer(2); 

$velo = new VeloElectrique('MN-012-OP', 'Decathlon', 'Elops E-Bike', 15, 60);
echo $velo->louer(8);