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
 $req = $bdd->query("SELECT `chercheur`.`nom`, `chercheur`.`prenom`, `chercheur`.`mail` FROM chercheur, u_chercheur where `u_chercheur`.`u_id` = 'ULB001' AND `u_chercheur`.`c_id`=`chercheur`.`id` "); 
 $reqdeux = $bdd->query("SELECT `projet`.`nom`, `projet`.`description` FROM projet, u_projet where `u_projet`.`up_id`='ULB001' AND `u_projet`.`p_id`=`projet`.`p_id` "); 

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



 //$results = $sth->fetchAll(PDO::FETCH_OBJ);



//SELECT `chercheur`.`nom` as cnom, `chercheur`.`prenom` as cpre, `chercheur`.`mail` as mail, `projet`.`nom` as pnom, `projet`.`description` as pdes FROM `chercheur`, `p_chercheur`, `projet`, `u_projet`, `u_chercheur` where `u_projet`.`up_id`=?=`u_chercheur`.`u_id` AND `u_chercheur`.`uc_respo`="respo" AND `u_projet`.`p_id`=`projet`.`p_id` AND `p_chercheur`.`p_id`=`projet`.`p_id` AND `chercheur`.`id`=`p_chercheur`.`c_id` AND `p_chercheur`.`pp_respo`="respo" AND `u_chercheur`.`c_id`=`chercheur`.`id` 
 //SELECT COALESCE `chercheur`.`nom`, `chercheur`.`prenom`, `chercheur`.`mail`,  `projet`.`nom`, `projet`.`description` FROM `chercheur`

//LEFT JOIN `u_chercheur` ON `u_chercheur`.`c_id`=`chercheur`.`id` 
//LEFT JOIN `p_chercheur` ON `p_chercheur`.`c_id`=`chercheur`.`id`
//LEFT JOIN `projet` ON `projet`.`p_id`=`p_chercheur`.`p_id`
//LEFT JOIN `u_projet` ON `u_projet`.`p_id`=`projet`.`p_id`
//LEFT JOIN `unite_de_recherche` ON `u_projet`.`up_id`=`unite_de_recherche`.`id`
//where `u_chercheur`.`u_id` = 'ULB001' AND `u_projet`.`up_id` ='ULB001'






  
 // PHPMailer\PHPMailer\Exception: Message body empty in C:\wamp64\www\test\includes\PHPMailer.php on line 1579
 ?>
