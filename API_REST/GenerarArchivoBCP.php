<?php 
require __DIR__ . '/../vendor/autoload.php';
require_once "../Clases/Contabilidad/Operativo/EntidadFinanciera_BCP/GeneraArchivo.class.php";
require_once "../Clases/respuestas.class.php";
$_GeneraArchivo = new GeneracionArchivoBCP;
$_respuestas = new respuestas;

if($_SERVER['REQUEST_METHOD'] == "POST"){
    //recibir datos
    $postBody = file_get_contents("php://input");
    // enviamos los datos al manejador
    $datosArray = $_GeneraArchivo->TablaArchivoBCP($postBody);
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
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){
    // $headers = getallheaders();
    // if(isset($headers["Token"]) && isset($headers["ID"])){
    //     //recibimos los datos enviados por el header
    //     $send = [
    //         "token" => $headers["Token"],
    //         "pacienteId" =>$headers["ID"]
    //     ];
    //     $postBody = json_encode($send);
    // }else{
    //     //recibimos los datos enviados
    //     $postBody = file_get_contents("php://input");
    // }
    //recibir datos
    $postBody = file_get_contents("php://input");
    // enviamos los datos al manejador
    $datosArray = $_GeneraArchivo->ModificaSociaBCP($postBody);
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
    $datosArray = $_GeneraArchivo->EliminarSociaBCP($postBody);
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