<?php
	require_once('../coneccion.php'); //se realiza la coneccion
	// $_JsonData = $_POST['post'];
	$cnn =new Modelador();
	$dbh = $cnn->conexion();
	$sql_vars = array();
 
    $sql_vars['a1'] = $_POST['FECHAPROCEBN'];
    $sql_vars['a2'] = $_POST['CODSOCIA'];
    $sql_vars['a3'] = $_POST['APELLIDOSNOMBRES'];
    $sql_vars['a4'] = $_POST['NRODNI'];
    $sql_vars['a5'] = $_POST['NROCICLO'];
    $sql_vars['a6'] = $_POST['CODREGION'];
    $sql_vars['a7'] = $_POST['CODMONEDA'];
    $sql_vars['a8'] = $_POST['CODENTIFINAN'];
    $sql_vars['a9'] = $_POST['TIPOCREDITO'];
    $sql_vars['a10'] = $_POST['MTOAPROBADO'];
    $sql_vars['a11'] = $_POST['MTODESEMBOLSADO'];
    $sql_vars['a12'] = $_POST['SITUACION'];
    $sql_vars['a13'] = $_POST['FECHAREGISTRO'];
    $sql_vars['a14'] = $_POST['FECHACREDITO'];
    $sql_vars['a15'] = $_POST['CODASOCIACION'];
    $sql_vars['a16'] = $_POST['DESASOCIACION'];
    $sql_vars['a17'] = $_POST['NROSOCIO'];
    $sql_vars['a18'] = $_POST['NROCREPERSONA']; 
 
    //  $sql_vars['a1'] = '04-08-2020';
    // $sql_vars['a2'] = '0070000127';
    // $sql_vars['a3'] = 'CARRERA MALCA VILMA';
    // $sql_vars['a4'] = '33589198';
    // $sql_vars['a5'] = '0';
    // $sql_vars['a6'] = '007';
    // $sql_vars['a7'] = '01';
    // $sql_vars['a8'] = '013406';
    // $sql_vars['a9'] = '0';
    // $sql_vars['a10'] = '4000.00';
    // $sql_vars['a11'] = '4000.00';
    // $sql_vars['a12'] = 'DE';
    // $sql_vars['a13'] = '04-08-2020';
    // $sql_vars['a14'] = '04-08-2020';
    // $sql_vars['a15'] = '0070010416';
    // $sql_vars['a16'] = 'HUELLITAS DE AMOR II - 01';
    // $sql_vars['a17'] = '87';
    // $sql_vars['a18'] = '0';
 
 

  // $sql_vars['a1'] = "04-06-2020";
  // $sql_vars['a2'] = "002"; 
  // $sql_vars['a3'] = "48315584"; 
  // $sql_vars['a4'] = '368.00';
  
	$statement = $dbh->prepare($cnn->_Ope_Insert_Manual_socia($sql_vars));
 	 if ( $statement->execute())
 	 {	
 		$rt = ["1"];
	 print_r(json_encode($rt));
 	}else{
 		$rt = ["2"];
 		print_r($statement->errorInfo());
 	}