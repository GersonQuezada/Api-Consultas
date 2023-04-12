<?php
require_once CLASS_PATH.'config/conexion.php'; 
require_once CLASS_PATH.'auth.class.php';

class CuentasSocias extends conexion{
    private $table_a = "ope_Nro_Cuentas_Socias";
    private $table_b = "BD_CREDIMUJER.dbo.MAE_CLI";
    private $table_c = "seg_Catalogo_DET";
    private $table_d = "seg_Usuarios_Agencia";    
 
    public function ObtenerCuentasSocias($USUARIO,$Token){
        $_auth = new auth;   
        $EstadoToken = $_auth->VerificaRefreshToken($Token); 
        if($EstadoToken["status"] == 200){
            $query = "SELECT top 100 a.IN_id as ID,a.VC_nro_Documento_Socia as NRODNI,b.NOM_CLI_LARGO as Socia,a.VC_Nro_Cuenta as NroCuenta,c.VC_Descripcion as EntidadBancaria,
                        a.BT_Estado as Estado,a.DT_fech_creacion as FechaCreacion
                        from ". $this->table_a ." a inner join ". $this->table_b ." b 
                        on a.VC_nro_Documento_Socia = b.NUM_DOC COLLATE SQL_Latin1_General_CP1_CI_As
                        inner join ". $this->table_c ." c on a.IN_id_Entidad_Bancaria = c.IN_id 
                        where a.BT_Estado = '1' and a.IN_id_Region in (SELECT d.IN_id_Agencia  from ". $this->table_d ." d where d.IN_id_usuario = '$USUARIO')
                        order by a.DT_fech_creacion DESC ";
            $datos = parent::obtenerDatos($query);          
            $this ->result  = [ 'status' => 200,'message' => 'Request successful','data' => $datos];
            return $this->result;              
        }else{             
            return $this->result;  
        } 
    }

    public function ObtenerCuentasSociasDNI($DNI,$USUARIO,$Token){
        $_auth = new auth;  
        $EstadoToken = $_auth->VerificaRefreshToken($Token); 
        if($EstadoToken["status"] == 200){            
            $query = "SELECT a.IN_id as ID,a.VC_nro_Documento_Socia as NRODNI,b.NOM_CLI_LARGO as Socia,a.VC_Nro_Cuenta as NroCuenta,c.VC_Descripcion as EntidadBancaria,
            a.BT_Estado as Estado,a.DT_fech_creacion as FechaCreacion
            from ". $this->table_a ." a inner join ". $this->table_b ." b 
            on a.VC_nro_Documento_Socia = b.NUM_DOC COLLATE SQL_Latin1_General_CP1_CI_As
            inner join ". $this->table_c ." c on a.IN_id_Entidad_Bancaria = c.IN_id 
            where a.IN_id_Region in (SELECT d.IN_id_Agencia  from ". $this->table_d ." d where d.IN_id_usuario = '$USUARIO')
            and a.VC_nro_Documento_Socia = '$DNI'
            order by a.DT_fech_creacion DESC ";
            $datos = parent::obtenerDatos($query);
            $this ->result  = [ 'status' => 200,'message' => 'Request successful','data' => $datos];
            return $this->result;              
        }else{                    
            http_response_code(401);
            return $this->result;  
        } 
    }

    public function GrabaCuentaSocia($Json,$Token)
    {
        $_auth = new auth;  
        $EstadoToken = $_auth->VerificaRefreshToken($Token); 
        if($EstadoToken["status"] == 200){
            $DatosQuery = $this->InsertaCuentaSocia($Json); 
            $this ->result  = [ 'status' => 200,'message' => 'Request successful','data' => $DatosQuery];
            return $this->result;  
        }else{                    
            http_response_code(401);
            return $this->result;  
        } 
    }

    private function InsertaCuentaSocia($Json){
        $_idSucursal = $Json['Id_Sucursal'];
        $_idTipoDocumento = $Json['Id_TipoDocumento'];
        $_nroDni = $Json['NroDni'];
        $_nroCuenta = $Json['NroCuenta'];
        $_idEntidadFInanciera = $Json['Id_Entidad'];
        $usuarioCreacion = $Json['UsuarioCrea'];
        $query = "Exec USP_INSERT_CUENT_ABONO_SOCIA '$_idSucursal' , '$_idTipoDocumento' ,'$_nroDni','$_nroCuenta' , '$_idEntidadFInanciera' ,'$usuarioCreacion' ";
        $datos = parent::obtenerDatos($query); 
        return $datos;
    }
 

    public function ModificaCuentaSocia($Json,$Token)
    {
        $_auth = new auth;  
        $EstadoToken = $_auth->VerificaRefreshToken($Token); 
        if($EstadoToken["status"] == 200){
            $DatosQuery = $this->EditaCuentaSocia($Json); 
            $this ->result  = [ 'status' => 200,'message' => 'Request successful','data' => $DatosQuery];
            return $this->result;  
        }else{                    
            http_response_code(401);
            return $this->result;  
        }  
    }

    private function EditaCuentaSocia($Json){
        $nroDNI = $Json['NRODNI']; 
        $nroCuentaSocia = $Json['NROCUENTA']; 
        $estadoCuenta = $Json['ESTADO']; 
        $query = "UPDATE ". $this->table_a ." set BT_Estado = '$estadoCuenta'  where VC_Nro_Cuenta = '$nroCuentaSocia' and VC_nro_Documento_Socia = '$nroDNI' ";
        $resp = parent::nonQuery($query);
        return $resp;
    }


    public function EliminarCuentaSocia($Json,$Token)
    {
        $_auth = new auth;  
        $EstadoToken = $_auth->VerificaRefreshToken($Token); 
        if($EstadoToken["status"] == 200){
            $DatosQuery = $this->EliminaCuentaSocia($Json); 
            $this ->result  = [ 'status' => 200,'message' => 'Request successful','data' => $DatosQuery];
            return $this->result;  
        }else{                    
            http_response_code(401);
            return $this->result;  
        }  
    }

    private function EliminaCuentaSocia($Json){        
        $ID = $Json['ID'];
        $query = "DELETE FROM ". $this->table_a ." where IN_ID = '$ID' ";
        $resp = parent::nonQuery($query);
        return $resp;
    }  

}

?>