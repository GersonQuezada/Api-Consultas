<?php 
	require_once('../coneccion.php'); //se realiza la coneccion
 
		$cnn =new Modelador();
	$dbh = $cnn->conexion();
 
	$sql_vars = array();
	$sql_vars['a1'] = $cnn->Dateformat($_POST['fechaProceso']);
	$sql_vars['a2'] = $_POST['ComboBoxRegion'];
	$fecha = $cnn->DateTXT($_POST['fechaProceso']);

	// $sql_vars['a1'] = '24-06-2020'; 
	// $fecha = '20200626';
	$stm = $dbh->prepare($cnn->_Cont_sql_proc_Genera_Txt($sql_vars));

 	 if ( $stm->execute())
 	 {	
 	 	// $x= 1;
// if(isset($_POST["post"])){
	$salida = 'PROVEEDORES'.$fecha.'.txt';
	header('Content-Type: text/plain');
	header('Content-Disposition: attachment;filename ='.$salida);
	header('Cache-Control: no-cache, no-store, must-revalidate');
	header('Pragma: no-cache');
	header('Expires: 0');
	$output = fopen('php://output', 'w');

	
	$row = $stm->fetchall(PDO::FETCH_ASSOC);
	$lengt = count($row);
	$x= 1;
	foreach ($row as $reglon) {	
		if($x === 1){
			 fwrite($output, $reglon['Campo']."\r\n");
			// echo "primero";
		}else if ($x === $lengt){
			 fwrite($output, $reglon['Campo']);
			// echo "ultimo";
		}else{
					// echo "intermedio";
					fwrite($output, $reglon['Campo']."\r\n");
		}
		$x++;

		// fwrite($output, $reglon['Campo']."\r\n");
	}
	fclose($output);
		exit;
}else{
 		print json_encode($stm->errorInfo());
 	}

 ?>


