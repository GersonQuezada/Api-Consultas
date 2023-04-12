<?php
require_once "../Clases/conexion/conexion.php";
require_once "../Clases/respuestas.class.php";
class Operaciones_Crediticias extends conexion{
    private $Table_credit_desem = "tcresocia01";

    // Metodo GET
    public function EnlistaSociasAprobadas($Json){
        $_respuestas = new respuestas;        
        $BodyJson = json_decode($Json,true);        
        $Token = $BodyJson['Token'];        
        //decodifica Token
        $TokenDecifrado =  parent::DecodToken($Token);
        //Estado de Token
        $EstadoToken = parent::VerificaEstadoUserToken($Token);
        // Valida Token
        if($TokenDecifrado == FALSE){
            return $_respuestas->error_401("El Token es invalido.");
        }else{
            // Valida el estado del token
            if($EstadoToken[0]['ESTADO'] == "0"){
                return $_respuestas->error_401("El Token vencido, vuelva a iniciar sesion.");
            }else{
            // Ejecuta Funcion enviada en JSON
                $DatosQuery = $this->listaSociasAprobadas();                            
                return $_respuestas->result_Busqueda($DatosQuery) ;                                          
            }             
        }    
    } 
    public function BusquedaSocia($Json){
        $_respuestas = new respuestas;        
        $BodyJson = json_decode($Json,true);  
        $DatosQuery = $this->listaSociasAprobadas();                            
        return $_respuestas->result_Busqueda($DatosQuery);  
    }

    private function listaSociasAprobadas(){
        $query = "SELECT * from ".$this->Table_credit_desem." where FECHAPROCEBN = format(getdate(),'dd-MM-yyyy') and CARGATABLA = 'N' and TIPODESEMBOLSO <> 'DA'";
        $data = parent::obtenerDatos($query);
        return $data;
    }

    private function BuscarSocia($Json){
        $cod_Region = $Json['cod_Region'];
        $nom_Socia = $Json['nom_Socia'];
        $query = "Set NOCOUNT ON; EXEC SP_BN07SOCIASAINSERTAR '{$ls['a1']}' , '{$ls['a2']}'";
        $data = parent::obtenerDatos($query);
        return $data;
    }

    

}
