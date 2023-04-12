<?php
require_once "../Clases/conexion/conexion.php";
require_once "../Clases/respuestas.class.php";
class Ordenes_Pagos extends conexion{
    private $Table = "Orden_Pagos";
    private $Table_restriccion = "ORD_FECHASACTIVAS";
    // Metodo Get
    public function RestriccionesOrdenesPagos($Json){
        $_respuestas = new respuestas;        
        $BodyJson = json_decode($Json,true);
        $DatosQuery = $this->RestriccionModulo($BodyJson);                            
        return $_respuestas->result_Busqueda($DatosQuery) ;      
    }

    public function ListarOrdenesPagos($Json){
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
                $DatosQuery = $this->ListarOrdenPago_User($BodyJson);                            
                return $_respuestas->result_Busqueda($DatosQuery) ;                                          
            } 
        }    
    } 

    public function ReportesOrdenesPagos($Json){
        $_respuestas = new respuestas;        
        $BodyJson = json_decode($Json,true);       
        // Ejecuta Funcion enviada en JSON
        $DatosQuery = $this->ListarOrdenPago($BodyJson);                            
        return $_respuestas->result_Busqueda($DatosQuery);                                            
    } 

    //Metodo POST 
    public function InsertOrdenesPagos($Json){
        $_respuestas = new respuestas;        
        $BodyJson = json_decode($Json,true);        
        $Token = $BodyJson['Token'];   
        
        // decodifica Token
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
                if(isset($BodyJson["INSERT_RESTRICCION"])){
                    $DatosQuery = $this->InsertRestriccion($BodyJson);                            
                    return $_respuestas->result_Busqueda($DatosQuery) ; 
                }else if(isset($BodyJson["cod_Region_busqueda"]) && isset($BodyJson["cod_Banco_busqueda"]) && isset($BodyJson["Token"]) ){   
                    $DatosQuery = $this->ConsultarSaldoBanco($BodyJson);                            
                    return $_respuestas->result_Busqueda($DatosQuery) ;
                }else if(isset($BodyJson["cod_Region"]) && isset($BodyJson["cod_Banco"]) && isset($BodyJson["cod_Anillo"]) && isset($BodyJson["fecha_Proceso"]) ){
                    $DatosQuery = $this->InsertOrdenePago($BodyJson);
                    return $_respuestas->result_Busqueda($DatosQuery);
                }else{

                } 
             
            } 
        }      
    }

    // METODO PUT
    public function ModificarOrdenPago($Json)
    {
        $_respuestas = new respuestas;        
        $BodyJson = json_decode($Json,true);
        $DatosQuery = $this->ModificaOrdenPago($BodyJson);                            
        return $_respuestas->result_Busqueda($DatosQuery) ; 
    }

    // METODO DELETE
    public function EliminarOrdenPago($Json)
    {
        $_respuestas = new respuestas;        
        $BodyJson = json_decode($Json,true);
        $DatosQuery = $this->EliminaOrdenPago($BodyJson);                            
        return $_respuestas->result_Busqueda($DatosQuery) ; 
    }

    //Funciones 
    Private function RestriccionModulo($Json){
        $FEC_ACTUAL = parent::Dateformat($Json['FEC_PRO_DIARIO']); 
        // Falta completar el procedure      
        $query = "SELECT count(*) as Resultado from ".$this->Table_restriccion." where format(FECHAPEDIDO,'dd-MM-yyyy') = '$FEC_ACTUAL' and ACTIVO = 'SI'";                 
        $datos = parent::obtenerDatos($query);
        return $datos;
    }

    private function InsertRestriccion($Json){
        $valor =  $Json['Valor'];  
        $FEC_ACTUAL = parent::Dateformat($Json['FEC_PROC_DIARIO']);  
        $query = "UPDATE ".$this->Table_restriccion." SET ACTIVO = '$valor' where format(FECHAPEDIDO,'dd-MM-yyyy') = '$FEC_ACTUAL'  ";
        $datos = parent::nonQuery($query);
        return $datos;        
    }

    private function ListarOrdenPago_User($Json){
        $Usuario = $Json['usuario_list'];
        $query = "SELECT * from ".$this->Table." where FECHA_CREACION = format(getdate(),'dd-MM-yyyy') and 
        CODSUCURSAL in ( select CODREGION from sec_users_sucursal where Login = '$Usuario' ) ";
        $data = parent::obtenerDatos($query);
        return $data;

    }

    private function ListarOrdenPago($Json){
        $cod_Region = $Json['cod_Region'];
        $fecha_Inicio = $Json['fecha_Inicio'];
        $fecha_Final = $Json['fecha_Final'];
        $tipo = $Json['Tipo'];        
        $query = "SELECT NOMSUCURSAL,CODASOCIACION,DESASOCIACION,CODASOCIACION_anillo,DESASOCIACION_anillo,FECHA_CREACION,FECHA_OPERACION,TIPO_OPERACION,TIPOCREDITO,NOMSOCIA,ImporteTotal,ENTIDADBANCARIA,NROCUENTA,NROCELULAR from (
            select NOMSUCURSAL,CODASOCIACION,DESASOCIACION,CODASOCIACION_anillo,DESASOCIACION_anillo,CONVERT(varchar(24), FECHA_CREACION,5) as FECHA_CREACION ,CONVERT(varchar(24), FECHA_OPERACION,5) as FECHA_OPERACION,TIPO_OPERACION,TIPOCREDITO,NOMSOCIA,ImporteTotal,ENTIDADBANCARIA,NROCUENTA,NROCELULAR 
            from Orden_Pagos where CODSUCURSAL like '%'+'$cod_Region' and  FECHA_OPERACION >= '$fecha_Inicio' and FECHA_OPERACION <= '$fecha_Final' and TIPO_OPERACION like '%'+'$tipo'
            union all
            select NOMSUCURSAL,'','','','','Total:','','','','',SUM(ImporteTotal) as ImporteTotal,'','','' 
            from Orden_Pagos where CODSUCURSAL like '%'+'$cod_Region' and  FECHA_OPERACION >= '$fecha_Inicio' and FECHA_OPERACION <= '$fecha_Final' and TIPO_OPERACION like '%'+'$tipo' group by NOMSUCURSAL 
            ) as u order by NOMSUCURSAL desc, FECHA_CREACION asc";
        $data = parent::obtenerDatos($query);
        return $data;

    } 

    private function ConsultarSaldoBanco($Json){
        $cod_Region = $Json['cod_Region_busqueda'];
        $name_Banco = $Json['cod_Banco_busqueda'];
        $query = "SET NOCOUNT ON; exec OBTENERNROCUENTA_ORDENPAGOS @CODREGION = '$cod_Region' , @CODASOCIACION = '$name_Banco'";
        $data = parent::obtenerDatos($query);
        return $data;
    }

    private function InsertOrdenePago($Json){
        $cod_Region = $Json['cod_Region'];
        $des_Region = $Json['des_Region'];
        $cod_Banco = $Json['cod_Banco'];
        $des_Banco = $Json['des_Banco'];
        $cod_Anillo = $Json['cod_Anillo'];
        $des_Anillo = $Json['des_Anillo'];
        $fecha_Proceso = parent::Dateformat($Json['fecha_Proceso']);
        $query = "SET NOCOUNT ON; exec InsertOrdenPagos @CODREGION = '$cod_Region', @Nomsucursal = '$des_Region' , @codasociacion = '$cod_Banco' ,
                 @desasociacion = '$des_Banco' , @Codanillo = '$cod_Anillo' , @DesAnillo = '$des_Anillo' , @Fechaproceso = '$fecha_Proceso' ";
        $data = parent::obtenerDatos($query);
        return $data;
    }

    private function ModificaOrdenPago($Json){
        $nro_Item = $Json['nro_Item'];
        $cod_Region = $Json['cod_Region'];
        $tipo_Operacion = $Json['tipo_Operacion'];
        $tipo_Credito = $Json['tipo_Credito'];
        $cod_Socia = $Json['cod_Socia'];
        $nom_Socia = $Json['name_Socia'];
        $entidad_Bancaria = $Json['entidad_Bancaria'];
        $importe_Total = $Json['importe_Total'];
        $nro_Cuenta = $Json['nro_Cuenta'];
        $nro_Celular = $Json['nro_Celular'];
        $cod_Banco = $Json['cod_Banco'];
        $query = "SET NOCOUNT ON;exec Modifica_Orden_pagos @item = '$nro_Item' , @region = '$cod_Region', @TipoOperacion = '$tipo_Operacion', 
        @TipoCredito = '$tipo_Credito', @CodSocia = '$cod_Socia', @Socia = '$nom_Socia', @EntidadBancaria = '$entidad_Bancaria', @ImporteTotal = '$importe_Total',
         @NroCuenta = '$nro_Cuenta', @Celular = '$nro_Celular', @CODBANCO = '$cod_Banco'";
        $data = parent::obtenerDatos($query);
        return $data;
    }


    private function EliminaOrdenPago($Json){
        $nro_Item = $Json['nro_Item'];
        $cod_Region = $Json['cod_Region']; 
        $query = "DELETE from ".$this->Table." where FECHA_CREACION = format(getdate(),'dd-MM-yyyy') and NroRegistro = '$nro_Item'  and CODSUCURSAL like '%'+'$cod_Region'";
        $data = parent::nonQuery($query);
        return $data;

    }

}
?> 