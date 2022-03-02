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
$unite=$_GET['mel'];

    $respocount = $bdd->prepare(" SELECT  COUNT(nom) as num FROM `chercheur`, `u_chercheur` where `u_chercheur`.`u_id`='$unite' AND `u_chercheur`.`uc_respo`='respo' AND `u_chercheur`.`c_id`=`chercheur`.`id` "); // on prepare la requete     
    $respocount->execute(array($_GET['mel']));
    $rescompteur = $respocount->fetchall();

    $respounite = $bdd->prepare(" SELECT DISTINCT `chercheur`.`nom` as cnom, `chercheur`.`prenom` as cpre, `chercheur`.`mail` as mail FROM `chercheur`, `u_chercheur` where `u_chercheur`.`u_id`='$unite' AND `u_chercheur`.`uc_respo`='respo' AND `u_chercheur`.`c_id`=`chercheur`.`id`"); // on prepare la requete     
    $respounite->execute(array($_GET['mel']));
    $respous = $respounite->fetchall();

    $norespounite = $bdd->prepare("SELECT DISTINCT `chercheur`.`nom` as cnom, `chercheur`.`prenom` as cpre, `chercheur`.`mail` as mail FROM `chercheur`, `u_chercheur` where `u_chercheur`.`u_id`='$unite' AND `u_chercheur`.`uc_respo`='norespo' AND `u_chercheur`.`c_id`=`chercheur`.`id`"); // on prepare la requete     
    $norespounite->execute(array($_GET['mel']));
    $norespous = $norespounite->fetchall();

    $norespocount = $bdd->prepare("SELECT  COUNT(nom) as num FROM `chercheur`, `u_chercheur` where `u_chercheur`.`u_id`='$unite' AND `u_chercheur`.`uc_respo`='norespo' AND `u_chercheur`.`c_id`=`chercheur`.`id` "); // on prepare la requete     
    $norespocount->execute(array($_GET['mel']));
    $norescompteur = $norespocount->fetchall();

    $req = $bdd->prepare("SELECT nom, `description`,`projet`.`p_id` as proid FROM `u_projet`,`projet` WHERE `u_projet`.`p_id`=`projet`.`p_id` AND `u_projet`.`up_id`='$unite'"); // on prepare la requete     
    $req->execute(array($_GET['mel']));
    $project = $req->fetchall();

    $reqs = $bdd->prepare("SELECT COUNT(nom) as pronum FROM `u_projet`,`projet` WHERE `u_projet`.`p_id`=`projet`.`p_id` AND `u_projet`.`up_id`='$unite'"); // on prepare la requete     
    $reqs->execute(array($_GET['mel']));
    $cptproject = $reqs->fetchall();

    $reqpro = $bdd->prepare("SELECT  `chercheur`.`nom` as cnom, `projet`.`p_id` as pro FROM `chercheur`, `p_chercheur`, `projet`, `u_projet`, `u_chercheur` where `u_projet`.`up_id`='$unite' AND `u_chercheur`.`u_id`='$unite' AND `u_projet`.`p_id`=`projet`.`p_id` AND `p_chercheur`.`p_id`=`projet`.`p_id` AND `chercheur`.`id`=`p_chercheur`.`c_id` AND `p_chercheur`.`pp_respo`='respo' AND `u_chercheur`.`c_id`=`chercheur`.`id` "); // on prepare la requete     
    $reqpro->execute(array($_GET['mel']));
    $respros = $reqpro->fetchall();

    $reqa = $bdd->prepare("SELECT  COUNT(`chercheur`.`nom`) as procpt FROM `chercheur`, `p_chercheur`, `projet`, `u_projet`, `u_chercheur` where `u_projet`.`up_id`='$unite' AND `u_chercheur`.`u_id`='$unite' AND `u_projet`.`p_id`=`projet`.`p_id` AND `p_chercheur`.`p_id`=`projet`.`p_id` AND `chercheur`.`id`=`p_chercheur`.`c_id` AND `p_chercheur`.`pp_respo`='respo' AND `u_chercheur`.`c_id`=`chercheur`.`id` "); // on prepare la requete     
    $reqa->execute(array($_GET['mel']));
    $cptp = $reqa->fetchall();

    $noreqpro = $bdd->prepare("SELECT  `chercheur`.`nom` as cnom, `projet`.`p_id` as pro FROM `chercheur`, `p_chercheur`, `projet`, `u_projet`, `u_chercheur` where `u_projet`.`up_id`='$unite' AND `u_chercheur`.`u_id`='$unite' AND `u_projet`.`p_id`=`projet`.`p_id` AND `p_chercheur`.`p_id`=`projet`.`p_id` AND `chercheur`.`id`=`p_chercheur`.`c_id` AND `p_chercheur`.`pp_respo`='norespo' AND `u_chercheur`.`c_id`=`chercheur`.`id` "); // on prepare la requete     
    $noreqpro->execute(array($_GET['mel']));
    $norespros = $noreqpro->fetchall();

    $noreqa = $bdd->prepare("SELECT  COUNT(`chercheur`.`nom`) as noprocpt FROM `chercheur`, `p_chercheur`, `projet`, `u_projet`, `u_chercheur` where `u_projet`.`up_id`='$unite' AND `u_chercheur`.`u_id`='$unite' AND `u_projet`.`p_id`=`projet`.`p_id` AND `p_chercheur`.`p_id`=`projet`.`p_id` AND `chercheur`.`id`=`p_chercheur`.`c_id` AND `p_chercheur`.`pp_respo`='norespo' AND `u_chercheur`.`c_id`=`chercheur`.`id` "); // on prepare la requete     
    $noreqa->execute(array($_GET['mel']));
    $nocptp = $noreqa->fetchall();

