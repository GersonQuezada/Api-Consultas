<?php 
require APP_ROOT.'vendor/autoload.php';
require_once CLASS_PATH."Contabilidad/Operativo/EntidadesFinancieras/ProcesoBCP.class.php"; 
require_once CLASS_PATH.'auth.class.php';

class ProcesosFinancieros{
    public function ProcesoBCP_ChequeGenerancia($param,$_token){
        $_procesoBCP = new ProcesoBCP; 
        $_auth = new auth; 
        if (preg_match('/Bearer\s(\S+)/', $_token, $Token)) { //! Se separa el Token del BEARER
            $_decoToken =  $_auth->DecodToken("$Token[1]");  // TODO: Decodicificamos el Token si tiene status 200
            if( $_decoToken["status"] == 200){
                $fechaproceso = $param->fechaproceso;
                $Region = $param->region;
                $user = $param->user;
                $data = $_procesoBCP->Plantilla_BCP($fechaproceso,$Region,$user,$Token[1]);
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

    public function EditaSociaPlantillaBCP($_token){
        $_procesoBCP = new ProcesoBCP; 
        $_auth = new auth; 
        if (preg_match('/Bearer\s(\S+)/', $_token, $Token)) { //! Se separa el Token del BEARER
            $_decoToken =  $_auth->DecodToken("$Token[1]");  // TODO: Decodicificamos el Token si tiene status 200
            if( $_decoToken["status"] == 200){
                $BodyJson = json_decode(file_get_contents("php://input"),true);
                $data = $_procesoBCP->ModificaSociaBCP($BodyJson,$Token[1]);
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

    public function EliminarSociaPlantillaBCP($_token){
        $_procesoBCP = new ProcesoBCP; 
        $_auth = new auth; 
        if (preg_match('/Bearer\s(\S+)/', $_token, $Token)) { //! Se separa el Token del BEARER
            $_decoToken =  $_auth->DecodToken("$Token[1]");  // TODO: Decodicificamos el Token si tiene status 200
            if( $_decoToken["status"] == 200){
                $BodyJson = json_decode(file_get_contents("php://input"),true);
                $data = $_procesoBCP->EliminaSociaBCP($BodyJson,$Token[1]);
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

    public function GeneraArchivoBCP_txt($_token){
        $_procesoBCP = new ProcesoBCP; 
        $_auth = new auth; 
        if (preg_match('/Bearer\s(\S+)/', $_token, $Token)) { //! Se separa el Token del BEARER
            $_decoToken =  $_auth->DecodToken("$Token[1]");  // TODO: Decodicificamos el Token si tiene status 200
            if( $_decoToken["status"] == 200){
                $BodyJson = json_decode(file_get_contents("php://input"),true);
                $data = $_procesoBCP->GeneraArchivoBCP_txt($BodyJson,$Token[1]);
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

    public function RevertirProcesoBCP($_token){
        $_procesoBCP = new ProcesoBCP; 
        $_auth = new auth; 
        if (preg_match('/Bearer\s(\S+)/', $_token, $Token)) { //! Se separa el Token del BEARER
            $_decoToken =  $_auth->DecodToken("$Token[1]");  // TODO: Decodicificamos el Token si tiene status 200
            if( $_decoToken["status"] == 200){
                $BodyJson = json_decode(file_get_contents("php://input"),true);
                $data = $_procesoBCP->RevertirProcesoBCP($BodyJson,$Token[1]);
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