<?php
require_once "../Clases/conexion/conexion.php";
require_once "../Clases/respuestas.class.php";
require_once "../Clases/auth.class.php";

class Solicitudes extends conexion{
    private $Table = "SOL_CUADRODIARIO";
    private $Table_restriccion = "SOL_FECHASACTIVAS";
    //Method GET 
    public function ListarSociasSolicitudes($Json){
        $_respuestas = new respuestas;        
        $_auth = new auth; 
        $BodyJson = json_decode($Json,true);        
        $Token = $BodyJson['Token'];        
        //decodifica Token
        $TokenDecifrado =  parent::DecodToken($Token);
        //Estado de Token
        $EstadoToken = $_auth->VerificaRefreshToken($Token);
        // Valida Token
        if($TokenDecifrado == FALSE){
            return $_respuestas->error_401("El Token es invalido.");
        }else{
            // Valida el estado del token
            if($EstadoToken[0]['ESTADO'] == "0"){
                return $_respuestas->error_401("El Token vencido, vuelva a iniciar sesion.");
            }else{
            // Ejecuta Funcion enviada en JSON
                $DatosQuery = $this->ListarSocias($BodyJson);                            
                return $_respuestas->result_Busqueda($DatosQuery) ;                                          
            } 
        }    
    }
    
    public function RestriccionesSolicitudes($Json){
        $_respuestas = new respuestas;        
        $BodyJson = json_decode($Json,true);
        $DatosQuery = $this->RestriccionModulo($BodyJson);                            
        return $_respuestas->result_Busqueda($DatosQuery) ;      
    }

    public function ReportesSolicitudes($Json){
        $_respuestas = new respuestas;        
        $BodyJson = json_decode($Json,true);
        if($BodyJson['nro_Reporte'] == "R1"){
            $DatosQuery = $this->Reporte01($BodyJson);                            
            return $_respuestas->result_Busqueda($DatosQuery) ;
        }else if ( $BodyJson['nro_Reporte'] == "R2"){
            $DatosQuery = $this->Reporte02($BodyJson);                            
            return $_respuestas->result_Busqueda($DatosQuery) ;
        }else if ( $BodyJson['nro_Reporte'] == "R3"){
            $DatosQuery = $this->Reporte03($BodyJson);                            
            return $_respuestas->result_Busqueda($DatosQuery) ;            
        }else if ( $BodyJson['nro_Reporte'] == "R4"){
            $DatosQuery = $this->Reporte04($BodyJson);                            
            return $_respuestas->result_Busqueda($DatosQuery) ;
        }else if ( $BodyJson['nro_Reporte'] == "R5"){
            $DatosQuery = $this->Reporte05($BodyJson);                            
            return $_respuestas->result_Busqueda($DatosQuery) ;
        }
    }

    //Method Put
    public function ModificaSolicitud($Json){
        $_auth = new auth; 
        $_respuestas = new respuestas;        
        $BodyJson = json_decode($Json,true);        
        $Token = $BodyJson['Token'];        
        //decodifica Token
        $TokenDecifrado =  parent::DecodToken($Token);
        //Estado de Token
        $EstadoToken = $_auth->VerificaRefreshToken($Token);
        // Valida Token
        if($TokenDecifrado == FALSE){
            return $_respuestas->error_401("El Token es invalido.");
        }else{
            // Valida el estado del token
            if($EstadoToken[0]['ESTADO'] == "0"){
                return $_respuestas->error_401("El Token vencido, vuelva a iniciar sesion.");
            }else{
            // Ejecuta Funcion enviada en JSON
               $DatosQuery = $this->EditaSolicitud($BodyJson);                            
               return $_respuestas->result_Busqueda($DatosQuery) ;              
            } 
        }    
    }

