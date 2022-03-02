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
    if(isset($_GET['pu_id'])){
    $obj = $bdd->prepare('SELECT * FROM projet where p_id = ?');

    $obj->execute(array($_GET['pu_id'])); // on execute la requete
    $projets = $obj->fetchall();
    }
     // var_dump() affiche les info de cher

     if(isset($_GET['pu_id'])){
        $cpt = $bdd->prepare('SELECT COUNT(c_id) as total FROM `p_chercheur` WHERE `p_id`=? AND `pp_respo`="respo"');
        $cpt->execute(array($_GET['pu_id'])); // on execute la requete
        $compteurs = $cpt->fetchall();
        
        }

        if(isset($_GET['pu_id'])){
            $cpta = $bdd->prepare('SELECT COUNT(c_id) as tot FROM `p_chercheur` WHERE `p_id`=? AND `pp_respo`="norespo"');
            $cpta->execute(array($_GET['pu_id'])); // on execute la requete
            $comptdeux = $cpta->fetchall();
            
            }

     if(isset($_GET['pu_id'])){
        $req = $bdd->prepare('SELECT * FROM `p_chercheur`, `projet`, `chercheur` WHERE `p_chercheur`.`p_id` =? AND `p_chercheur`.`pp_respo`="respo" AND `p_chercheur`.`c_id`=`chercheur`.`id` AND `p_chercheur`.`p_id`=`projet`.`p_id`');
        $req->execute(array($_GET['pu_id'])); // on execute la requete
        $responsables = $req->fetchall();
        }


        if(isset($_GET['pu_id'])){
            $reqa = $bdd->prepare('SELECT * FROM `p_chercheur`, `projet`, `chercheur` WHERE `p_chercheur`.`p_id` =? AND `p_chercheur`.`pp_respo`="norespo" AND `p_chercheur`.`c_id`=`chercheur`.`id` AND `p_chercheur`.`p_id`=`projet`.`p_id`');
            $reqa->execute(array($_GET['pu_id'])); // on execute la requete
            $nonrespos = $reqa->fetchall();
            }


        if(isset($_GET['pu_id'])){
            $reqs = $bdd->prepare('SELECT * FROM `unite_de_recherche`, `u_projet` WHERE `u_projet`.`p_id`=? AND `unite_de_recherche`.`id`=`u_projet`.`up_id`');
        
            $reqs->execute(array($_GET['pu_id'])); // on execute la requete
            $unites = $reqs->fetchall();
            }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="liste.css">
</head>
<body>
    <ul>

        <?php foreach ($projets as $projet): ?>

            <li>
            <h1><?= $projet['nom'] ?> numero <?= $projet['p_id'] ?> <?= $projet['description'] ?></h1>
            </li>
            <?php endforeach; ?>

            <br /><br />

<?php 
$compt = $compteurs[0]['total'];
if ($compt==1) echo "Le reponsable est :";
if ($compt>1) echo "Les reponsable sont :";
?>
<br />
            <?php foreach ($responsables as $responsable): ?>

                <a href="respodetail.php?cu_id=<?= $responsable['c_id']?>"> <?= $responsable['nom'] ?> <?= $responsable['prenom'] ?></a><br />
           <?php endforeach; ?><br /><br />


<?php 
$c = $comptdeux[0]['tot'];
if ($c==1)echo "Le chercheur qui travail sur le projet :";
if ($c>1)echo "Les chercheur qui travaillent sur le projet sont:";
?>

            <br />
            <?php foreach ($nonrespos as $nonrespo): ?>
            <a href="respodetail.php?cu_id=<?= $nonrespo['c_id']?>"> <?= $nonrespo['nom'] ?> <?= $nonrespo['prenom'] ?> </a> <br />
            <?php endforeach; ?>
            <br /><br />



            nom de l'unité de recherche : <br />
            <?php foreach ($unites as $unite): ?>
                <a href="respounite.php?id=<?= $unite['id'] ?>"> <?= $unite['nom'] ?> </a> <br />
            <?php endforeach; ?>

    </ul>
    
</body>
</html>

