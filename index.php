<?php 

    try 
    {
        // connexion bdd + catch erreur
        $bdd = new PDO('mysql:host=localhost;dbname=uni;charset=utf8', 'root', '',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    catch(PDOException $e)
    {
        die('Erreur : '.$e->getMessage());
    }

    $obj = $bdd->prepare('SELECT * FROM unite_de_recherche');
    $check = $obj->execute(); // on execute la requete
    $unites = $obj->fetchall(); // on les recuperes
    ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
		
	</style>
    <link rel="stylesheet" href="liste.css">
</head>
<body>
    <ul>
        <?php foreach ($unites as $unite): ?>

            <li>
            <a href="respounite.php?id=<?= $unite['id']?>"> <?= $unite['nom']?> </a><br />Description de l'unité : <?= $unite['description'] ?>
            <a href="email.php?mel=<?= $unite['id']?>"> <button>fichier info de l'unité</button> </a>
            </li>
            <?php endforeach; ?>

    </ul>
    
</body>
</html>