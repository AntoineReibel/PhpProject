
<?php session_start();

if(!isset($_SESSION["loggedUser"])){
    header("Location: index.php");
}

$retour = date('Y-m-d H:i:s');
try {
    // On se connecte à MySQL
    $mysqlClient = new PDO('mysql:host=localhost;dbname=oeuvredart;charset=utf8', 'root', '');
} catch (Exception $e) {
    // En cas d'erreur, on affiche un message et on arrête tout
    die('Erreur : ' . $e->getMessage());
}

if(isset($_POST["retour"])) {
    $query2 = "UPDATE oeuvre SET disponible = 1 WHERE idOeuvre = :idOeuvre";
    $pdoStat = $mysqlClient->prepare($query2);
    $executeIsOk = $pdoStat->execute([
        'idOeuvre' => $_POST["retour"]
    ]) or die(print_r($mysqlClient->errorInfo()));
    $client = $pdoStat->fetch();

    $query3 = "UPDATE emprunt SET dateRetour = :dateRetour WHERE oeuvreId = :idOeuvre AND dateRetour IS NULL";
    $pdoStat = $mysqlClient->prepare($query3);
    $executeIsOk = $pdoStat->execute([
        'dateRetour' => $retour,
        'idOeuvre' => $_POST["retour"]
    ]) or die(print_r($mysqlClient->errorInfo()));
    $client = $pdoStat->fetch();
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emprunt</title>
    <link rel="stylesheet" href="empruntStyle.css" type="text/css"/>
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

<div class="grid">

    <?php

    $sqlQuery = 'SELECT *
FROM oeuvre
INNER JOIN technique ON techniqueId = idTechnique
INNER JOIN artiste ON artisteId = idArtiste
INNER JOIN emprunt ON idOeuvre = oeuvreId
WHERE utilisateurId = :utilisateurId AND dateRetour IS NULL;';
    $oeuvresStatement = $mysqlClient->prepare($sqlQuery);
    $oeuvresStatement->execute([
            'utilisateurId' => $_SESSION["idUser"],
        ]);
    $oeuvres = $oeuvresStatement->fetchAll();

    foreach ($oeuvres as $oeuvre) {
        ?>
        <div class="oeuvre">
            <p class="titre"><?php echo $oeuvre['titre']; ?></p>
            <p><?php echo $oeuvre['nomArtiste']; ?></p>
            <p> <?php echo $oeuvre['prenomArtiste']; ?></p>
            <p><?php echo $oeuvre['anneeCreation']; ?></p>
            <p><?php echo $oeuvre['nomTechnique']; ?></p>
            <form method="post" action="">
                <input type="hidden" name="retour" id="retour" value="<?php echo $oeuvre['idOeuvre'] ?>">
                <button>RETOURNER</button>
            </form>
        </div>

        <?php
    }
    ?>

</div>
</body>

</html>


