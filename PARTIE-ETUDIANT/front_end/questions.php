<!DOCTYPE html>
<html>
<head>
    <title>Questions | PsychoQuizz</title>
    <link rel="stylesheet" type="text/css" media="screen" href="../assets/css/main.css">
    <link rel="stylesheet" type="image/png" href="../assets/image/fld.PNG">
    <link rel="icon" type="image/x-icon" href="../assets/image/fld.PNG">
</head>
<header>
      <img src="../assets/image/fld.png" alt="https://imageshack.com/i/pmkGydn7p" alt="fld">
      <h1>&nbsp PsychoQuizz - Questions</h1>
    </header>
<body>
    <div class="container-questions">

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "quizz";
    
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo "<p>Une erreur est survenue : " . $e->getMessage() . "</p>";
        die();
    }
    
    // Récupération de la question courante
    $current_question = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    
    $sql = "SELECT MAX(IDQUESTION) AS max_id, IDQUESTION, LIBELLE, IDTYPEQUESTION FROM question WHERE IDQUESTION > ? ORDER BY IDQUESTION LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$current_question]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$row) {
        $id_question = 0;
        $max_id = 0;
        $libelle_question = "Il n'y a pas de question suivante.";
    } else {
        $id_question = $row["IDQUESTION"];
        $libelle_question = $row["LIBELLE"];
        $max_id = $row["max_id"];
        $idtest = $row["IDTYPEQUESTION"];
    }
    
    $conn = null;

    if ($idtest == 1) {
        $texte = "<h2>" . $id_question . " - " . $libelle_question . " ? </h2>";
        $texte .= '<a href="?id=' . $id_question . '" class="btnOui">Oui</a>';
        $texte .= '<a href="?id=' . $id_question . '" class="btnNon">Non</a>';
    } elseif ($idtest == 2) {
        $texte = "<h2>" . $id_question . " - " . $libelle_question . " ? </h2>";
        $texte .= '<form class="rdb-group2">';
        $texte .= '<label class="rdbRouge"><input type="radio" name="color" value="purple"> Pas du tout</label>';
        $texte .= '<label class="rdbOrange"><input type="radio" name="color" value="yellow"> Un peu</label>';
        $texte .= '<label class="rdbJaune"><input type="radio" name="color" value="green"> Modérément</label>';
        $texte .= '<label class="rdbJauneVert"><input type="radio" name="color" value="blue"> Beaucoup</label>';
        $texte .= '<label class="rdbVert"><input type="radio" name="color" value="red"> Énormément</label>';
        $texte .= '</form>';
    }
    ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
</head>
<body>
	<h1>Affichage des questions</h1>
	<p><?php echo $texte; ?></p>
    </div>
  <a href="?id=<?php echo $id_question ?>" class="btnSuivant">Suivant <?php echo $id_question ?> / <?php echo $max_id ?></a>
</body>
<footer></footer>
</html>