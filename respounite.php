<?php  
$bdd = new PDO('mysql:host=localhost;dbname=uni;charset=utf8', 'root', '',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
if(isset($_GET['id'])){
    $obj = $bdd->prepare('SELECT id, nom, prenom FROM chercheur, u_chercheur where `u_chercheur`.`u_id` = ? AND `u_chercheur`.`uc_respo`="respo" AND `u_chercheur`.`c_id`=`chercheur`.`id`  '); // on prepare la requete 
    $obj->execute(array($_GET['id'])); // on execute la requete
    $respos = $obj->fetchall(); // on les recuperes avec les parametres qui lui sont transmos

}else{
    die('Erreur');
}

if(isset($_GET['id'])){
    $obja = $bdd->prepare('SELECT id, nom, prenom FROM chercheur, u_chercheur where `u_chercheur`.`u_id` = ? AND `u_chercheur`.`uc_respo`="norespo" AND `u_chercheur`.`c_id`=`chercheur`.`id`  '); // on prepare la requete 
    $obja->execute(array($_GET['id'])); // on execute la requete
    $nonrespos = $obja->fetchall(); // on les recuperes avec les parametres qui lui sont transmos

}else{
    die('Erreur');
}
    ?>


<?php  
if(isset($_GET['id'])){
    $req = $bdd->prepare('SELECT distinct * FROM unite_de_recherche where id = ? '); // on prepare la requete 
    $req->execute(array($_GET['id'])); // on execute la requete
    $touts = $req->fetchall(); // on les recuperes avec les parametres qui lui sont transmos

}else{
    die('Erreur');
}
    ?>

<?php  
if(isset($_GET['id'])){
    $requete = $bdd->prepare('SELECT `nom`,`description`,`projet`.`p_id` FROM `projet`, `u_projet` WHERE `up_id`=? AND `projet`.`p_id`=`u_projet`.`p_id`  '); // on prepare la requete 
    $requete->execute(array($_GET['id'])); // on execute la requete
    $projetall = $requete->fetchall(); // on les recuperes avec les parametres qui lui sont transmos

}else{
    die('Erreur');
}

if(isset($_GET['id'])){
    $cpta = $bdd->prepare('SELECT DISTINCT count(uc_respo) as total FROM u_chercheur WHERE u_id = ? AND uc_respo="respo" ');
    $cpta->execute(array($_GET['id'])); // on execute la requete
    $comptdeux = $cpta->fetchall();
    }else{
        die('Erreur');
    }

    if(isset($_GET['id'])){
        $cptb = $bdd->prepare('SELECT DISTINCT count(uc_respo) as total FROM u_chercheur WHERE u_id = ? AND uc_respo="norespo"');
        $cptb->execute(array($_GET['id'])); // on execute la requete
        $compt = $cptb->fetchall();
        }else{
            die('Erreur');
        }

        if(isset($_GET['id'])){
            $cptc = $bdd->prepare('SELECT DISTINCT count(p_id) as tot FROM u_projet WHERE up_id = ? ');
            $cptc->execute(array($_GET['id'])); // on execute la requete
            $cptunit = $cptc->fetchall();
            }else{
                die('Erreur');
            }
    ?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="liste.css">
    <title>Document</title>
</head>
<body>




<ul>
    
    <?php foreach ($touts as $tout): ?>


       <h1> <li>
        <?= $tout['id']?> <?= $tout['nom']?> <?= $tout['description']?>
        </li></h1>
        <?php endforeach; ?>

        
<?php 
$c= $comptdeux[0]['total'];
if ($c==0)echo "pas de responsable  :";
if ($c==1)echo "Le responsable de cette unité :";
if ($c>1)echo "Les responsables de cette unité  :";
?>
 <br />
            <?php foreach ($respos as $respo): ?>
            <li>
            <a href="respodetail.php?cu_id=<?= $respo['id']?>"> <?= $respo['nom']?> <?= $respo['prenom']?></a> 
             </li>
            <?php endforeach; ?>

            <?php 
$cp= $compt[0]['total'];
if ($cp==0)echo "Pas de chercheur pour cette unité  :";
if ($cp==1)echo "Le chercheur pour cette unité :";
if ($cp>1)echo "Les chercheurs pour cette unité  :";
?>
 <br /> <br />
            <?php foreach ($nonrespos as $nonrespo): ?>

            <li>
            <a href="respodetail.php?cu_id=<?= $nonrespo['id']?>"><?= $nonrespo['nom'] ?> <?= $nonrespo['prenom'] ?></a> <br />
            </li>
            <?php endforeach; ?>

            <br />


            <?php 
$cb= $cptunit[0]['tot'];

if ($cb==0)echo "Pas de projet pour cette unité  :";
if ($cb==1)echo "Le projet pour cette unité  c'est :";
if ($cb>1)echo "Les projets pour cette unité  sont :";
?>
<?php foreach ($projetall as $projetone):  ?>

    <li><a href="projet.php?pu_id=<?=$projetone['p_id']?>"><?=$projetone['nom']?></a> 
    </li>

<?php endforeach; ?>

    </ul>
</body>
</html>