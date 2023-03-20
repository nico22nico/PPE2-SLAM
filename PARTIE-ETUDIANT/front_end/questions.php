<!DOCTYPE html>
<html>
<head>
    <title>Questions | PsychoQuizz</title>
    <link rel="stylesheet" type="text/css" media="screen" href="../assets/css/main.css">
    <link rel="stylesheet" type="image/png" href="../assets/image/fld.PNG">
</head>
<header>
      <img src="../assets/image/fld.png" alt="https://imageshack.com/i/pmkGydn7p" alt="fld">
      <h1>&nbsp PsychoQuizz - Questions</h1>
    </header>
<body>
    <div class="container-questions">

    <?php      //Connexion à la bdd

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "quizz";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo "<p>Erreur.</p>";           //alternative mysqli erreur pdo
        die();
    }

    // Récupération de la question courante
    $current_question = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    $sql = "SELECT MAX(IDQUESTION) AS max_id, IDQUESTION, LIBELLE, IDTYPEQUESTION FROM question WHERE IDQUESTION > $current_question ORDER BY IDQUESTION LIMIT 1";
    $result = $conn->query($sql);

    if ($result === false) {
        echo "<p>Erreur</p>";
        die();
    }

    if ($result->rowCount() > 0) {
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $id_question = $row["IDQUESTION"];
        $libelle_question = $row["LIBELLE"];
        $max_id = $row["max_id"];
        $idtest = $row["IDTYPEQUESTION"];
        
    } else {
        $id_question = 0;
        $max_id = 0;
        $libelle_question = "Il n'y a pas de question suivante.";
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
    } else {
        $texte = "IDTYPEQUESTION non valide.";
    }
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Programme PHP/HTML</title>
</head>
<body>
	<h1>Texte en fonction de IDTYPEQUESTION</h1>
	<p><?php echo $texte; ?></p>
</div>
    <button class="btn-container">
        <a class="btnSuivant" href="?Id">Suivant  [<?php echo $id_question; ?> / <?php echo $max_id; ?>]</a>
    </button>
    <footer></footer>
</body>
</html>