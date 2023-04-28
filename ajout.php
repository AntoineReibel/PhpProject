<?php
session_start();

if($_SESSION["idUser"] != 1) {
    header("Location: index.php");
}

try {
    $mysqlClient = new PDO('mysql:host=localhost;dbname=oeuvredart;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

$query = "SELECT * FROM Artiste";
$pdoStat = $mysqlClient->prepare($query);
$executeIsOk = $pdoStat->execute()
or die(print_r($mysqlClient->errorInfo()));
$artistes = $pdoStat->fetchAll();

$query2 = "SELECT * FROM Technique";
$pdoStat = $mysqlClient->prepare($query2);
$executeIsOk = $pdoStat->execute()
or die(print_r($mysqlClient->errorInfo()));
$techniques = $pdoStat->fetchAll();

if (isset($_POST["titre"]) && isset($_POST["annee"])) {
    $query3 = "INSERT INTO Oeuvre (titre, anneeCreation, artisteId, techniqueId) VALUES (:titre,:anneeCreation, :artisteId, :techniqueId)";
    $pdoStat = $mysqlClient->prepare($query3);
    $executeIsOk = $pdoStat->execute([
        'titre' => $_POST["titre"],
        'anneeCreation' => $_POST["annee"],
        'artisteId' => $_POST["idArtiste"],
        'techniqueId' => $_POST["idTechnique"]
    ])
    or die(print_r($mysqlClient->errorInfo()));
    header("Location: ajoutConfirmationOeuvre.php");
}

if (isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["date"])) {
    $query3 = "INSERT INTO Artiste (nomArtiste, prenomArtiste, dateNaissanceArtiste) VALUES (:nomArtiste,:prenomArtiste, :dateNaissanceArtiste)";
    $pdoStat = $mysqlClient->prepare($query3);
    $executeIsOk = $pdoStat->execute([
        'nomArtiste' => $_POST["nom"],
        'prenomArtiste' => $_POST["prenom"],
        'dateNaissanceArtiste' => $_POST["date"]
    ])
    or die(print_r($mysqlClient->errorInfo()));
    header("Location: ajoutConfirmationArtiste.php");
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de compte</title>
    <link rel="stylesheet" href="ajoutStyle.css" type="text/css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@300;400;500;600;700;800;900&display=swap"
          rel="stylesheet">
    <link rel="icon" type="image/png" href="./artRental.png"/>
</head>

<body>
<nav>
    <div class="user"><?php echo "Bonjour " . $_SESSION["prenom"]?></div>
    <?php if ($_SESSION["idUser"] == 1){
        echo "<a href='ajout.php' class='admin'>Page admin</a>";
    }
    ?>
    <a href="accueil.php" class="panier">ACCUEIL</a>
    <form method="post" action="deconnexion.php">
        <button type="submit">DECONNEXION</button>
    </form>
    </div>
</nav>
<div class="cardFlex">
    <div class="card">
        <div class="title"> NOUVELLE OEUVRE</div>
        <img class="filleALaPerle" src="./filleAlaPerle.jpg" alt="La fille à la perle">
        <form method="post" action="">
            <input type="text" name="titre" id="titre" placeholder="Titre" required>
            <input type="number" name="annee" id="annee" placeholder="Année de création (AAAA)" required>
            <select name="idArtiste" id="idArtiste">
                <?php
                foreach ($artistes as $artiste) {
                    echo '<option value="' . $artiste['idArtiste'] . '">' . $artiste['nomArtiste'] . " " . $artiste['prenomArtiste'] . '</option>';
                }
                ?>
            </select>
            <select name="idTechnique" id="idTechnique">
                <?php
                foreach ($techniques as $technique) {
                    echo '<option value="' . $technique['idTechnique'] . '">' . $technique['nomTechnique'] . '</option>';
                }
                ?>
            </select>
            <button>AJOUTER</button>
        </form>
    </div>


    <div class="card">
        <div class="title"> NOUVEL ARTISTE</div>
        <img class="rembrandt" src="./rembrandt.jpg" alt="Portrait de Rembrandt">
        <form method="post" action="">
            <input type="text" name="nom" id="nom" placeholder="Nom" required>
            <input type="text" name="prenom" id="prenom" placeholder="Prenom" required>
            <input type="date" name="date" id="date" placeholder="Date de naissance" required>
            <button>AJOUTER</button>
        </form>
    </div>
</div>
</body>

</html>


