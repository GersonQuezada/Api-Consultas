<?php
require_once CLASS_PATH.'config/conexion.php'; 
require_once CLASS_PATH.'auth.class.php';

class ProcesoBCP extends conexion{
    private $Table = "desem_Socias_Bancos_BCP";

    //Method Post 
    public function Plantilla_BCP($fechaproceso,$Region,$user,$token){
        $_auth = new auth;   
        $EstadoToken = $_auth->VerificaRefreshToken($token); 
        if($EstadoToken["status"] == 200){ 
            $datos = $this->ObtenerPlantillaBCP($fechaproceso,$Region,$user);
            $this ->result  = [ 'status' => 200,'message' => 'Request successful','data' => $datos];
            return $this->result;                          
        }else{             
            return $this->result;  
        }   
    }
 
    public function ModificaSociaBCP($Json,$token){
        $_auth = new auth;   
        $EstadoToken = $_auth->VerificaRefreshToken($token); 
        if($EstadoToken["status"] == 200){                         
            $this ->result  = [ 'status' => 200,'message' => 'Request successful','data' => $this->EditaSociaDJ($Json)];
            return $this->result;                          
        }else{             
            return $this->result;  
        }   
    }

    public function RevertirProcesoBCP($Json,$token){
        $_auth = new auth;   
        $EstadoToken = $_auth->VerificaRefreshToken($token); 
        if($EstadoToken["status"] == 200){           
            // $datos = $this->RevertirProceso($Json);
            
            $this ->result  = [ 'status' => 200,'message' => 'Request successful','data' => $this->RevertirProceso($Json)];
            return $this->result;                          
            // return $datos;
        }else{             
            return $this->result;  
        }   
    }

    //Method DELETE
    public function EliminaSociaBCP($Json,$token){
        $_auth = new auth;   
        $EstadoToken = $_auth->VerificaRefreshToken($token); 
        if($EstadoToken["status"] == 200){ 
            $datos = $this->EliminarSociaDJ($Json);
            $this ->result  = [ 'status' => 200,'message' => 'Request successful','data' => $datos];
            return $this->result;                          
        }else{             
            return $this->result;  
        }     
    }

    public function GeneraArchivoBCP_txt($Json,$token){
        $_auth = new auth;   
        $EstadoToken = $_auth->VerificaRefreshToken($token); 
        if($EstadoToken["status"] == 200){ 
            $campos = $this->ObtenerSociasPlantillaBCP($Json);
            $this ->result  = [ 'status' => 200,'message' => 'Request successful','data' => $campos];
            return $this->result;                          
        }else{             
            return $this->result;  
        }   
    }

    //Funcion para consultar la Tabla con la Info
    Private function ObtenerPlantillaBCP($fechaproceso,$Region,$user){       
        $query = "SET NOCOUNT ON; exec USP_DESEM_SFDATA_BCP_3 '$fechaproceso','$Region','$user'";
        $datos = parent::obtenerDatos($query);
        return $datos;         
    }

    //Funcion para revertir proceso del bcp
    Private function RevertirProceso($Json){
        $Fec_Proce = $Json['FEC_PROCESO'];
        $Cod_Region = $Json['COD_REGION'];        
        $query = "SET NOCOUNT ON;EXEC USP_DESEM_SFDATA_BCP_Revertir '$Fec_Proce','$Cod_Region'";
        $datos = parent::obtenerDatos($query);
        return $datos;        
    }

    //Funcion Elimina Socia Envio BCP
    Private function EliminarSociaDJ($Json){
        $ID = $Json['IN_id'];
        $query = "DELETE FROM ".$this->Table." WHERE IN_id = '$ID' ";
        $valor = parent::nonQuery($query);
        if( $valor == 1){
            $Datos = [
                'message' => "Datos Eliminados Correctamente",
                'dato' =>  $valor
            ]; 
        }else{
            $Datos = [
                'message' => "No se pudo eliminar los datos",
                'dato' =>  $valor
            ]; 
        }
        return $Datos;
    }

    //Funcion Realiza DJ Socia Envio BCP
    Private function EditaSociaDJ($Json){       
        $in_ID = $Json['IN_id'];
        $mto_Adicional = $Json['MTO_ADICIONAL'];
        $query = "UPDATE ". $this->Table . " set NM_mto_Ajustado_Desembolso = '$mto_Adicional'  where IN_id = '$in_ID' ";
        $valor = parent::nonQuery($query);
        if( $valor == 1){
            $Datos = [
                'message' => "Datos Modicicados Correctamente",
                'dato' =>  $valor
            ]; 
        }else{
            $Datos = [
                'message' => "No se pudo modificar los datos",
                'dato' =>  $valor
            ]; 
        }
        return $Datos;
    }


    Private function ObtenerSociasPlantillaBCP($Json){
        $fecha_proceso = $Json['Fecha_Proceso'];
        $Cod_Region = $Json['Cod_Region'];
        $query = "SET NOCOUNT ON; exec USP_DESEM_SFDATA_BCP_GENERACION_ARCHIVO_TXT '$fecha_proceso', '$Cod_Region' ";
        $datos = parent::obtenerDatos($query);
        return $datos; 
    }
}
?>
