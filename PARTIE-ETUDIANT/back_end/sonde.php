<?php

// Connexion à la base de données quizz en administrateur ROOT

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quizz";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    // Configuration de PDO pour afficher les erreurs SQL
    
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

// Vérification que les données ont été envoyées via la méthode POST

if (isset($_POST['sexe']) && isset($_POST['IDORIGINE']))

    // Récupération des données (sexe et origine), ajout automatique de l'année

    $sexe = $_POST['sexe'];
    $IDORIGINE = $_POST['IDORIGINE'];
    $annee = date("Y");

    // Préparation de la requête d'insertion des données dans la table SQL "sonde"

    $stmt = $conn->prepare("INSERT INTO sonde (IDORIGINE, SEXE, ANNEE) VALUES (:IDORIGINE, :sexe, :annee)");

    // Exécution de la requête avec les valeurs des paramètres correspondants

    $stmt->execute(array(':IDORIGINE' => $IDORIGINE, ':sexe' => $sexe, ':annee' => $annee));

    // Redirection vers une autre page
header("Location: ../front_end/questions.php");
exit();

// Fermeture de la connexion PDO
$conn = null;