<?php
	require_once('../coneccion.php'); //se realiza la coneccion
	// $_JsonData = $_POST['post'];
	$cnn =new Modelador();
	$dbh = $cnn->conexion();
	$sql_vars = array();
 
    $sql_vars['a1'] = $_POST['CODREGION'];
    $sql_vars['a2'] = $_POST['REGION'];
    $sql_vars['a3'] = $_POST['CODASOCIACION'];
    $sql_vars['a4'] = $_POST['DESASOCIACION'];
    $sql_vars['a5'] = $_POST['CODSOCIA'];
    $sql_vars['a6'] = $_POST['APELLIDOSNOMBRES'];
    $sql_vars['a7'] = $_POST['NUMCREDITO'];
    $sql_vars['a8'] = $_POST['PRODUCTO'];
    $sql_vars['a9'] = $_POST['NRODNI'];
    $sql_vars['a10'] = $_POST['CELULAR'];
    $sql_vars['a11'] = $_POST['MTOADICIONAL'];
    $sql_vars['a12'] = $_POST['MTODESEMBOLSADO'];
    $sql_vars['a13'] = $_POST['REPROGRAMACION'];
    $sql_vars['a14'] = $_POST['FECHADESEMBOLSO'];
    $sql_vars['a15'] = $_POST['FECHAPROCESO'];
    $sql_vars['a16'] = $_POST['ENTIDADBANCARIA'];
    $sql_vars['a17'] = $_POST['CARGATABLA'];
    $sql_vars['a18'] = 'DE';

    //     $sql_vars['a1'] = "005";
    // $sql_vars['a2'] = 'LA LIBERTAD';
    // $sql_vars['a3'] = '0050000037';
    // $sql_vars['a4'] = 'ALFA Y OMEGA';
    // $sql_vars['a5'] = '0050000637';
    // $sql_vars['a6'] = 'CASTRO DE LOZANO PETRONILA I';
    // $sql_vars['a7'] = '99999999';
    // $sql_vars['a8'] = 'DEV AHORRO';
    // $sql_vars['a9'] = '19087084';
    // $sql_vars['a10'] = '914169896';
    // $sql_vars['a11'] = '100';
    // $sql_vars['a12'] = '200';
    // $sql_vars['a13'] = 'S';
    // $sql_vars['a14'] = '01-08-2020';
    // $sql_vars['a15'] = '04-08-2020';
    // $sql_vars['a16'] = 'BIM';
    // $sql_vars['a17'] = 'N';
    // $sql_vars['a18'] = 'DA';
  // $sql_vars['a1'] = "04-06-2020";
  // $sql_vars['a2'] = "002"; 
  // $sql_vars['a3'] = "48315584"; 
  // $sql_vars['a4'] = '368.00';
  
	$statement = $dbh->prepare($cnn->_GuardaSocia_DA_Bim($sql_vars));
 	 if ( $statement->execute())
 	 {	
 	 $rt['dato'] = $statement->fetchall(PDO::FETCH_ASSOC);;
	 print_r(json_encode($rt['dato']));
 	}else{
 		$rt = ["3"];
 		print_r($statement->errorInfo());
 	}