<?php session_start();

if (!isset($_SESSION["loggedUser"])) {
    header("Location: index.php");
}


$dateEmprunt = date('Y-m-d H:i:s');

try {
    $mysqlClient = new PDO('mysql:host=localhost;dbname=oeuvredart;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

$query5 = "SELECT * FROM Emprunt WHERE `utilisateurId` = :idUser AND `dateRetour` IS NULL;";
$pdoStat = $mysqlClient->prepare($query5);
$executeIsOk = $pdoStat->execute([
    'idUser' => $_SESSION['idUser']
]) or die(print_r($mysqlClient->errorInfo()));
$alert = $pdoStat->fetchAll();


if (isset($_POST["emprunt"])) {
    if (count($alert) >= 3) {
        header("location: alert.php");
    } else {
        $query2 = "UPDATE oeuvre SET disponible = 0 WHERE idOeuvre = :idOeuvre";
        $pdoStat = $mysqlClient->prepare($query2);
        $executeIsOk = $pdoStat->execute([
            'idOeuvre' => $_POST["emprunt"]
        ]) or die(print_r($mysqlClient->errorInfo()));

        $query3 = 'INSERT INTO emprunt(utilisateurId, oeuvreId, dateEmprunt) values ( :utilisateurId, :oeuvreId, :dateEmprunt)';
        $pdoStat = $mysqlClient->prepare($query3);
        $executeIsOk = $pdoStat->execute([
            'utilisateurId' => $_SESSION["idUser"],
            'oeuvreId' => $_POST["emprunt"],
            'dateEmprunt' => $dateEmprunt
        ]) or die(print_r($mysqlClient->errorInfo()));
        header("Location: empruntConfirmation.php?idOeuvre=" . $_POST["emprunt"]);
        exit();
    }
}

if (isset($_POST["oeuvreDelete"])) {
    $query5 = "DELETE FROM emprunt WHERE oeuvreId = :idOeuvre;";
    $pdoStat = $mysqlClient->prepare($query5);
    $executeIsOk = $pdoStat->execute([
        'idOeuvre' => $_POST["oeuvreDelete"]
    ]) or die(print_r($mysqlClient->errorInfo()));

    $query6 = "DELETE FROM oeuvre WHERE idOeuvre = :idOeuvre";
    $pdoStat2 = $mysqlClient->prepare($query6);
    $executeIsOk2 = $pdoStat2->execute([
        "idOeuvre" => $_POST["oeuvreDelete"]
    ]) or die(print_r($mysqlClient->errorInfo()));
}

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="accueilStyle.css" type="text/css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@300;400;500;600;700;800;900&display=swap"
          rel="stylesheet">
    <link rel="icon" type="image/png" href="./artRental.png"/>
</head>

<body>
<nav>
    <div class="user"><?php echo "Bonjour " . $_SESSION["prenom"] ?></div>
    <?php if ($_SESSION["idUser"] == 1) {
        echo "<a href='ajout.php' class='admin'>Page admin</a>";
    }
    ?>
    <a href="emprunt.php" class="panier">VOS EMPRUNTS</a>
    <form method="post" action="deconnexion.php">
        <button class="deconnexion" type="submit">DECONNEXION</button>
    </form>
    </div>
</nav>

<div class="grid">

    <?php

    $sqlQuery = 'SELECT *
FROM oeuvre 
INNER JOIN technique
ON techniqueId = idTechnique
INNER JOIN artiste
ON artisteId = idArtiste;';
    $oeuvresStatement = $mysqlClient->prepare($sqlQuery);
    $oeuvresStatement->execute();
    $oeuvres = $oeuvresStatement->fetchAll();

    foreach ($oeuvres as $oeuvre) {
        ?>
        <div class="oeuvre">
            <p class="titre"><?php echo $oeuvre['titre']; ?></p>
            <p><?php echo $oeuvre['nomArtiste']; ?></p>
            <p> <?php echo $oeuvre['prenomArtiste']; ?></p>
            <p><?php echo $oeuvre['anneeCreation']; ?></p>
            <p><?php echo $oeuvre['nomTechnique']; ?></p>
            <?php if ($oeuvre['disponible'] == 1) { ?>
                <form method="post" action="">
                    <input type="hidden" name="emprunt" id="emprunt" value="<?php echo $oeuvre['idOeuvre'] ?>">
                    <button>EMPRUNTER</button>
                </form>
            <?php } else { ?>
                <p style="color: red">INDISPONIBLE</p>
            <?php } ?>
            <?php if ($_SESSION["idUser"] == 1 && $oeuvre['disponible'] == 1) { ?>
                <form method="post" action="">
                    <input type="hidden" name="oeuvreDelete" id="oeuvreDelete"
                           value="<?php echo $oeuvre['idOeuvre'] ?>">
                    <button class="delete">X</button>
                </form>
            <?php } ?>
        </div>

        <?php
    }
    ?>

</div>
</body>

</html>