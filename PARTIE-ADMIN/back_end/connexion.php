<?php

// Connexion à la base de données quizz en administrateur(Root)

$host = "localhost";
$username = "root";
$password = "";
$dbname = "Quizz";

try {
  $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

  // activation des erreurs PDO

  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  if (isset($_POST['submit'])) {

    // Récupération des données du formulaire de connexion

    $id_admin = $_POST['id_admin'];
    $mdp_admin = $_POST['mdp_admin'];

    // Requête SQL afin de vérifier les données de connexion

    $query = "SELECT * FROM administrateur WHERE id_admin=? AND mdp_admin=?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id_admin, $mdp_admin]);
    $result = $stmt->fetchAll();

    // Vérification du résultat

    if (count($result) == 1) {

      // Connexion réussie et redirection vers la page suivante

      session_start();
      $_SESSION['id_admin'] = $id_admin;
      header("Location: ../front_end/accueil.html");
      exit();
    } else {

      // Connexion échouée
      
      echo "L'identifiant ou le mot de passe est incorrect.";
    }
  }
} catch(PDOException $e) {
  echo "La connexion a échoué: " . $e->getMessage();
}
?>