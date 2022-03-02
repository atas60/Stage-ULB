<?php  
$bdd = new PDO('mysql:host=localhost;dbname=uni;charset=utf8', 'root', '',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
//info chercheur
if(isset($_GET['cu_id'])){
    $obj = $bdd->prepare('SELECT * FROM chercheur where id = ? '); // on prepare la requete 
    $obj->execute(array($_GET['cu_id'])); // on execute la requete
    $respos = $obj->fetchall(); // on les recuperes avec les parametres qui lui sont transmos

}else{
    die('Erreur');
}

//respo du projet
if(isset($_GET['cu_id'])){
    $req = $bdd->prepare('SELECT * FROM `p_chercheur`, `projet` WHERE `p_chercheur`.`c_id`=? AND `projet`.`p_id`=`p_chercheur`.`p_id` AND `pp_respo`="respo" '); // on prepare la requete 
    $req->execute(array($_GET['cu_id'])); // on execute la requete
    $respoprojets = $req->fetchall(); // on les recuperes avec les parametres qui lui sont transmos

}else{
    die('Erreur');
}
//nonrespo du projet
if(isset($_GET['cu_id'])){
    $reqa = $bdd->prepare('SELECT * FROM `p_chercheur`, `projet` WHERE `p_chercheur`.`c_id`=? AND `projet`.`p_id`=`p_chercheur`.`p_id` AND `pp_respo`="norespo"'); // on prepare la requete 
    $reqa->execute(array($_GET['cu_id'])); // on execute la requete
    $respoprojetsdeux = $reqa->fetchall(); // on les recuperes avec les parametres qui lui sont transmos

}else{
    die('Erreur');
}

if(isset($_GET['cu_id'])){
    $reqb = $bdd->prepare('SELECT * FROM `u_chercheur`, `unite_de_recherche` WHERE `u_chercheur`.`c_id`=? AND `uc_respo`="respo" AND `u_chercheur`.`u_id`=`unite_de_recherche`.`id`'); // on prepare la requete 
    $reqb->execute(array($_GET['cu_id'])); // on execute la requete
    $respounites = $reqb->fetchall(); // on les recuperes avec les parametres qui lui sont transmos

}else{
    die('Erreur');
}

if(isset($_GET['cu_id'])){
    $reqbdeux = $bdd->prepare('SELECT * FROM `u_chercheur`, `unite_de_recherche` WHERE `u_chercheur`.`c_id`=? AND `uc_respo`="norespo" AND `u_chercheur`.`u_id`=`unite_de_recherche`.`id`'); // on prepare la requete 
    $reqbdeux->execute(array($_GET['cu_id'])); // on execute la requete
    $respononunites = $reqbdeux->fetchall(); // on les recuperes avec les parametres qui lui sont transmos

}else{
    die('Erreur');
}
if(isset($_GET['cu_id'])){
    $cpta = $bdd->prepare('SELECT count(p_id) as total FROM `p_chercheur` WHERE `c_id` = ? AND `pp_respo`="respo"');
    $cpta->execute(array($_GET['cu_id'])); // on execute la requete
    $compteur = $cpta->fetchall();
    }else{
        die('Erreur');
    }

    if(isset($_GET['cu_id'])){
        $cptb = $bdd->prepare('SELECT count(p_id) as total FROM `p_chercheur` WHERE `c_id` = ? AND `pp_respo`="norespo"');
        $cptb->execute(array($_GET['cu_id'])); // on execute la requete
        $compt = $cptb->fetchall();
        }else{
            die('Erreur');
        }

        if(isset($_GET['cu_id'])){
            $cptc = $bdd->prepare('SELECT count(u_id) as total FROM `u_chercheur` WHERE `c_id` = ? AND `uc_respo`="respo"');
            $cptc->execute(array($_GET['cu_id'])); // on execute la requete
            $comptunite = $cptc->fetchall();
            }else{
                die('Erreur');
            }
            if(isset($_GET['cu_id'])){
                $cptd = $bdd->prepare('SELECT count(u_id) as total FROM `u_chercheur` WHERE `c_id` = ? AND `uc_respo`="norespo"');
                $cptd->execute(array($_GET['cu_id'])); // on execute la requete
                $comptunites = $cptd->fetchall();
                }else{
                    die('Erreur');
                }



    ?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="liste.css">
    <title>Document</title>
</head>
<body>
    <ul>


<h1>Information sur le chercheur</h1>
    <?php foreach ($respos as $respo): ?>
        <table>

<thead>
    <tr>
    <td>Id</td>
    <td>Nom</td>
    <td>Prenom</td>
    <td>Email</td>
    </tr>
    </thead>

<br/>
<tbody>
    <tr>
    <td><?= $respo['id']?></td>
    <td><?= $respo['nom']?></td>
    <td><?= $respo['prenom']?></td>
    <td><?= $respo['mail']?></td>
    </tr> 
    </tbody>
    <?php endforeach; ?>
    </table>
    <br /><br />

    <?php 
$c= $compteur[0]['total'];
if ($c==1)  echo "Le chercheur est responsable du projet :";
if ($c>1) echo "Le chercheur est responsable des projets  :";
?> 
<br />
<?php foreach ($respoprojets as $respoprojet): ?>
<a href="projet.php?pu_id=<?= $respoprojet['p_id']?>"> <?= $respoprojet['nom']?> </a><br />
<?php endforeach; ?><br />
    <?php 
$cb= $compt[0]['total'];
if ($cb==1) echo "Le chercheur travail dans le projet :";
if ($cb>1) echo "Le chercheur travail dans les projets  :";
?>
<br />
<?php foreach ($respoprojetsdeux as $respoprojetsdeu): ?>
<a href="projet.php?pu_id=<?= $respoprojetsdeu['p_id']?>"> <?= $respoprojetsdeu['nom']?> </a><br />
<?php endforeach; ?><br /><br />
<?php 
$cc= $comptunite[0]['total'];
if ($cc==1) echo "Le chercheur est responsable de l'unité :";
if ($cc>1) echo "Le chercheur est responsables des unité  :";
?><br/>
    <?php foreach ($respounites as $respounite): ?>
        <a href="respounite.php?id=<?= $respounite['u_id'] ?>"> <?= $respounite['u_id']?> </a> <br />
    <?php endforeach; ?><br />
    <?php 
$cd= $comptunites[0]['total'];
if ($cd==1) echo "Le chercheur travail dans l'unité :";
if ($cd>1) echo "Le chercheur travail dans les unités  :";
?><br/>
    <?php foreach ($respononunites as $respononunite): ?>
        <a href="respounite.php?id=<?= $respononunite['u_id'] ?>"> <?= $respononunite['u_id']?> </a> <br />
    <?php endforeach; ?><br />


    Revenir à la page avec la liste des <a href="index.php">unités de recherche</a>








    </ul>
    
</body>
</html>