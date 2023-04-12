<?php 
require __DIR__ . '/../vendor/autoload.php';
require_once "../Clases/Operaciones/Operativo/Operaciones_Socias_Banco/Operativa_BN.class.php";
require_once "../Clases/respuestas.class.php";
$_OperacionesCredito = new Operaciones_Crediticias;
$_respuestas = new respuestas;

if($_SERVER['REQUEST_METHOD'] == "GET"){ 
    if(isset($_GET["Operacion"]) && $_GET["Operacion"] == "InsertBN" ){
        $_bodyJson = array( 
                         "Token" => $_GET["Token"]
                     );  
         // enviamos los datos al manejador
         $datosArray = $_OperacionesCredito->EnlistaSociasAprobadas(json_encode($_bodyJson));
         //delvolvemos una respuesta
         header('Content-Type: application/json');
         if(isset($datosArray["result"]["error_id"])){
             $responseCode = $datosArray["result"]["error_id"];
             http_response_code($responseCode);
         }else{
             http_response_code(200);
         } 
         echo json_encode($datosArray); 
    }else if(isset($_GET["cod_Region"]) && isset($_GET["nom_Socia"])){
        $_bodyJson = array( 
            "cod_Region" => $_GET["cod_Region"],
            "nom_Socia" => $_GET["nom_Socia"]
        );  
        // enviamos los datos al manejador
        $datosArray = $_OperacionesCredito->BusquedaSocia(json_encode($_bodyJson));
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
 
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){   
 
}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
 
}else{
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    print json_encode($datosArray);
}
?>