<?php
require __DIR__ . '/../vendor/autoload.php';
require_once "../Clases/Operaciones/Select2/BancoComunales/BancosComunales.class.php";
require_once "../Clases/respuestas.class.php";
$_BancosComunales = new BancoComunales;
$_respuestas = new respuestas;

 
if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(isset($_GET["region"]) && isset($_GET["name_banco"]) && isset($_GET["sol_Bancos"]) ){
        $_bodyJson = array(
                         "name_banco" => $_GET["name_banco"],  
                         "region" => $_GET["region"],
                         "sol_Bancos" => $_GET["sol_Bancos"]
                     );  
         // enviamos los datos al manejador
         $datosArray = $_BancosComunales->EnlistarBancosComunales_Anillos(json_encode($_bodyJson));
         //delvolvemos una respuesta
         header('Content-Type: application/json');
         if(isset($datosArray["result"]["error_id"])){
             $responseCode = $datosArray["result"]["error_id"];
             http_response_code($responseCode);
         }else{
             http_response_code(200);
         } 
         echo json_encode($datosArray);
 
     }else if(isset($_GET["region"]) && isset($_GET["name_banco"]) ){
       $_bodyJson = array(
                        "name_banco" => $_GET["name_banco"],  
                        "region" => $_GET["region"]
                    );  
        // enviamos los datos al manejador
        $datosArray = $_BancosComunales->EnlistarBancosComunales(json_encode($_bodyJson));
        //delvolvemos una respuesta
        header('Content-Type: application/json');
        if(isset($datosArray["result"]["error_id"])){
            $responseCode = $datosArray["result"]["error_id"];
            http_response_code($responseCode);
        }else{
            http_response_code(200);
        } 
        echo json_encode($datosArray);

    }else if(isset($_GET["cod_Banco"]) && isset($_GET["name_banco"]) ){
        $_bodyJson = array(
                         "name_banco" => $_GET["name_banco"],  
                         "cod_Banco" => $_GET["cod_Banco"]
                     );  
         // enviamos los datos al manejador
         $datosArray = $_BancosComunales->EnlistarAnillosComunales(json_encode($_bodyJson));
         //delvolvemos una respuesta
         header('Content-Type: application/json');
         if(isset($datosArray["result"]["error_id"])){
             $responseCode = $datosArray["result"]["error_id"];
             http_response_code($responseCode);
         }else{
             http_response_code(200);
         } 
         echo json_encode($datosArray);
 
    }else if(isset($_GET["cod_Banco"]) && isset($_GET["name_Socia"]) ){
        $_bodyJson = array(
                         "name_Socia" => $_GET["name_Socia"],  
                         "cod_Banco" => $_GET["cod_Banco"]
                     );  
         // enviamos los datos al manejador
         $datosArray = $_BancosComunales->EnlistarSociasBanco(json_encode($_bodyJson));
         //delvolvemos una respuesta
         header('Content-Type: application/json');
         if(isset($datosArray["result"]["error_id"])){
             $responseCode = $datosArray["result"]["error_id"];
             http_response_code($responseCode);
         }else{
             http_response_code(200);
         } 
         echo json_encode($datosArray); 
    }elseif (isset($_GET["entidad_Bancaria"]) && isset($_GET["cod_Socia"]) ) {
        $_bodyJson = array(
            "entidad_Bancaria" => $_GET["entidad_Bancaria"],  
            "cod_Socia" => $_GET["cod_Socia"]
        );
        $datosArray = $_BancosComunales->ConsultaCuentaAhorro(json_encode($_bodyJson));
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