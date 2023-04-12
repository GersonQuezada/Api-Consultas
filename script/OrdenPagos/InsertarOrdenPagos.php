<?php
	require_once('../coneccion.php'); //se realiza la coneccion
 	$cnn =new Modelador();
	$dbh = $cnn->conexion(); 
	$sql_vars = array();
	$sql_vars['a1'] = $_POST['CodRegion']; 
	$sql_vars['a2'] = $_POST['NomRegion'];
	$sql_vars['a3'] = $_POST['CodBanco'];
	$sql_vars['a4'] = $_POST['Banco'];
	$sql_vars['a5'] = $_POST['CodAnillo'];
	$sql_vars['a6'] = $_POST['Anillo'];
	$sql_vars['a7'] = $cnn->DateYear($_POST['FECHAPROCESO']);
	$statement = $dbh->prepare($cnn->_Insertar_Orden_Pagos($sql_vars));	
	if($statement->execute()){
		echo 1;
	}else{
        print_r($statement->errorInfo());
    }

 