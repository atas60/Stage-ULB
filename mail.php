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


 $req = $bdd->query('SELECT `chercheur`.`nom`, `chercheur`.`prenom`, `chercheur`.`mail` FROM chercheur, u_chercheur where u_id =?  AND c_id=id '); 
 $req->execute(array($_GET['e_id']));



$reqdeux = $bdd->query('SELECT `projet`.`nom`, `projet`.`description` FROM projet, u_projet where up_id=? AND `u_projet`.`p_id`=`projet`.`p_id` '); 
$reqdeux->execute(array($_GET['e_id']));
   


 $file = "test.txt";
 $fecrit = fopen($file, 'w') or die ("s'ouvre pas");
 
 while ($resultat = $req->fetch()) {

    $info = $resultat["nom"]."\n".$resultat["prenom"]."\n".$resultat["mail"]."\n";


     while ( $resultatd =$reqdeux->fetch()){ 

    $infos = $resultatd["nom"]."\n".$resultatd["description"]."\n";

    fwrite($fecrit,$infos);
    }
    fwrite($fecrit,$info);

 }

 fclose($fecrit);

 ?>
