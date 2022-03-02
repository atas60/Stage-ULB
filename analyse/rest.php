<?php
session_start();
require_once 'config.php';


$req = $bdd->prepare("SELECT * FROM INFORMATION_SCHEMA.STATISTICS WHERE TABLE_SCHEMA='users'");
$req->execute(); 
$responsables = $req->fetchall();


foreach ($responsables as $responsable):

$responsable['TABLE_NAME']."\n";
 endforeach; 



?>