<?php   
$hostname = "34.139.80.38";
$dbname = "BD_CONSULTAS";
$username = "app_credimujer";
$pw = 'AONKN1DtrR';
$dbh = new PDO ("sqlsrv:Server=$hostname;Database=$dbname","$username","$pw");
    if($dbh){
        echo "Conectado";
    }else{
        echo "No conectado";
    }        
return($dbh);