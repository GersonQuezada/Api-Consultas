<?php
require __DIR__ . '/../vendor/autoload.php';
require_once "../Clases/Operaciones/Select2/Catalogo/Catalogo.class.php";
require_once "../Clases/respuestas.class.php";
$_CatalogoDetalles = new CatalogoDetalles;
$_respuestas = new respuestas;

 
if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(isset($_GET["ID_CAB"]) ){
        $_bodyJson = array(
                         "ID_CAB" => $_GET["ID_CAB"] 
                     );  
         // enviamos los datos al manejador
         $datosArray = $_CatalogoDetalles->EnListarCatalogoDetalle(json_encode($_bodyJson));
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
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    print json_encode($datosArray);
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){   
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    print json_encode($datosArray);
}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    print json_encode($datosArray);
}else{
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    print json_encode($datosArray);
}
?>