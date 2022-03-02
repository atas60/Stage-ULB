<?php
try 
 {
     // connexion bdd + catch erreur
     $bdd = new PDO('mysql:host=localhost;dbname=users;charset=utf8', 'root', '',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
 }
 catch(PDOException $e)
 {
     die('Erreur : '.$e->getMessage());

 }
 //changer le nom de de la base de données ... TABLE_SCHEMA='nom_base_de_données'...
 $req = $bdd->query("SELECT distinct(TABLE_NAME) from INFORMATION_SCHEMA.STATISTICS where TABLE_SCHEMA ='users'");

?> 
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="tab.css">
	<title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body>
	<table class="table thead-dark">
		<thead >
<?php while ($resultat = $req->fetch()) {



	
	$x= $resultat["TABLE_NAME"];
    $toute=$bdd->prepare("SELECT COUNT(FOUND_ROWS()) as tcpt FROM `$x`");
    $toute->execute(); 
    $tablecompter = $toute->fetchAll();
    $tttable = number_format($tablecompter[0]['tcpt'],0,",",".");


     echo "<tr><th id='tnom'>".$resultat["TABLE_NAME"]."  nombre d'enregistrement : ".$tttable."</th></tr>"; 
 "</thead>";
 "<br/>";



$reqdeux = $bdd->query("SELECT distinct(TABLE_NAME) as tab, column_name as col FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='users' and table_name='$x'");
while ($resul = $reqdeux->fetch()) {
    echo " <tr ><td id='id'>".$resul["col"]."</td></tr>"; 
	$nomcol=$resul["col"];





		$conda=$bdd->prepare("SELECT COUNT(`$nomcol`) as mel FROM `$x` WHERE `$nomcol` REGEXP '[a-zA-Z0-9_ \- \.]+[@][a-z]+[\.][a-z]{2,8}[\.][a-z]{2,8}'");
        $conda->execute(); 
        $testa = $conda->fetchAll();
        $compta = number_format($testa[0]['mel'],0,",",".");
        if($compta>1) echo "<tr><td>"."Il y a ".$compta." email sur cette colonne"."</td></tr>";

        $condb=$bdd->prepare("SELECT COUNT(`$nomcol`) as vide FROM `$x` where length(`$nomcol`)=0");
        $condb->execute(); 
        $testb = $condb->fetchAll();
        $comptb = number_format($testb[0]['vide'],0,",",".");
        if($comptb>=1) echo "<tr><td>"."Nombre de champ vide :  ".$comptb."</td></tr>";

        $condc=$bdd->prepare("SELECT COUNT($nomcol) as lettre FROM `$x` WHERE `$nomcol` REGEXP '[A-Z]{3}[0-9]{3}'");
        $condc->execute(); 
        $testc = $condc->fetchAll();
        $comptc = $testc[0]['lettre'];
        if($comptc>=1) echo "<tr><td>"."Il y a ".$comptc." caractere qui commence avec trois majuscules et ensuite trois chiffres exemple : ULB001 "."</td></tr>";
        if($comptb==0) echo "<tr><td>"."Champ toujours remplis "."</td></tr>";

        $conde=$bdd->prepare("SELECT DATA_TYPE as datanom, CHARACTER_MAXIMUM_LENGTH as maxcara, NUMERIC_PRECISION as prenum FROM INFORMATION_SCHEMA.COLUMNS WHERE column_name='$nomcol' and table_name='$x' ");
        $conde->execute(); 
        $teste = $conde->fetchAll();
        $compte = $teste[0]['datanom'];
        $cara=number_format($teste[0]['maxcara'],0,",","."); 
        $numer=number_format($teste[0]['prenum'],0,",",".");
        if($compte=='int') echo "<tr><td>"." Contient des chiffres, "."integer : ".$numer."</td></tr>";
        if($compte=='varchar') echo "<tr><td>"." Contient du texte, "."Varchar : ".$cara."</td></tr>";
        if($compte=='date') echo "<tr><td>"." Contient une date "."</td></tr>";

        if ($compte=='int'){

            $condhint=$bdd->prepare("SELECT min(`$nomcol`) as mini FROM `$x` ");
            $condhint->execute(); 
            $testhint = $condhint->fetchAll();
            $compthint = number_format($testhint[0]['mini'],0,",",".");;
             echo "<tr><td>"."Le nombre minimum : ".$compthint."</td></tr>";

             $condg=$bdd->prepare("SELECT max(`$nomcol`) as max FROM `$x` ");
             $condg->execute(); 
             $testg = $condg->fetchAll();
             $comptg = number_format($testg[0]['max'],0,",",".");
             if($comptg>1) echo "<tr><td>"."Le nombre maximum : ".$comptg."</td></tr>";
 
             $condf=$bdd->prepare("SELECT AVG(`$nomcol`) as moyenne FROM `$x` ");
             $condf->execute(); 
             $testf = $condf->fetchAll();
             $comptf = number_format($testf[0]['moyenne'] ,2,",",".");
             if($comptf>1) echo "<tr><td>"."La moyenne est de ".$comptf."</td></tr>";


             $condj=$bdd->prepare("SELECT min(length(`$nomcol`)) as lengthmin FROM `$x` ");
             $condj->execute(); 
             $testj = $condj->fetchAll();
             $comptj = $testj[0]['lengthmin'];
             

            $condiint=$bdd->prepare("SELECT max(length(`$nomcol`)) as lengthmax FROM `$x` ");
            $condiint->execute(); 
            $testiint = $condiint->fetchAll();
            $comptiint = $testiint[0]['lengthmax'];
            if($comptiint==$comptj){
                echo "<tr><td>"."Remplissage du champs maximum et minimum : ".$comptj."</td></tr>";
            }else{
            echo "<tr><td>"."Remplissage du champs minimum : ".$comptj."</td></tr>";
            echo "<tr><td>"."Remplissage du champs maximum : ".$comptiint."</td></tr>";
            }//fin min et max si égale


        }//Fin codition if integer

        if ($compte=='date' or $compte=='varchar'){

            $condj=$bdd->prepare("SELECT min(length(`$nomcol`)) as lengthmin FROM `$x` ");
            $condj->execute(); 
            $testj = $condj->fetchAll();
            $comptj = $testj[0]['lengthmin'];
            

            $condi=$bdd->prepare("SELECT max(trim(length(`$nomcol`))) as lengthmax FROM `$x` ");
            $condi->execute(); 
            $testi = $condi->fetchAll();
            $compti = $testi[0]['lengthmax'];

            if($compti==$comptj) {
                echo "<tr><td>"."Remplissage du champs maximum et minimum : ".$compti."</td></tr>";
            }else{
            echo "<tr><td>"."Remplissage du champs minimum : ".$comptj."</td></tr>";
            echo "<tr><td>"."Remplissage du champs maximum : ".$compti."</td></tr>";
            
            }

            if ($compte=='date'){
            $date=$bdd->prepare("SELECT min(`$nomcol`) as lengthmin FROM `$x` where `$nomcol` != 0");
            $date->execute(); 
            $adate = $date->fetchAll();
            $alldate = $adate[0]['lengthmin'];
            echo "<tr><td>"."Date minimum : ".$alldate."</td></tr>";

            $date=$bdd->prepare("SELECT max(`$nomcol`) as lengthmin FROM `$x` ");
            $date->execute(); 
            $adate = $date->fetchAll();
            $alldate = $adate[0]['lengthmin'];
            echo "<tr><td>"."Date max : ".$alldate."</td></tr>";

            }//fin date if


        }//fin deuxieme if
    }
 }
 //SELECT COUNT(Idprojet) FROM `zprojet` 

//SELECT COUNT(Idunite) FROM zunite WHERE Idunite REGEXP '[A-Z]{3}[0-9]{3}'
 //SELECT LENGTH(Nom),Nom FROM `zprojet`
 /*SELECT COLUMN_NAME,
 DATA_TYPE,
 IS_NULLABLE,
 CHARACTER_MAXIMUM_LENGTH,
 NUMERIC_PRECISION,
 NUMERIC_SCALE
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_NAME='zprojet';*/
 ?>
 </table>
</body>
</html>






