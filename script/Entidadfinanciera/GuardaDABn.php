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
 

    // $sql_vars['a1'] = '04-08-2020';

    // $sql_vars['a2'] = '0040074445';
    // $sql_vars['a3'] = 'MAMANI GAVINO DE FLORES JANNETH';
    // $sql_vars['a4'] = '6';
    // $sql_vars['a5'] = '0';
    // $sql_vars['a6'] = '004';
    // $sql_vars['a7'] = '01';
    // $sql_vars['a8'] = '013406';
    // $sql_vars['a9'] = '0';
    // $sql_vars['a10'] = '400';
    // $sql_vars['a11'] = '100';
    // $sql_vars['a12'] = 'DA';

    // $sql_vars['a13'] = '04-08-2020';
    // $sql_vars['a14'] = '04-08-2020';
    // $sql_vars['a15'] = '0040000169';
    // $sql_vars['a16'] = 'CASA GRANJA';
    // $sql_vars['a17'] = '87';
  // $sql_vars['a1'] = "04-06-2020";
  // $sql_vars['a2'] = "002"; 
  // $sql_vars['a3'] = "48315584"; 
  // $sql_vars['a4'] = '368.00';
  
	$statement = $dbh->prepare($cnn->_GuardaSocia_DA_Bn($sql_vars));
 	 if ( $statement->execute())                                 
 	 {	

        $rt['dato'] = $statement->fetchall(PDO::FETCH_ASSOC);;
     print_r(json_encode($rt['dato']));
 	}else{
 		$rt = ["3"];
 		print_r($statement->errorInfo());
 	}