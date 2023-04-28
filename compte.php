<?php
$erreur = null;

if (isset($_POST["name"]) && isset($_POST["prenom"]) && isset($_POST["date"]) && isset($_POST["email"]) && isset($_POST["password"])) {
    try {
        $db = new PDO('mysql:host=localhost;dbname=oeuvredart;charset=utf8', 'root', '');

    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    $email = $_POST["email"];
    $query = 'SELECT * FROM utilisateur WHERE email = :email';
    $pdoStat = $db->prepare($query);
    $pdoStat->execute(['email' => $email]);
    $user = $pdoStat->fetch();

    if ($user) {
        $erreur = "L'e-mail existe déjà !";
    } else {
        $query = 'INSERT INTO utilisateur(nom, prenom, dateNaissance, email, motDePasse) values ( :nom, :prenom, :dateNaissance, :email, :motDePasse)';
        $pdoStat = $db->prepare($query);
        $executeIsOk = $pdoStat->execute([
            'nom' => $_POST["name"],
            'prenom' => $_POST["prenom"],
            'dateNaissance' => $_POST["date"],
            'email' => $_POST["email"],
            'motDePasse' => $_POST["password"]
        ]) or die(print_r($db->errorInfo()));
        $client = $pdoStat->fetch();
        header("Location: confirmation.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de compte</title>
    <link rel="stylesheet" href="compteStyle.css" type="text/css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@300;400;500;600;700;800;900&display=swap"
          rel="stylesheet">
    <link rel="icon" type="image/png" href="./artRental.png"/>
</head>

<body>
<div class="card">
    <div class="title"> INSCRIPTION</div>
    <img class="rembrandt" src="./rembrandt.jpg" alt="Portrait de Rembrandt">
    <form method="post" action="">
        <input type="text" name="name" id="name" placeholder="Nom" required>
        <input type="text" name="prenom" id="prenom" placeholder="Prenom" required>
        <input type="date" name="date" id="date" placeholder="Date de naissance" required>
        <input type="email" name="email" id="email" placeholder="Email" required value="<?php echo $erreur ?>">
        <input type="password" name="password" id="password" placeholder="Mot de passe" required>
        <button>INSCRIPTION</button>

    </form>
    <a href="./index.php">
        <button>RETOUR</button>
    </a>
</div>
</div>

</body>

</html>