    //Method Post
    public function InsertSolicitudes($Json){
        $_auth = new auth; 
        $_respuestas = new respuestas;        
        $BodyJson = json_decode($Json,true);        
        $Token = $BodyJson['Token'];        
        //decodifica Token
        $TokenDecifrado =  parent::DecodToken($Token);
        //Estado de Token
        $EstadoToken = $_auth->VerificaRefreshToken($Token);
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
                }elseif(isset($BodyJson["cod_Region"]) && isset($BodyJson["fecha_dia"])
                 && isset($BodyJson["tipo_banco"]) && isset($BodyJson["situacion"]) && isset($BodyJson["Token"]) ){   
                    if(!empty($BodyJson["cod_Banco"])){
                        $DatosQuery = $this->buscarSolicitud_delDia($BodyJson);  
                        if($DatosQuery[0]['Total'] == "1"){
                            return $_respuestas->result_Busqueda("Ya cuenta con una solicitud con la misma fecha") ;
                        }else{
                            $DatosQuery = $this->InsertBancosSolicitudes($BodyJson);                            
                            return $_respuestas->result_Busqueda("Solicitud ingresada correctamente");
                        }
                    }else{
                        $DatosQuery = $this->InsertBancosSolicitudes($BodyJson);                            
                        return $_respuestas->result_Busqueda("Solicitud ingresada correctamente");
                    }                    
                }else{

                } 
             
            } 
        }      
    }


    //Method DELETE
    public function EliminarSolicitudes($Json){
        $_auth = new auth; 
        $_respuestas = new respuestas;        
        $BodyJson = json_decode($Json,true);        
        $Token = $BodyJson['Token'];        
        //decodifica Token
        $TokenDecifrado =  parent::DecodToken($Token);
        //Estado de Token
        $EstadoToken = $_auth->VerificaRefreshToken($Token);
        // Valida Token
        if($TokenDecifrado == FALSE){
            return $_respuestas->error_401("El Token es invalido.");
        }else{
            // Valida el estado del token
            if($EstadoToken[0]['ESTADO'] == "0"){
                return $_respuestas->error_401("El Token vencido, vuelva a iniciar sesion.");
            }else{
            // Ejecuta Funcion enviada en JSON
               $DatosQuery = $this->EliminarSolicitud($BodyJson);                            
               return $_respuestas->result_Busqueda($DatosQuery) ;              
            } 
        }    
    }

    /*Funciones
        Listar Solicitudes Diarias
        Restriciones
        Editar Solicitudes 
    */

    Private function ListarSocias($Json){
        $FEC_ACTUAL = parent::Dateformat($Json['FEC_ACTUAL']);        
        // $FEC_ACTUAL = $Json['FEC_ACTUAL'];   
        $User = $Json['USER'];
        // Falta completar el procedure      
        $query = "SELECT
                CODREGION, 
                NOMBREREGION,
                DESASOCIACION,
                IIF(SITUACION = 'C','Banco Continuo','Banco Nuevo') as SITUACION,
                DESDEPA,
                DESPROVI,
                DESDISTRI,
                TIPOPRESTAMO,
                BANCONACION,
                BANCOCREDITO,
                ISNULL (CAJAPIURA,0.00) as CAJAPIURA,
                ISNULL (CAJATRUJILLO,0.00) as CAJATRUJILLO,
                ISNULL (BIM,0.00) as BIM,
                ISNULL (Coop_SanMartin,0.00) as Coop_SanMartin,
                EFECTIVO,
                FECHADESEMBOLSO,
                ANOPER+'-'+MESPER as Periodo,
                REG
                from ".$this->Table."  
                where FECHAPEDIDO = '$FEC_ACTUAL' and 
                CODREGION in ( select CODREGION from sec_users_sucursal where Login = '$User')";                 
        $datos = parent::obtenerDatos($query);
        return $datos;
    }

    Private function RestriccionModulo($Json){
        $FEC_ACTUAL = parent::Dateformat($Json['FEC_PRO_DIARIO']); 
        // Falta completar el procedure      
        $query = "SELECT count(*) as Resultado from SOL_FECHASACTIVAS where format(FECHAPEDIDO,'dd-MM-yyyy') = '$FEC_ACTUAL' and ACTIVO = 'SI'";                 
        $datos = parent::obtenerDatos($query);
        return $datos;
    }

    Private function InsertBancosSolicitudes($Json){
        $Cod_Region = $Json['cod_Region'];
        $Cod_Banco = $Json['cod_Banco'];
        $Fecha_Proc = parent::Dateformat($Json['fecha_dia']);
        // $Fecha_Proc = $Json['fecha_dia'];
        $Tipo = $Json['tipo_banco'];
        $Situacion = $Json['situacion'];
        // Falta completar el procedure      
        $query = "exec SP_SOL_INSERTABANCO
                 @CodRegion = '$Cod_Region' , @CodAsoc = '$Cod_Banco' , @FechaReg = '$Fecha_Proc' , @TipoDes = '$Tipo' , @Situ = '$Situacion'";
        $datos = parent::nonQuery($query);
        return $datos;
    }

    Private function buscarSolicitud_delDia($Json){
        $Cod_Banco = $Json['cod_Banco'];
        $Tipo = $Json['tipo_banco'];
        $query = "SELECT count(*) as Total from SOL_CUADRODIARIO where CODASOCIACION = '$Cod_Banco'  and TIPOPRESTAMO = '$Tipo' 
                    and FECHAPEDIDO >=  format(DATEADD(mm,DATEDIFF(mm,0,GETDATE()),0),'dd-MM-yyyy') 
                    and FECHAPEDIDO <= format(DATEADD(ms,-3,DATEADD(mm,0,DATEADD(mm,DATEDIFF(mm,0,GETDATE())+1,0))),'dd-MM-yyyy') ";
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

    //Funcion Elimina Solicitud
    Private function EliminarSolicitud($Json){
        $fecha_Pedido = parent::Dateformat($Json['fecha_Pedido']);        
        $nom_Region = $Json['nom_Region'];
        $nro_registro = $Json['nro_registro'];
        $query = "DELETE FROM ".$this->Table."  WHERE REG = '$nro_registro' and NOMBREREGION = '$nom_Region' and FECHAPEDIDO = '$fecha_Pedido' " ;
        $datos = parent::nonQuery($query);
        return $datos;
    }

    //Funcion Edita Solicitud
    Private function EditaSolicitud($Json){
        $nro_Registro = $Json['nro_Registro']; 
        $fecha_Proceso =  parent::Dateformat($Json['fecha_Proceso']); 
        $nom_Region = $Json['nom_Region'];  //3
        $banco_Nacion = $Json['banco_Nacion'];  //4
        $banco_Credito = $Json['banco_Credito'];  //5
        $bim = $Json['bim'];  //6
        $caja_Trujillo = $Json['caja_Trujillo'];  //7
        $caja_Piura = $Json['caja_Piura'];   //8
        $coope_SanMartin = $Json['coope_SanMartin'];  //9
        $pago_Efectivo = $Json['pago_Efectivo'];	//10	
        $fecha_Desembolso = parent::Dateformat($Json['fecha_Desembolso']);  //11
        $banco_Comunal = $Json['banco_Comunal'];  //12
        $des_departamento = $Json['des_departamento'];  //13
        $des_Provincia = $Json['des_Provincia'];  //14
        $des_Distrito = $Json['des_Distrito'];  //15
        $query = "SET NOCOUNT ON; exec USP_SOL_UPDATE '$fecha_Proceso','$banco_Comunal','$banco_Nacion','$banco_Credito','$bim','$caja_Trujillo','$caja_Piura','$coope_SanMartin','$pago_Efectivo','$fecha_Desembolso','$des_departamento','$des_Provincia','$des_Distrito','$nro_Registro','$nom_Region' ";
        $datos = parent::obtenerDatos($query);
        return $datos;
    }

    //Reportes 
    private function Reporte01($Json){
        $cod_Region = $Json['cod_Region'];
        $fecha_inicio = parent::Dateformat($Json['fecha_inicio']);
        $fecha_fin = parent::Dateformat($Json['fecha_fin']);
        $query = "SELECT * FROM (
            SELECT SOL_CUADRODIARIO.FECHACHAR,
                   SOL_CUADRODIARIO.NOMBREREGION,
                   SOL_CUADRODIARIO.TIPOASOCIACION,   
                   SOL_CUADRODIARIO.DESASOCIACION,     
                   SOL_CUADRODIARIO.TIPOPRESTAMO,   
                   SOL_CUADRODIARIO.BANCONACION,   
                   SOL_CUADRODIARIO.BANCOCREDITO,
                   isnull(SOL_CUADRODIARIO.BIM,'0') as BIM,
                   isnull(SOL_CUADRODIARIO.CAJAPIURA,'0') as CAJAPIURA,
                   isnull(SOL_CUADRODIARIO.CAJATRUJILLO,'0') as CAJATRUJILLO,
                   isnull(SOL_CUADRODIARIO.Coop_SanMartin,'0') as Coop_SanMartin,
                   CONVERT(varchar(24), SOL_CUADRODIARIO.FECHADESEMBOLSO,5) as FECHADESEMBOLSO,   
                   SOL_CUADRODIARIO.EFECTIVO  
            FROM SOL_CUADRODIARIO  
            WHERE ( SOL_CUADRODIARIO.CODREGION like '%'+'$cod_Region') AND  
                  ( SOL_CUADRODIARIO.FECHAPEDIDO >= '$fecha_inicio') AND  
                  ( SOL_CUADRODIARIO.FECHAPEDIDO <= '$fecha_fin') 
            union all                             
            SELECT '',SOL_CUADRODIARIO.NOMBREREGION, 
                   'TOTAL','','',sum(SOL_CUADRODIARIO.BANCONACION) as BANCONACION,   
                   sum(SOL_CUADRODIARIO.BANCOCREDITO) as BANCOCREDITO,
                   sum(isnull(SOL_CUADRODIARIO.BIM,'0')) as BIM,
                   sum(isnull(SOL_CUADRODIARIO.CAJAPIURA,'0')) as CAJAPIURA,
                   sum(isnull(SOL_CUADRODIARIO.CAJATRUJILLO,'0')) as CAJATRUJILLO,
                   sum(isnull(SOL_CUADRODIARIO.Coop_SanMartin,'0')) as Coop_SanMartin,
                   '',sum(SOL_CUADRODIARIO.EFECTIVO) as Efectivo  
            FROM SOL_CUADRODIARIO  
            WHERE ( SOL_CUADRODIARIO.CODREGION like '%'+'$cod_Region') AND  
                  ( SOL_CUADRODIARIO.FECHAPEDIDO >= '$fecha_inicio') AND  
                  ( SOL_CUADRODIARIO.FECHAPEDIDO <= '$fecha_fin') group by CODREGION,NOMBREREGION) as c order by   NOMBREREGION asc,TIPOASOCIACION asc";
        
        $datos = parent::obtenerDatos($query);
        return $datos;
    }

    private function Reporte02($Json){
        $cod_Region = $Json['cod_Region'];
        $fecha_inicio = parent::Dateformat($Json['fecha_inicio']);
        $fecha_fin = parent::Dateformat($Json['fecha_fin']);
        $query = "SELECT SOL_CUADRODIARIO.NOMBREREGION, 
        sum(SOL_CUADRODIARIO.BANCONACION) as BANCONACION,   
        sum(SOL_CUADRODIARIO.BANCOCREDITO) as BANCOCREDITO,
        sum(isnull(SOL_CUADRODIARIO.BIM,'0')) as BIM,
        sum(isnull(SOL_CUADRODIARIO.CAJAPIURA,'0')) as CAJAPIURA,
        sum(isnull(SOL_CUADRODIARIO.CAJATRUJILLO,'0')) as CAJATRUJILLO, 
        sum(isnull(SOL_CUADRODIARIO.Coop_SanMartin,'0')) as Coop_SanMartin, 
        sum(SOL_CUADRODIARIO.EFECTIVO) as Efectivo 
        FROM SOL_CUADRODIARIO  
        WHERE ( SOL_CUADRODIARIO.CODREGION like '%'+'$cod_Region') AND  
        ( SOL_CUADRODIARIO.FECHAPEDIDO >= '$fecha_inicio') AND  
        ( SOL_CUADRODIARIO.FECHAPEDIDO <= '$fecha_fin' ) group by  NOMBREREGION";
        $datos = parent::obtenerDatos($query);
        return $datos;
    }

    private function Reporte03($Json){
        $cod_Region = $Json['cod_Region'];
        $fecha_inicio = parent::Dateformat($Json['fecha_inicio']);
        $fecha_fin = parent::Dateformat($Json['fecha_fin']);
        $fecha_Mes = parent::DateMonth($Json['fecha_Periodo']);
        $fecha_Year = parent::DateYear($Json['fecha_Periodo']);
        $query = "SET NOCOUNT ON;EXEC SOL_REP_VERSUS_PROG_EJEC_Y_VIC  @FECHAINI = '$fecha_inicio' , @FECHAFIN = '$fecha_fin', @CODREGION = '$cod_Region', @MESPER = '$fecha_Mes', @ANOPER = '$fecha_Year' ";
        $datos = parent::obtenerDatos($query);
        return  $datos;
    }

    private function Reporte04($Json){
        $cod_Region = $Json['cod_Region'];
        $fecha_inicio = parent::Dateformat($Json['fecha_inicio']);
        $fecha_fin = parent::Dateformat($Json['fecha_fin']);
        $fecha_inicio_Dsb = parent::Dateformat($Json['fecha_inicio_Dsb']);
        $fecha_fin_Dsb = parent::Dateformat($Json['fecha_fin_Dsb']);
        $query = "SET NOCOUNT ON;EXEC SOL_REP_VERSUS_PROG_EJEC_Y_VIC_CONTA  @FECHAINI = '$fecha_inicio' , @FECHAFIN = '$fecha_fin', @FECHAINI_DSB = '$fecha_inicio_Dsb', @FECHAFIN_DSB = '$fecha_fin_Dsb', @CODREGION = '$cod_Region'";
        $datos = parent::obtenerDatos($query);
        return $datos;
    }

    private function Reporte05($Json){
        $usuario = $Json['Usuario'];
        $fecha_Actual = parent::Dateformat($Json['fecha_Actual']); 
        $query = "SELECT 
                    NOMBREREGION,
                    DESASOCIACION,
                    IIF(SITUACION = 'C','Banco Continuo','Banco Nuevo') as SITUACION,
                    DESDEPA,
                    DESPROVI,
                    DESDISTRI,
                    TIPOPRESTAMO,
                    BANCONACION,
                    BANCOCREDITO,
                    ISNULL (CAJAPIURA,0.00) as CAJAPIURA,
                    ISNULL (CAJATRUJILLO,0.00) as CAJATRUJILLO,
                    ISNULL (BIM,0.00) as BIM,
                    ISNULL (Coop_SanMartin,0.00) as Coop_SanMartin,
                    EFECTIVO,
                    FECHADESEMBOLSO,
                    ANOPER+'-'+MESPER as Periodo,
                    REG
                    from SOL_CUADRODIARIO 
                    where FECHAPEDIDO = '$fecha_Actual' and CODREGION in ( select CODREGION from sec_users_sucursal where Login = '$usuario')
                    ";
        $datos = parent::obtenerDatos($query);
        return $datos;
    }

}
?>