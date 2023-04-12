<?php 
require APP_ROOT.'vendor/autoload.php';
require_once CLASS_PATH."Contabilidad/Operativo/GeneracionCuentasSocias/CuentasSocias.class.php"; 
require_once CLASS_PATH.'auth.class.php';

class CuentasSociasController{

    public function ObternerCuentasSocias($param,$_token)
    {  
        $_CuentasSocias = new CuentasSocias; 
        $_auth = new auth; 
        if (preg_match('/Bearer\s(\S+)/', $_token, $Token)) { //! Se separa el Token del BEARER
            $_decoToken =  $_auth->DecodToken("$Token[1]");  // TODO: Decodicificamos el Token si tiene status 200
            if( $_decoToken["status"] == 200){
                $usuario = $param->usuario;
                $data = $_CuentasSocias->ObtenerCuentasSocias($usuario,$Token[1]);
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

    public function ObternerCuentasSociasDNI($param,$_token)
    {  
        $_CuentasSocias = new CuentasSocias; 
        $_auth = new auth; 
        if (preg_match('/Bearer\s(\S+)/', $_token, $Token)) { //! Se separa el Token del BEARER
            $_decoToken =  $_auth->DecodToken("$Token[1]");  // TODO: Decodicificamos el Token si tiene status 200
            if( $_decoToken["status"] == 200){
                $usuario = $param->usuario;
                $dni = $param->dni;
                $data = $_CuentasSocias->ObtenerCuentasSociasDNI($dni,$usuario,$Token[1]);
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

    public function RegistrarCuentaSocia($_token)
    {   
        $_CuentasSocias = new CuentasSocias; 
        $_auth = new auth; 
        if (preg_match('/Bearer\s(\S+)/', $_token, $Token)) { //! Se separa el Token del BEARER
            $_decoToken =  $_auth->DecodToken("$Token[1]");  // TODO: Decodicificamos el Token si tiene status 200
            if( $_decoToken["status"] == 200){
                $BodyJson = json_decode(file_get_contents("php://input"),true);
                $data = $_CuentasSocias->GrabaCuentaSocia($BodyJson,$Token[1]);
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

    public function ModificarCuentaSocia($_token)
    {   
        $_CuentasSocias = new CuentasSocias; 
        $_auth = new auth; 
        if (preg_match('/Bearer\s(\S+)/', $_token, $Token)) { //! Se separa el Token del BEARER
            $_decoToken =  $_auth->DecodToken("$Token[1]");  // TODO: Decodicificamos el Token si tiene status 200
            if( $_decoToken["status"] == 200){
                $BodyJson = json_decode(file_get_contents("php://input"),true);
                $data = $_CuentasSocias->ModificaCuentaSocia($BodyJson,$Token[1]);
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

    public function EliminarCuentaSocia($_token)
    {   
        $_CuentasSocias = new CuentasSocias; 
        $_auth = new auth; 
        if (preg_match('/Bearer\s(\S+)/', $_token, $Token)) { //! Se separa el Token del BEARER
            $_decoToken =  $_auth->DecodToken("$Token[1]");  // TODO: Decodicificamos el Token si tiene status 200
            if( $_decoToken["status"] == 200){
                $BodyJson = json_decode(file_get_contents("php://input"),true);
                $data = $_CuentasSocias->EliminarCuentaSocia($BodyJson,$Token[1]);
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