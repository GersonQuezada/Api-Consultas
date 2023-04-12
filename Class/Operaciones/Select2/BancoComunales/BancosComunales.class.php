<?php
require_once "../Clases/conexion/conexion.php";
require_once "../Clases/respuestas.class.php";
class BancoComunales extends conexion{
    private $Table = "V_ASOCIACIONCOMUNAL"; 
    //Method GET 
    public function EnlistarBancosComunales($Json){
        $_respuestas = new respuestas;        
        $BodyJson = json_decode($Json,true);   
        $DatosQuery = $this->ListarBancosComunales($BodyJson);                            
        return $_respuestas->result_array_select2($DatosQuery) ;                                                  
    }

    public function EnlistarBancosComunales_Anillos($Json){
        $_respuestas = new respuestas;        
        $BodyJson = json_decode($Json,true);   
        $DatosQuery = $this->ListarBancosComunales_Anillos($BodyJson);                            
        return $_respuestas->result_array_select2($DatosQuery) ;                                                  
    }

    public function EnlistarSociasBanco($Json){
        $_respuestas = new respuestas;        
        $BodyJson = json_decode($Json,true);   
        $DatosQuery = $this->ListarSocias($BodyJson);                            
        return $_respuestas->result_array_select2($DatosQuery) ;                                                  
    }
    
    public function EnlistarAnillosComunales($Json){
        $_respuestas = new respuestas;        
        $BodyJson = json_decode($Json,true);   
        $DatosQuery = $this->ListarAnillosComunales($BodyJson);                            
        return $_respuestas->result_array_select2($DatosQuery) ;                                                  
    } 

    public function ConsultaCuentaAhorro($Json){
        $_respuestas = new respuestas;        
        $BodyJson = json_decode($Json,true);   
        $DatosQuery = $this->ConsultaCuentaSocia($BodyJson);                            
        return $_respuestas->result_array_select2($DatosQuery) ;                                                  
    } 

    // FUNCIONES
    Private function ListarBancosComunales_Anillos($Json){      
        $REGION = $Json['region'];   
        $NAME_BANCO = $Json['name_banco'];    
        $query = "SELECT CODASOCIACION as id,DESASOCIACION as text
                  from ".$this->Table."  
                  where  BANCOBAJA = 'N' and DESASOCIACION like '%'+'$NAME_BANCO'+'%' and CODSUCURSAL_ASOC like '%'+'$REGION'+'%' ";                 
        $datos = parent::obtenerDatos($query);
        return $datos;
    }

    Private function ListarSocias($Json){      
        $name_Socia = $Json['name_Socia'];   
        $cod_Banco = $Json['cod_Banco'];    
        $query = "SELECT CODSOCIA as id,APELLIDOSNOMBRES as text from SFD_RELACION_ASOC_SOCIO where CODASOCIACION = '$cod_Banco' and INDBAJA = 'N' and APELLIDOSNOMBRES like '%'+'$name_Socia'+'%' ";                 
        $datos = parent::obtenerDatos($query);
        return $datos;
    }

    Private function ListarAnillosComunales($Json){      
        $cod_Banco = $Json['cod_Banco'];   
        $NAME_BANCO = $Json['name_banco'];    
        $query = "SELECT CODASOCIACION as id ,DESASOCIACION as text from SFD_ASOCIACIONCOMUNAL where CODASOC_SUP = '$cod_Banco' and DESASOCIACION like '%'+'$NAME_BANCO'+'%'  ";                 
        $datos = parent::obtenerDatos($query);
        return $datos;
    }

    Private function ListarBancosComunales($Json){      
        $REGION = $Json['region'];   
        $NAME_BANCO = $Json['name_banco'];    
        $query = "SELECT CODASOCIACION as id ,DESASOCIACION as text
                  from ".$this->Table."  
                  where  BANCOBAJA = 'N' and DESASOCIACION like '%'+'$NAME_BANCO'+'%' and CODASOC_SUP = ' '  and CODSUCURSAL_ASOC like '%'+'$REGION'+'%' ";                 
        $datos = parent::obtenerDatos($query);
        return $datos;
    }

    private function ConsultaCuentaSocia($Json){
        $entidad_Bancaria = $Json['entidad_Bancaria'];
        $cod_Socia = $Json['cod_Socia'];
        $query = "SELECT NROCUENTA as id,(NROCUENTA+' - '+Entidadbancaria) as text from CUENT_ABONO_SOCIA where Entidadbancaria = '$entidad_Bancaria' and NRODNI COLLATE SQL_Latin1_General_CP1_CI_As = (select NRODNI from SFD_SOCIACOMPLETA where CODSOCIA = '$cod_Socia') and ACTIVO = 'Y'";
        $datos = parent::obtenerDatos($query);
        return $datos;
    }
}
?>