<?php 
require __DIR__ . '/../vendor/autoload.php';
require_once "../Clases/Operaciones/Operativo/Solicitudes/Solicitudes.class.php";
require_once "../Clases/respuestas.class.php";
$_Solicitudes = new Solicitudes;
$_respuestas = new respuestas;

if($_SERVER['REQUEST_METHOD'] == "GET"){

    if(isset($_GET["Token"]) && isset($_GET["FEC_ACTUAL"]) ){
       $_bodyJson = array(
                        "FEC_ACTUAL" => $_GET["FEC_ACTUAL"],  
                        "USER" => $_GET["User"],
                        "Token" => $_GET["Token"]
                    );  
        // enviamos los datos al manejador
        $datosArray = $_Solicitudes->ListarSociasSolicitudes(json_encode($_bodyJson));
        //delvolvemos una respuesta
        header('Content-Type: application/json');
        if(isset($datosArray["result"]["error_id"])){
            $responseCode = $datosArray["result"]["error_id"];
            http_response_code($responseCode);
        }else{
            http_response_code(200);
        } 
        echo json_encode($datosArray);

    }else if(isset($_GET["FEC_PRO_DIARIO"]) ){
        $_bodyJson = array(
                         "FEC_PRO_DIARIO" => $_GET["FEC_PRO_DIARIO"] 
                     );  
         // enviamos los datos al manejador
         $datosArray = $_Solicitudes->RestriccionesSolicitudes(json_encode($_bodyJson));
         //delvolvemos una respuesta
         header('Content-Type: application/json');
         if(isset($datosArray["result"]["error_id"])){
             $responseCode = $datosArray["result"]["error_id"];
             http_response_code($responseCode);
         }else{
             http_response_code(200);
         } 
         echo json_encode($datosArray);
 
    }else if(isset($_GET["nro_Reporte"])){
        $reporte =  $_GET["nro_Reporte"];
        if( $reporte == "R1"){
            $_bodyJson = array(
                "cod_Region" => $_GET["cod_Region"] ,
                "fecha_inicio" => $_GET["fecha_inicio"] ,
                "fecha_fin" => $_GET["fecha_fin"] ,
                "nro_Reporte" => $_GET["nro_Reporte"] 
            );  
        }else if( $reporte == "R2"){
            $_bodyJson = array(
                "cod_Region" => $_GET["cod_Region"] ,
                "fecha_inicio" => $_GET["fecha_inicio"] ,
                "fecha_fin" => $_GET["fecha_fin"] ,
                "nro_Reporte" => $_GET["nro_Reporte"] 
            );  
        }else if( $reporte == "R3"){
            $_bodyJson = array(
                "cod_Region" => $_GET["cod_Region"] ,
                "fecha_inicio" => $_GET["fecha_inicio"] ,
                "fecha_fin" => $_GET["fecha_fin"],
                "fecha_Periodo" => $_GET["fecha_Periodo"],
                "nro_Reporte" => $_GET["nro_Reporte"] 
            );  
        }else if( $reporte == "R4"){
            $_bodyJson = array(
                "cod_Region" => $_GET["cod_Region"] ,
                "fecha_inicio" => $_GET["fecha_inicio"] ,
                "fecha_fin" => $_GET["fecha_fin"] ,
                "fecha_inicio_Dsb" => $_GET["fecha_inicio_Dsb"] ,
                "fecha_fin_Dsb" => $_GET["fecha_fin_Dsb"] ,
                "nro_Reporte" => $_GET["nro_Reporte"] 
            );  
        }else if( $reporte == "R5"){
            $_bodyJson = array(
                "fecha_Actual" => $_GET["fecha_Actual"] ,
                "Usuario" => $_GET["Usuario"],
                "nro_Reporte" => $_GET["nro_Reporte"]  
            );  
        }  
        // enviamos los datos al manejador
        $datosArray = $_Solicitudes->ReportesSolicitudes(json_encode($_bodyJson));
        //delvolvemos una respuesta
        header('Content-Type: application/json');
        if(isset($datosArray["result"]["error_id"])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
        }else{
        http_response_code(200);
        } 
        echo json_encode($datosArray);
 
    }  
   
}else if($_SERVER['REQUEST_METHOD'] == "POST"){
    // if(isset($_POST["INSERT_RESTRICCION"])){
        //recibir datos
        $postBody = file_get_contents("php://input");
        // enviamos los datos al manejador
        $datosArray = $_Solicitudes->InsertSolicitudes($postBody);
        //delvolvemos una respuesta
        header('Content-Type: application/json');
        if(isset($datosArray["result"]["error_id"])){
            $responseCode = $datosArray["result"]["error_id"];
            http_response_code($responseCode);
        }else{
            http_response_code(200);
        } 
        echo json_encode($datosArray);
        // echo json_encode("hola get");
    // }

}else if($_SERVER['REQUEST_METHOD'] == "PUT"){   
    // recibir datos
    $postBody = file_get_contents("php://input");
    // enviamos los datos al manejador
    $datosArray = $_Solicitudes->ModificaSolicitud($postBody);
    // $datosArray = $_auth->generaJWT_token('gerson');
    //delvolvemos una respuesta
    header('Content-Type: application/json');
    if(isset($datosArray["result"]["error_id"])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    } 
    echo json_encode($datosArray);
    // echo json_encode("hola get");
}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
    //recibir datos
    $postBody = file_get_contents("php://input");
    // enviamos los datos al manejador
    $datosArray = $_Solicitudes->EliminarSolicitudes($postBody);
    // $datosArray = $_auth->generaJWT_token('gerson');
    //delvolvemos una respuesta
    header('Content-Type: application/json');
    if(isset($datosArray["result"]["error_id"])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    } 
    echo json_encode($datosArray);
    // echo json_encode("hola get");
}else{
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    print json_encode($datosArray);
}
?>