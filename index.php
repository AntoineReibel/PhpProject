
<?php
session_start();
if (isset($_POST["password"])) {
    $erreur = "Utilisateur inconnu";
} else {
    $erreur = null;
}
// Connexion à la base de données

if (isset($_POST["password"]) && isset($_POST["email"]) ) {
    try {
        $db = new PDO('mysql:host=localhost;dbname=oeuvredart;charset=utf8', 'root', '');
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    $requete = 'Select * from Utilisateur where email ="'. $_POST['email']. '";';
    $resultat = $db->query($requete) or die(print_r($db->errorInfo()));

    foreach ($resultat as $row) {
        if ($row["motDePasse"] == $_POST["password"] && $_POST["email"] == $row["email"]){
            $_SESSION["loggedUser"] = $_POST["email"];
            $_SESSION["idUser"] = $row["idUtilisateur"];
            $_SESSION["prenom"] = $row["prenom"];

            header("Location: accueil.php");
        }
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Art Rental</title>
    <link rel="stylesheet" href="indexStyle.css" type="text/css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@300;400;500;600;700;800;900&display=swap"
          rel="stylesheet">
    <link rel="icon" type="image/png" href="./artRental.png" />

</head>

<body>
<div class="card">
    <div class="title"> ART RENTAL </div>
    <img src="./joconde.jpg" alt="La Joconde" class="joconde">
    <div class="spaceButton">
        <form method="post" action="">

            <input type="email" id="email" name="email" placeholder="Email" required value="<?php echo $erreur ?>">
            <input type="password" id="password" name="password" placeholder="Mot de passe" value="" required>
            <button type="submit">CONNECTION</button>
        </form>
        <a href="./compte.php"><button>CREER UN COMPTE</button></a>
    </div>
</div>
</body>

</html>
