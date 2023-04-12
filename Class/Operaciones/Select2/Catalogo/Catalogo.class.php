<?php
require_once CLASS_PATH."config/conexion.php";
// require_once "../Clases/respuestas.class.php";
class CatalogoDetalles extends conexion{
    private $Table = "seg_Catalogo_DET"; 
    //Method GET 
    public function EnListarCatalogoDetalle($param,$Token){
        $_auth = new auth;   
        $data = [];
        $EstadoToken = $_auth->VerificaRefreshToken($Token); 
        if($EstadoToken["status"] == 200){
            $DatosQuery = $this->ListaCatalogoDetalles($param);                                        
            foreach ($DatosQuery as $key => $value) {
                $id = $value['id'];
                $name = $value['text'];
                $data[] = array('id'=>$id,'text'=>$name); 
            }    
            $result = [
                "status" => 200,
                "message" => "Request successful",
                "data" => $data
            ];
            return $result;          
        }else{  
            $result = [
                "status" => 400,
                "message" => "El Token vencido, vuelva a iniciar sesion.",
                "data" => $EstadoToken["Status Token"]
            ];
            return $result;  
        } 
        
    }
 

    // FUNCIONES
    Private function ListaCatalogoDetalles($id_Cab){  
        $query = "SELECT IN_id as id,VC_Descripcion as text
                  FROM ".$this->Table."  
                  WHERE SI_id_Cab = '$id_Cab' ";                 
        $datos = parent::obtenerDatos($query);
        return $datos;
    }  
}
?>