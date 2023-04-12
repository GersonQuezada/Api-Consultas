<?php 
require __DIR__ . '/../vendor/autoload.php';
require_once "../Clases/Operaciones/Operativo/OrdenesPagos/OrdenesPagos.class.php";
require_once "../Clases/respuestas.class.php";
$_OrdenesPagos = new Ordenes_Pagos;
$_respuestas = new respuestas;

if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(isset($_GET["Token"]) && isset($_GET["usuario_list"]) ){
       $_bodyJson = array(                        
                        "usuario_list" => $_GET["usuario_list"],
                        "Token" => $_GET["Token"]
                    );  
        // enviamos los datos al manejador
        $datosArray = $_OrdenesPagos->ListarOrdenesPagos(json_encode($_bodyJson));
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
         $datosArray = $_OrdenesPagos->RestriccionesOrdenesPagos(json_encode($_bodyJson));
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
    else if(isset($_GET["nro_Reporte"])){
        $reporte =  $_GET["nro_Reporte"];
        if( $reporte == "R1"){
            $_bodyJson = array(
                "cod_Region" => $_GET["cod_Region"] ,
                "fecha_Inicio" => $_GET["fecha_Inicio"] ,
                "fecha_Final" => $_GET["fecha_Final"] ,
                "Tipo" => $_GET["Tipo"] ,
                "nro_Reporte" => $_GET["nro_Reporte"] 
            );  
        } 
        // enviamos los datos al manejador
        $datosArray = $_OrdenesPagos->ReportesOrdenesPagos(json_encode($_bodyJson));
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
        $datosArray = $_OrdenesPagos->InsertOrdenesPagos($postBody);
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
    $datosArray = $_OrdenesPagos->ModificarOrdenPago($postBody);
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
    $datosArray = $_OrdenesPagos->EliminarOrdenPago($postBody);
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