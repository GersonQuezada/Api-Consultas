<?php 
require APP_ROOT.'vendor/autoload.php';
require_once CLASS_PATH."auth.class.php"; 

class AuthenticationController
{
    public function Login()
    {
        $_auth = new auth;        

        if($_SERVER['REQUEST_METHOD'] == "POST"){            
            //recibir datos
            $postBody = file_get_contents("php://input");
            // enviamos los datos al manejador
            $datosArray = $_auth->login($postBody);            
            //delvolvemos una respuesta            
            if(isset($datosArray["result"]["error_id"])){
                $responseCode = $datosArray["result"]["error_id"];
                http_response_code($responseCode);
            }else{
                http_response_code(200);
            }
 
            return $datosArray;
        }
    } 

    public function RegistrarUsuario()
    {
        
    }

    public function ModificaUsuario()
    {
        
    }

    public function RegistrarUsuario_Agencia()
    {
        
    }

    public function RegistrarUsuario_Rol()
    {
        
    }
    public function logout( )
    {
        $_auth = new auth;        

        if($_SERVER['REQUEST_METHOD'] == "POST"){            
            //recibir datos
            $postBody = file_get_contents("php://input");
            // enviamos los datos al manejador
            $datosArray = $_auth->logout($postBody);            
            //delvolvemos una respuesta            
            if(isset($datosArray["result"]["error_id"])){
                $responseCode = $datosArray["result"]["error_id"];
                http_response_code($responseCode);
            }else{
                http_response_code(200);
            }
 
            return $datosArray;
        }
    }
    public function StatusSession($_token)
    {
        $_auth = new auth;
        if (preg_match('/Bearer\s(\S+)/', $_token, $Token)) { //! Se separa el Token del BEARER
            $_decoToken =  $_auth->DecodToken("$Token[1]");  // TODO: Decodicificamos el Token si tiene status 200
            if( $_decoToken["status"] == 200){
                $BodyJson = json_decode(file_get_contents("php://input"),true);
                $data = $_auth->ObtenerRestriccionesSistemas($BodyJson,$Token[1]);
                return $data;  
            }else{ 
                $result = [
                    "status" => 401,
                    "message" => "Token Invalido - Token no reconocido",
                    "data" => ""
                ];
                return $result;                            
            }
        }   
    }
    public function RestriccionModulo($_token)   
    {   
        $_auth = new auth;
        if (preg_match('/Bearer\s(\S+)/', $_token, $Token)) { //! Se separa el Token del BEARER
            $_decoToken =  $_auth->DecodToken("$Token[1]");  // TODO: Decodicificamos el Token si tiene status 200
            if( $_decoToken["status"] == 200){
                $BodyJson = json_decode(file_get_contents("php://input"),true);
                $data = $_auth->ObtenerRestriccionesSistemas($BodyJson,$Token[1]);
                return $data;  
            }else{ 
                $result = [
                    "status" => 401,
                    "message" => "Token Invalido - Token no reconocido",
                    "data" => ""
                ];
                return $result;                            
            }
        }   
    }

    public function RestriccionModuloClave($_token)   
    {   
        $_auth = new auth;
        if (preg_match('/Bearer\s(\S+)/', $_token, $Token)) { //! Se separa el Token del BEARER
            $_decoToken =  $_auth->DecodToken("$Token[1]");  // TODO: Decodicificamos el Token si tiene status 200
            if( $_decoToken["status"] == 200){
                $BodyJson = json_decode(file_get_contents("php://input"),true);
                $data = $_auth->ObtenerRestriccionesSistemasClave($BodyJson,$Token[1]);
                return $data;  
            }else{ 
                $result = [
                    "status" => 401,
                    "message" => "Token Invalido - Token no reconocido",
                    "data" => ""
                ];
                return $result;                            
            }
        }    
 
    }
}



// else if($_SERVER['REQUEST_METHOD'] == "POST"){
//     header('Content-Type: application/json');
//     //recibir datos
//     $postBody = file_get_contents("php://input");
//     // enviamos los datos al manejador
//     $datosArray = $_auth->login($postBody);
//     // $datosArray = $_auth->insertarToken('gerson');
//     //delvolvemos una respuesta
    
//     if(isset($datosArray["result"]["error_id"])){
//         $responseCode = $datosArray["result"]["error_id"];
//         http_response_code($responseCode);
//     }else{
//         http_response_code(200);
//     } 
//     echo json_encode($datosArray);
// }else if($_SERVER['REQUEST_METHOD'] == "PUT"){
//     //recibir datos
//     $postBody = file_get_contents("php://input");
//     // enviamos los datos al manejador
//     $datosArray = $_auth->logout($postBody);
//     // $datosArray = $_auth->insertarToken('gerson');
//     //delvolvemos una respuesta
//     header('Content-Type: application/json');
//     if(isset($datosArray["result"]["error_id"])){
//         $responseCode = $datosArray["result"]["error_id"];
//         http_response_code($responseCode);
//     }else{
//         http_response_code(200);
//     } 
//     echo json_encode($datosArray);
// }else{
//     header('Content-Type: application/json');
//     $datosArray = $_respuestas->error_405();
//     print json_encode($datosArray);
// }

 
?>