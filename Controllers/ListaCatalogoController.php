<?php
require_once APP_ROOT.'vendor/autoload.php';
require_once CLASS_PATH."Operaciones/Select2/Catalogo/Catalogo.class.php";

class EnListarCatalogo{

    public function ListaCatalodoDetalle($param,$_token)
    {
        
        $_auth = new auth; 
        $_CatalogoDetalles = new CatalogoDetalles;
        if (preg_match('/Bearer\s(\S+)/', $_token, $Token)) { //! Se separa el Token del BEARER
            $_decoToken =  $_auth->DecodToken("$Token[1]");  // TODO: Decodicificamos el Token si tiene status 200
            if( $_decoToken["status"] == 200){
                $id_cab = $param->id_cab;               
                $datosArray = $_CatalogoDetalles->EnListarCatalogoDetalle($id_cab,$Token[1]);
                return $datosArray;  
            }else{ 
                $result = [
                    "status" => 401,
                    "message" => "Token Invalido - Token no reconocido",
                    "data" => $param
                ];
                return $result;                            
            }
        } 
    }

};