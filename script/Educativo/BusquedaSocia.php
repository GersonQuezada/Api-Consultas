<?php
	require_once('../coneccion.php'); //se realiza la coneccion
 	$cnn =new Modelador();
	$dbh = $cnn->conexion();
	$sql_vars = array();
	$sql_vars['a1'] = $_POST['name'];
	$sql_vars['a2'] = $cnn->DateMonth($_POST['fecha']); 
	$sql_vars['a3'] = $cnn->DateYear($_POST['fecha']);
	// $sql_vars['a1'] = 'emprendedoras';
	// $sql_vars['a2'] = 'BC'; 
	$statement = $dbh->prepare($cnn->_Busqueda_Socia_Asistencia_taller($sql_vars));	
	if($statement->execute()){	
		$data = [];
	  while ($row = $statement->fetch(PDO::FETCH_ASSOC)){		
		$id = $row['CODSOCIA'];
		$name = $row['socia'];
		$data[] = array('id'=>$id,'text'=>$name);
		
	  } 
	  echo json_encode($data);
	}else{
 		print_r ('Error de Ejecucion');
 	} 

