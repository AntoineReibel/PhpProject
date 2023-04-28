<?php
session_start()
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation</title>
    <link rel="stylesheet" href="ajoutConfirmationStyle.css" type="text/css"/>
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
    <a href="accueil.php" class="panier">ACCUEIL</a>
    <form method="post" action="deconnexion.php">
        <button type="submit">DECONNEXION</button>
    </form>
    </div>
</nav>
<body>
<div class="card">
    <p>Le nouvel Artiste</p>
    <p> à bien été créée !</p>
    <a href="./ajout.php">
        <button>RETOUR</button>
    </a>
</div>
</body>

</html>