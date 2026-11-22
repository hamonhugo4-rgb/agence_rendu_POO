<?php


require_once './interfaces/Louable.php';
require_once './interfaces/Entretenable.php';
require_once './traits/HistoriqueTrait.php';
require_once './class/Vehicule.php';
require_once './class/Voiture.php';
require_once './class/Utilitaire.php';
require_once './class/VeloElectrique.php';
require_once './class/Client.php';
require_once './class/Location.php';
require_once './class/Agence.php';

echo '<h1>Agence de location de véhicules</h1>';


echo '<h2>1. Création de l\'agence et du parc</h2>';
$agence = new Agence('Agence Seine Location');
$clio = new Voiture('AB-123-CD', 'Renault', 'Clio', 42, 5);
$espace = new Voiture('EF-456-GH', 'Renault', 'Espace', 60, 7);
$master = new Utilitaire('IJ-789-KL', 'Renault', 'Master', 80, 12);
$velo = new VeloElectrique('MN-012-OP', 'Decathlon', 'Elops E-Bike', 15, 60);

$agence->ajouterVehicule($clio)
    ->ajouterVehicule($espace)
    ->ajouterVehicule($master)
    ->ajouterVehicule($velo);
echo '<p>Agence ' . $agence->getNom() . ' créée avec 4 véhicules.</p>';


echo '<h2>2. Nombre de véhicules créés</h2>';
echo '<p>' . Vehicule::getNbVehicules() . ' véhicules créés.</p>';


echo '<h2>3. Le parc</h2>';
echo $clio;
echo $espace;
echo $master;
echo $velo;


echo '<h2>4. Les clients</h2>';
$jean = new Client('Dupont', 'Jean', 'jean.dupont@example.com', '0601020304');
$marie = new Client('Martin', 'Marie', 'marie.martin@example.com');
echo '<p>' . $jean . '</p>';
echo '<p>' . $marie . '</p>';

try {
    $paul = new Client('Durand', 'Paul', 'email-invalide');
} catch (InvalidArgumentException $e) {
    echo '<p>Erreur : ' . $e->getMessage() . '</p>';
}


echo '<h2>5. Locations</h2>';

$location = $agence->louerVehicule($jean, 'EF-456-GH', 3);
if ($location !== null) {
    echo '<p>Location réussie : ' . $location . '</p>';
} else {
    echo '<p>Location impossible (Espace, 3 jours)</p>';
}

$location = $agence->louerVehicule($marie, 'MN-012-OP', 8);
if ($location !== null) {
    echo '<p>Location réussie : ' . $location . '</p>';
} else {
    echo '<p>Location impossible (vélo, 8 jours)</p>';
}


$location = $agence->louerVehicule($marie, 'EF-456-GH', 2);
if ($location !== null) {
    echo '<p>Location réussie : ' . $location . '</p>';
} else {
    echo '<p>Location impossible : l\'Espace est déjà loué</p>';
}


echo '<h2>6. Retour de l\'Espace (16 000 km)</h2>';
$agence->rendreVehicule('EF-456-GH', 16000);
echo '<p>Espace rendu.</p>';

$location = $agence->louerVehicule($marie, 'EF-456-GH', 2);
if ($location !== null) {
    echo '<p>Location réussie : ' . $location . '</p>';
} else {
    echo '<p>Location impossible : l\'Espace a besoin d\'un entretien</p>';
}


echo '<h2>7. Entretien puis relocation</h2>';
$espace->entretenir();
echo '<p>Entretien de l\'Espace effectué.</p>';

$location = $agence->louerVehicule($marie, 'EF-456-GH', 2);
if ($location !== null) {
    echo '<p>Location réussie : ' . $location . '</p>';
} else {
    echo '<p>Location impossible (Espace, 2 jours)</p>';
}


echo '<h2>8. Bilan</h2>';
echo '<h3>Locations</h3>';
echo '<ul>';
foreach ($agence->getLocations() as $uneLocation) {
    echo '<li>' . $uneLocation . '</li>';
}
echo '</ul>';
echo '<p>Chiffre d\'affaires : ' . $agence->getChiffreAffaires() . ' €</p>';
echo '<h3>Historique de l\'Espace</h3>';
echo $espace->afficherHistorique();


echo '<h2>9. Sauvegarde</h2>';
$agence->sauvegarder('./data/agence.txt');
echo '<p>Agence sauvegardée dans /data/agence.txt</p>';