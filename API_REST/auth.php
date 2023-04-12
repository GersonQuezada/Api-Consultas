<?php 
require __DIR__ . '/../vendor/autoload.php';
require_once "../Clases/auth.class.php";
require_once "../Clases/respuestas.class.php";
$_auth = new auth;
$_respuestas = new respuestas;

if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(isset($_GET["Usuario_Id"]) &&  isset($_GET["Modulo_Id"])){
        $_bodyJson = array(
            "Usuario_Id" => $_GET["Usuario_Id"],
            "Modulo_Id" => $_GET["Modulo_Id"]
        );   
        $ObtenerItems = $_auth->ObtenerRestriccionesSistemas(json_encode($_bodyJson));
        header("Content-Type: application/json");
        echo json_encode($ObtenerItems);
        http_response_code(200); 
    }    
}else if($_SERVER['REQUEST_METHOD'] == "POST"){
    //recibir datos
    $postBody = file_get_contents("php://input");
    // enviamos los datos al manejador
    $datosArray = $_auth->login($postBody);
    // $datosArray = $_auth->insertarToken('gerson');
    //delvolvemos una respuesta
    header('Content-Type: application/json');
    if(isset($datosArray["result"]["error_id"])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    } 
    echo json_encode($datosArray);
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){
    //recibir datos
    $postBody = file_get_contents("php://input");
    // enviamos los datos al manejador
    $datosArray = $_auth->logout($postBody);
    // $datosArray = $_auth->insertarToken('gerson');
    //delvolvemos una respuesta
    header('Content-Type: application/json');
    if(isset($datosArray["result"]["error_id"])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    } 
    echo json_encode($datosArray);
}else{
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    print json_encode($datosArray);
}

 
?>