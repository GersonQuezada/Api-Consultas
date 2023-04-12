<?php
	require_once('../coneccion.php'); //se realiza la coneccion
 	$cnn =new Modelador();
	$dbh = $cnn->conexion();
 	$statement = $dbh->prepare("SELECT REGION,DESASOCIACION,APELLIDOSNOMBRES,NRODNI,MTOAPROBADO,MTODESEMBOLSADO,TIPODESEMBOLSO, FECHACREDITO from (
	SELECT 
	(select NOMSUCURSAL from SFD_AGENCIAS where CODSUCURSAL_REG  COLLATE SQL_Latin1_General_CP1_CI_As =  CODREGION ) as REGION
	,DESASOCIACION,APELLIDOSNOMBRES,NRODNI, MTOAPROBADO ,cast(MTODESEMBOLSADO as varchar(250)) as MTODESEMBOLSADO ,TIPODESEMBOLSO,CONVERT(varchar(250),format(FECHACREDITO,'dd-MM-yyyy'),110) as FECHACREDITO FROM TCRESOCIA01 where FECHAPROCEBN = format(getdate(),'dd-MM-yyyy') and TIPODESEMBOLSO <> 'DA'

	union all
	SELECT 
	(select NOMSUCURSAL from SFD_AGENCIAS where CODSUCURSAL_REG  COLLATE SQL_Latin1_General_CP1_CI_As =  CODREGION ) as REGION
	,'_TOTAL','','',SUM(MTOAPROBADO),'','','' FROM TCRESOCIA01 where FECHAPROCEBN = format(getdate(),'dd-MM-yyyy') and TIPODESEMBOLSO <> 'DA' group by CODREGION
	) as vorder order by  1 asc, 2 DESC ");
 	 if ( $statement->execute())
 	 {	 
     $rt['data'] = $statement->fetchall(PDO::FETCH_ASSOC);
  	 echo (json_encode($rt)) ;
 	}else{
 		print_r($statement->errorInfo());
 	}