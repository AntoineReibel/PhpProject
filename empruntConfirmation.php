<?php
session_start();

try {
    // On se connecte à MySQL
    $mysqlClient = new PDO('mysql:host=localhost;dbname=oeuvredart;charset=utf8', 'root', '');
} catch (Exception $e) {
    // En cas d'erreur, on affiche un message et on arrête tout
    die('Erreur : ' . $e->getMessage());
}

$sqlQuery = 'SELECT titre FROM oeuvre WHERE idOeuvre = :idOeuvre';
$oeuvresStatement = $mysqlClient->prepare($sqlQuery);
$oeuvresStatement->execute([
    'idOeuvre' => $_GET["idOeuvre"],
    ]);
$oeuvres = $oeuvresStatement->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation</title>
    <link rel="stylesheet" href="empruntConfirmationStyle.css" type="text/css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@300;400;500;600;700;800;900&display=swap"
          rel="stylesheet">
    <link rel="icon" type="image/png" href="./artRental.png"/>

</head>
<nav>
    <div class="user"><?php echo "Bonjour " . $_SESSION["prenom"]?></div>
    <?php if ($_SESSION["idUser"] == 1){
        echo "<a href='ajout.php' class='admin'>Page admin</a>";
    }
    ?>
    <a href="emprunt.php" class="panier">VOS EMPRUNTS</a>
    <form method="post" action="deconnexion.php">
        <button type="submit">DECONNEXION</button>
    </form>
    </div>
</nav>
<body>
<div class="card">
    <p>Votre emprunt de</p>
    <p><?php echo $oeuvres[0][0] ?></p>
    <p> à bien été effectué !</p>
    <a href="./accueil.php">
        <button>RETOUR</button>
    </a>
</div>
</body>

</html>
