<?php
require_once "../Clases/conexion/conexion.php";
require_once "../Clases/respuestas.class.php";
class Operativa_BIM extends conexion{
    private $Table = "TENVIOBIM";
    //Method Post 
    public function ListarSociasBIM($Json){
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
                if(isset($BodyJson["FIN_PROC"])){
                    $DatosQuery = $this->ConsultarBancos_Final($BodyJson);                            
                    return $_respuestas->result_Busqueda($DatosQuery) ; 
                }else if(isset($BodyJson["Insert"])){
                    $DatosQuery = $this->Insert_BIM($BodyJson);                            
                    return $_respuestas->result_Busqueda($DatosQuery) ; 
                }else{
                    $DatosQuery = $this->ConsultarBancos($BodyJson);                            
                    return $_respuestas->result_Busqueda($DatosQuery) ;              
                }                
            } 
        }    
    } 

    //Method Put
    public function ModificaSocia_BIM($Json){
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
               $DatosQuery = $this->EditaSociaDJ($BodyJson);                            
               return $_respuestas->result_Busqueda($DatosQuery) ;              
            } 
        }    
    }

    //Method Get
    public function BuscarSocia_DJ($Json){
        $_respuestas = new respuestas;   
        $BodyJson = json_decode($Json,true);    
        $DatosQuery = $this->ConsultarSocia($BodyJson);                            
        return $_respuestas->result_Busqueda($DatosQuery) ;    
    }


    //Method DELETE
    public function EliminarSocia_BIM($Json){
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
               $DatosQuery = $this->EliminarSocia($BodyJson);                            
               return $_respuestas->result_Busqueda($DatosQuery) ;              
            } 
        }    
    }

    //Funcion para consultar la Tabla con la Info
    Private function ConsultarBancos($Json){
        $Fec_Proce = parent::Dateformat($Json['FEC_PROCESO']);        
        // Falta completar el procedure      
        $query = "SET NOCOUNT ON;exec SP_04BNCOS_GeneraVisualizacion_BIM '$Fec_Proce'";
        $datos = parent::obtenerDatos($query);
        return $datos;
    }

    Private function ConsultarBancos_Final($Json){
        $Fec_Proce = parent::Dateformat($Json['FEC_PROCESO']);        
        // Falta completar el procedure      
        $query = "SET NOCOUNT ON;exec USP_PROCESO_FINAL_BIM '$Fec_Proce'";
        $datos = parent::obtenerDatos($query);
        return $datos;
    }

    private function ConsultarSocia($Json){
        $Cod_Region =  $Json['Cod_Region'];  
        $Nom_Socia = $Json['Nom_Socia'];
        $query = "Set NOCOUNT ON; EXEC SP_BIM_DA_BUSCAR_SOCIA '$Cod_Region' , '$Nom_Socia' ";
        $datos = parent::obtenerDatos($query);
        return $datos;        
    }

    private function InsertSociaBIM($Json){
        $Cod_Region =  $Json['Cod_Region'];  
        $Nom_Socia = $Json['Nom_Socia'];
        $query = "SET NOCOUNT ON; exec insertDABIM '{$ls['a1']}' , '{$ls['a2']}', '{$ls['a3']}', '{$ls['a4']}', '{$ls['a5']}', '{$ls['a6']}', '{$ls['a7']}', '{$ls['a8']}', '{$ls['a9']}', '{$ls['a10']}', '{$ls['a11']}', '{$ls['a12']}', '{$ls['a13']}', '{$ls['a14']}', '{$ls['a15']}', '{$ls['a16']}', '{$ls['a17']}', '{$ls['a18']}' ";
        $datos = parent::obtenerDatos($query);
        return $datos;        
    }

    //Funcion Elimina Socia Envio BIM
    Private function EliminarSocia($Json){
        $Fec_Proce = parent::Dateformat($Json['FEC_PROCESO']);        
        $NRODNI = $Json['NRODNI'];
        $Cod_Region = $Json['Cod_Region'];
        $query = "DELETE FROM ".$this->Table." WHERE NRODNI = '$NRODNI' and FECHAPROCESO = '$Fec_Proce' and CODREGION = '$Cod_Region' " ;
        $datos = parent::nonQuery($query);
        return $datos;
    }

    //Funcion Realiza DJ Socia Envio BCP
    Private function EditaSociaDJ($Json){
        $MTO_ADICIONAL = $Json['MTO_ADICIONAL'];
        $NRODNI = $Json['NRODNI'];
        // $PRODUCTO = $Json['PRODUCTO'];
        $Cod_Region = $Json['Cod_Region'];
        $Fec_Proce = parent::Dateformat($Json['FEC_PROCESO']);        
        $query = "UPDATE ". $this->Table . " set MTODESEMBOLSADO = '$MTO_ADICIONAL'  where NRODNI = '$NRODNI' and CODREGION = '$Cod_Region' and fechaproceso = '$Fec_Proce' and CARGATABLA = 'N'";
        $datos = parent::nonQuery($query);
        return $datos;
    }
}
?>