$file = "test.txt";
$fecrit = fopen($file, 'w') or die ("s'ouvre pas");

$c=$rescompteur[0]['num'];
if ($c==1) $infos ="le responsale de l'unité '$unite'  : "."\n";
if ($c>1)  $infos ="les responsales de l'unité '$unite'  : "."\n";
fwrite($fecrit,$infos);
foreach ($respous as $respou):
    $in = $respou['cnom']." ".$respou['cpre']." ".$respou['mail']."\n";
    fwrite($fecrit,$in);
endforeach;

$cp=$norescompteur[0]['num'];
if ($cp==1) $noinfos ="\n"."le chercheur de l'unité '$unite'  : "."\n";
if ($cp>1)  $noinfos ="\n"."les chercheurs de l'unité '$unite'  : "."\n";
fwrite($fecrit,$noinfos);
foreach ($norespous as $norespou):
    $noin = $norespou['cnom']." ".$norespou['cpre']." ".$norespou['mail']."\n";
    fwrite($fecrit,$noin);
endforeach;

$cpro=$cptproject[0]['pronum'];
if ($cpro==1) $pr ="\n"."Le projet qui appartient à l'unité : "."\n";
if ($cpro>1)  $pr ="\n"."Les projets qui appartiennent à l'unité : "."\n";
fwrite($fecrit,$pr);
foreach ($project as $projec):
    $projetinfo = " Id numéro = ".$projec['proid'].","." ".$projec['nom'].","." description du projet : ".$projec['description']."\n";
    fwrite($fecrit,$projetinfo);
endforeach;

$cpt=$cptp[0]['procpt'];
if ($cpt==1) $p ="\n"."Le responsable de projet : "."\n";
if ($cpt>1)  $p ="\n"."Les responsables des projets  : "."\n";
fwrite($fecrit,$p);
foreach ($respros as $respro):
    $cher =$respro['cnom']." "."responsable du projet"." ".$respro['pro']."\n";
    fwrite($fecrit,$cher);
endforeach;

$nocpt=$nocptp[0]['noprocpt'];
if ($nocpt==1) $nop ="\n"."Le chercheur qui travail dans le projet : "."\n";
if ($nocpt>1)  $nop ="\n"."Les chercheurs qui travaillent dans les projets  : "."\n";
fwrite($fecrit,$nop);
foreach ($norespros as $norespro):
    $nocher =$norespro['cnom']." "."travaille dans le projet"." ".$norespro['pro']."\n";
    fwrite($fecrit,$nocher);
endforeach;

 fclose($fecrit);
  ?>
