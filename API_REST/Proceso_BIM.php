<?php 
require __DIR__ . '/../vendor/autoload.php';
require_once "../Clases/Contabilidad/Operativo/EntidadFinanciera_BIM/Operativa_BIM.class.php";
require_once "../Clases/respuestas.class.php";
$_ProcesoBIM = new Operativa_BIM;
$_respuestas = new respuestas;

if($_SERVER['REQUEST_METHOD'] == "GET"){
 

    if(isset($_GET["Nom_Socia"]) || isset($_GET["Cod_Region"]) ){
       $_bodyJson = array(
                        "Nom_Socia" => $_GET["Nom_Socia"],  
                        "Cod_Region" => $_GET["Cod_Region"]
                    );  
        // enviamos los datos al manejador
        $datosArray = $_ProcesoBIM->BuscarSocia_DJ(json_encode($_bodyJson));
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
    //recibir datos
    $postBody = file_get_contents("php://input");
    // enviamos los datos al manejador
    $datosArray = $_ProcesoBIM->ListarSociasBIM($postBody);
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
    // recibir datos
    $postBody = file_get_contents("php://input");
    // enviamos los datos al manejador
    $datosArray = $_ProcesoBIM->ModificaSocia_BIM($postBody);
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
    $datosArray = $_ProcesoBIM->EliminarSocia_BIM($postBody);
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