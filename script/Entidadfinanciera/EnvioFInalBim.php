<?php
	require_once('../coneccion.php'); //se realiza la coneccion
	// $_JsonData = $_POST['post'];
	$cnn =new Modelador();
	$dbh = $cnn->conexion();
	$sql_vars = array();
  	$sql_vars['a1'] = $cnn->Dateformat($_POST['fechaProceso']);

	#$sql_vars['a3'] = $_JsonData['tipoimporte']; #nada mas ya chebre
	// $sql_vars['a1'] = '26-06-2020';
	// $sql_vars['a2'] = '002';
 //  $sql_vars['a3'] = '0070100090059476';
	$statement = $dbh->prepare($cnn->_Ope_proc_Socias_envio_Final_bim($sql_vars));
	$statement2 = $dbh->prepare($cnn->_Ope_selec_Socias_envio_Final_bim($sql_vars));
	$statement3 = $dbh->prepare($cnn->_Ope_sql_proc_Visualizacion_BIM_DJ($sql_vars));

	if($statement3->execute()){
		if($statement->execute()){
			if ( $statement2->execute()){	
	 			$rt['data'] = $statement2->fetchall(PDO::FETCH_ASSOC);
	        	echo json_encode($rt);
	 		}else{
		 		print_r($statement2->errorInfo());
	 		}
		}else{
			print_r($statement->errorInfo());
		}

	}
	else{
			print_r($statement3->errorInfo());
		}

 // 	