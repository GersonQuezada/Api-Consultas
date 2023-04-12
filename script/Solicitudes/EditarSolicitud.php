<?php
	require_once('../coneccion.php'); //se realiza la coneccion
 	$cnn =new Modelador();
	$dbh = $cnn->conexion();  
	$sql_vars = array();
	$sql_vars['a1'] = $_POST['RG']; 
	$sql_vars['a2'] =  $_POST['fecha'];
	// $sql_vars['a2'] = '22-04-2021';
	// //$sql_vars['a2'] = '22-04-2021';
	$sql_vars['a3'] = $_POST['NR'];
	$sql_vars['a4'] = $_POST['BN'];
	$sql_vars['a5'] = $_POST['BC'];
	$sql_vars['a6'] = $_POST['BM'];
	$sql_vars['a7'] = $_POST['CT'];
	$sql_vars['a8'] = $_POST['CP'];
	$sql_vars['a9'] = $_POST['CS'];
	$sql_vars['a10'] = $_POST['EF'];		
	$sql_vars['a11'] = $cnn->Dateformat($_POST['FA']);
	$sql_vars['a12'] = $_POST['banco']; 
	$sql_vars['a13'] = $_POST['DT'];
	$sql_vars['a14'] = $_POST['DP'];
	$sql_vars['a15'] = $_POST['DD'];
 
	$statement = $dbh->prepare($cnn->_Update_Solicitud_banco_comunal_($sql_vars));	
		if($statement->execute()){
			$rt['data'] = $statement->fetchall(PDO::FETCH_ASSOC);    
			echo(json_encode($rt)) ;
		}else{

			print_r($statement->errorInfo());
		}
	
 