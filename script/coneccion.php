<?php   
class Modelador{
    
    function conexion()
    { 
        $hostname = "34.139.80.38";
         $dbname = "BD_CONSULTAS_BKP";
         $username = "app_contweb";
         $pw = 'YhQBBH5hXk';
        $dbh = new PDO ("sqlsrv:Server=$hostname;Database=$dbname","$username","$pw");
        if($dbh){
        #echo "Conectado";
        }else{
        echo "No conectado";
        }        
        return($dbh);
    }
    

    function sql_Login($ls){
         $sql = "SELECT SUBSTRING(a.name, 1, 21)+'.' as name,a.login,c.Nombre  from sec_users a inner join sec_users_groups b on a.login = b.login left join  sec_groups c on b.group_id = c.group_id where a.login = '{$ls['a1']}' and a.pswd = '{$ls['a2']}' ";

        return $sql;
     }
    function Busca_socia($ls){
         $sql = "SELECT APELLIDOSNOMBRES from SFD_SOCIACOMPLETA where  APELLIDOSNOMBRES like '%{$ls['a1']}%'";
        return $sql;
    }


     function _Cont_sql_str_proc_SP_RECUPERACIONES_VS_RVENTAS_V2($ls){
        $sql = "SET NOCOUNT ON;EXEC [BD_CREDIMUJER].[dbo].[SP_RECUPERACIONES_VS_RVENTAS_V2] @FECHAINICIO='{$ls['a1']}', @FECHAFIN='{$ls['a2']}'";

        return $sql;
    }

    function _Cont_sql_str_proc_SP_RECUPERACIONES_VS_Recuperaciones_ANALISIS_BVENTAS($ls){
        $sql = "SET NOCOUNT ON;EXEC [BD_CREDIMUJER].[dbo].[SP_RECUPERACIONES_VS_Recuperaciones_ANALISIS_BVENTAS] @FECHAINICIO='{$ls['a1']}', @FECHAFIN='{$ls['a2']}', @NroCredito='{$ls['a3']}'";

        return $sql;
    }

    function _Cont_sql_str_proc_SP_RECUPERACIONES_VS_RVENTAS_ANALISIS_BVENTAS($ls){
        $sql = "SET NOCOUNT ON;EXEC [BD_CREDIMUJER].[dbo].[SP_RECUPERACIONES_VS_RVENTAS_ANALISIS_BVENTAS] @FECHAINICIO='{$ls['a1']}', @FECHAFIN='{$ls['a2']}', @NroCredito='{$ls['a3']}'";

        return $sql;
    }

    function _Oper_sql_str_proc_SociasconSaldo($ls){
     $sql = "SET NOCOUNT ON;EXEC SociasconSaldo @FechaFin ='{$ls['a1']}'";

        return $sql;
    }

    function _Oper_sql_str_proc_ReporteRecuperacionesGerson($ls){
        $sql = "SET NOCOUNT ON;EXEC [BD_CREDIMUJER].[dbo].[ReporteRecuperacionesGerson] @FECHAIN='{$ls['a1']}', @FECHAFI='{$ls['a2']}'";

        return $sql;
    }

    function _Oper_sql_str_proc_OPE_REP_SOCIASACTIVAS_VERDESEMBOLSOS_2($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[OPE_REP_SOCIASACTIVAS_VERDESEMBOLSOS_2] @ANOPROCESO='{$ls['a1']}', @MESPROCESO='{$ls['a2']}', @CODREGION='{$ls['a3']}'";

        return $sql;
    }

    function _Cont_sql_proc_Nro_Cuenta($ls){
        $sql = "SET NOCOUNT ON;exec CUENT_ABONO_SOCIA_PROC '{$ls['a1']}','{$ls['a2']}','{$ls['a3']}'";

        return $sql;
    }
    function _Cont_sql_proc_Genera_Txt($ls){
        $sql = "SET NOCOUNT ON;EXEC SP_03BNCOS_GENERATABLA_BCP '{$ls['a1']}' , '{$ls['a2']}' ";

        return $sql;
    }

    function _Cont_sql_proc_GENERA_ARCHIVO_BCP($ls){
        $sql = "SET NOCOUNT ON;exec SP_04BNCOS_GENERAARCHIVO_BCP '{$ls['a1']}','{$ls['a2']}'";

        return $sql;
    }


    function _Cont_sql_proc_Recuperaciones_Total($ls){
        $sql = "SET NOCOUNT ON;exec [BD_CREDIMUJER].[dbo].SP_RECUPERACIONES_TOTALCONTABILIDAD '{$ls['a1']}','{$ls['a2']}'";

        return $sql;
    }

    function _Cont_Elimina_Socia_envio_bcp($ls){
    $sql = "delete from TENVIOBCP where fechaproceso = '{$ls['a1']}' and CODREGION = '{$ls['a2']}' and NRODNI = '{$ls['a3']}'   and MTOADICIONAL > 0.00 and CARGATABLA = 'N'";

        return $sql;
    }

    function _Cont_EditaSocia_bcp_dj($ls){
    $sql = " UPDATE TENVIOBCP set MTOADICIONAL = '{$ls['a4']}'  where NRODNI = '{$ls['a3']}' and CODREGION = '{$ls['a2']}' and fechaproceso = '{$ls['a1']}' and CARGATABLA = 'N'";

        return $sql;
    }

    function _Ope_sql_proc_Visualizacion_BIM_DJ($ls){
        $sql = "SET NOCOUNT ON;exec SP_04BNCOS_GeneraVisualizacion_BIM '{$ls['a1']}' ";

        return $sql;
    }

    function _Ope_EditaSocia_BIM_dj($ls){
    $sql = "update TENVIOBIM set MTOADICIONAL = '{$ls['a4']}' where NRODNI = '{$ls['a3']}' and CODREGION = '{$ls['a2']}' and  fechaproceso  =  '{$ls['a1']}' ";

        return $sql;
    }

    function _Ope_Elimina_Socia_envio_bim($ls){
    $sql = "delete from TENVIOBIM where fechaproceso = '{$ls['a1']}' and CODREGION = '{$ls['a2']}' and NRODNI = '{$ls['a3']}'   and MTOADICIONAL > 0.00 ";

        return $sql;
    }

    function _Ope_proc_Socias_envio_Final_bim($ls){
    $sql = " SET NOCOUNT ON; EXEC SP_03BNCOS_GENERATABLA_BIM '{$ls['a1']}'";
        return $sql;
    }

    function _Ope_selec_Socias_envio_Final_bim($ls){
    $sql = " SET NOCOUNT ON;
            select REGION,BANCO_COMUNAL,SOCIA,DNI,CELULAR,MONTO,FECHA_DESEMBOLSO,TIPOCOBRO from (
                select 
                REGION,
                DESASOCIACION AS BANCO_COMUNAL,
                APELLIDOSNOMBRES AS SOCIA,
                NRODNI AS DNI,
                CELULAR,
                MTOADICIONAL AS MONTO,
                format(FECHADESEMBOLSO,'dd-MM-yyyy') as FECHA_DESEMBOLSO,
                TIPOCOBRO
                from TENVIOBIM_FINAL 
                where 
        FECHADESEMBOLSO >= '{$ls['a1']}'  and FECHADESEMBOLSO <= '{$ls['a1']}' 
                union all
                select '','Total','','','',SUM(MTOADICIONAL),'','' from TENVIOBIM_FINAL where 
       FECHADESEMBOLSO >= '{$ls['a1']}'  and FECHADESEMBOLSO <= '{$ls['a1']}'  ) as b order by socia desc
                 ";
        return $sql;
    }

    function _Ope_DA_Socia_BIM($ls){
    $sql = " Set NOCOUNT ON; EXEC SP_BIM_DA_BUSCAR_SOCIA '{$ls['a1']}' , '{$ls['a2']}'";
        return $sql;
    }

    function _Ope_DA_Socia_Bn($ls){
    $sql = " Set NOCOUNT ON; EXEC SP_BN_DA_BUSCAR_SOCIA '{$ls['a1']}' , '{$ls['a2']}'";
        return $sql;
    }

    function _GuardaSocia_DA_Bim($ls){
    $sql = "SET NOCOUNT ON; exec insertDABIM '{$ls['a1']}' , '{$ls['a2']}', '{$ls['a3']}', '{$ls['a4']}', '{$ls['a5']}', '{$ls['a6']}', '{$ls['a7']}', '{$ls['a8']}', '{$ls['a9']}', '{$ls['a10']}', '{$ls['a11']}', '{$ls['a12']}', '{$ls['a13']}', '{$ls['a14']}', '{$ls['a15']}', '{$ls['a16']}', '{$ls['a17']}', '{$ls['a18']}' ";
        return $sql;
    }

    function _GuardaSocia_DA_Bn($ls){
    $sql = "SET NOCOUNT ON; exec insertDABn '{$ls['a1']}' , '{$ls['a2']}', '{$ls['a3']}', '{$ls['a4']}', '{$ls['a5']}', '{$ls['a6']}', '{$ls['a7']}', '{$ls['a8']}', '{$ls['a9']}', '{$ls['a10']}', '{$ls['a11']}', '{$ls['a12']}', '{$ls['a13']}', '{$ls['a14']}', '{$ls['a15']}', '{$ls['a16']}', '{$ls['a17']}' ";
        return $sql;
    }

   function _Ope_Insert_Manual_socia_Busqueda($ls){
    $sql = " Set NOCOUNT ON; EXEC SP_BN07SOCIASAINSERTAR '{$ls['a1']}' , '{$ls['a2']}'";
        return $sql;
    }

    function _Ope_Insert_Manual_socia($ls){
    $sql = " Set NOCOUNT ON; execute SP_BN06INSERTASOCIAMANUAL '{$ls['a1']}' , '{$ls['a2']}' , '{$ls['a3']}' , '{$ls['a4']}' , '{$ls['a5']}' , '{$ls['a6']}' , '{$ls['a7']}' , '{$ls['a8']}' , '{$ls['a9']}' , '{$ls['a10']}' , '{$ls['a11']}' , '{$ls['a12']}' , '{$ls['a13']}' , '{$ls['a14']}' , '{$ls['a15']}' , '{$ls['a16']}' , '{$ls['a17']}' ,'{$ls['a18']}' ";
        return $sql;
    }

    function _Visualiza_SociaEnviadas_BN($ls){
        $sql = "Set NOCOUNT ON; exec Ver_sociasEnviadasBN '{$ls['a1']}','{$ls['a2']}' ";

         return $sql;
    }

    function _Inserta_Socia_Anulados($ls){
        $sql = "Set NOCOUNT ON;execute SP_BN08TRASLADAANULADO @dFECHAPROCEBN ='{$ls['a1']}', @dFECHAENVIO = '{$ls['a2']}' , @vNRODNI = '{$ls['a3']}' , @vCODREGION = '{$ls['a4']}' ";

        return $sql;
    }

    function OPE_REPO_OFICIALCREDITO2_v2($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[OPE_REPO_OFICIALCREDITO2_v2] @MES ='{$ls['a1']}', @ANO ='{$ls['a2']}', @REGION ='{$ls['a3']}'";

        return $sql;
    }

    function RSG_PREEVALUADOR_CAB_DET($ls){
        $sql = "SELECT 
                a.dni,a.nombrecompleto,a.bancocomunal,a.fecha,a.fechamodificada,a.asesor,a.monto,a.plazo,a.cuota,a.nivelriesgo,a.subneto,
                a.deudaexterna,a.ingresoneto,a.capacidadpago,b.AE1,b.AE2,b.AE3,b.AE4,b.AE5,b.MU1,b.MU2,b.MU3,b.MU4,b.MU5,b.FE1,b.FE2,
                b.FE3,b.FE4,b.FE4,b.VMAX1,b.VMAX2,b.VMAX3,b.VMAX4,b.VMAX5,b.VMIN1,b.VMIN2,b.VMIN3,b.VMIN4,b.VMIN5,b.RESULT1,b.RESULT2,
                b.RESULT3,b.RESULT4,b.RESULT5
                from rsg_preevaluador a inner join rsg_preevaluador_det b on a.dni = b.DNI
                where ( a.fecha >= '{$ls['a1']}' and  a.fecha <= '{$ls['a2']}' 
                or a.fechamodificada >= '{$ls['a1']}' and  a.fechamodificada <= '{$ls['a2']}' )
                and  b.fechaRegis >= '{$ls['a1']}' and  b.fechaRegis <= '{$ls['a2']}'  ";

        return $sql;
    } 

    function OPE_REPO_OFICIALCREDITO1($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[OPE_REPO_OFICIALCREDITO1] @MES ='{$ls['a1']}', @ANO ='{$ls['a2']}', @REGION ='{$ls['a3']}' ";

        return $sql;
    }

    function OPE_REPO_OFICIALCREDITO2_v3($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[OPE_REPO_OFICIALCREDITO2_v3] @MES ='{$ls['a1']}', @ANO ='{$ls['a2']}', @REGION ='{$ls['a3']}' ";

        return $sql;
    }
     function AUD_ACTIVA_TRANSITO_PERIODO($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[AUD_ACTIVA_TRANSITO_PERIODO] @MES ='{$ls['a1']}', @ANO ='{$ls['a2']}', @REGION ='{$ls['a3']}' ";

        return $sql;
    }
    function AUD_SEGUIMIENTO_CARTERA_ACTIVA($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[AUD_SEGUIMIENTO_CARTERA_ACTIVA] @MES ='{$ls['a1']}', @ANO ='{$ls['a2']}', @REGION ='{$ls['a3']}' ";

        return $sql;
    }

    function AUD_CARTERA_SENTINEL_v7($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[AUD_CARTERA_SENTINEL_v7] @MES ='{$ls['a1']}', @ANO ='{$ls['a2']}', @REGION ='{$ls['a3']}' ";

        return $sql;
    }
    function AUD_CARTERA_MAYOR_MONTOING($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[AUD_CARTERA_MAYOR_MONTOING] @FECHAINI ='{$ls['a1']}', @FECHAFIN ='{$ls['a2']}', @REGION ='{$ls['a3']}' ,  @MONTOMAYOR ='{$ls['a4']}' ";

        return $sql;
    }
    function AUD_REPORTE_PROYEC_GRAL($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[AUD_REPORTE_PROYEC_GRAL] @codregion ='{$ls['a1']}', @fechaini_venc ='{$ls['a2']}', @fechafin_venc ='{$ls['a3']}' ";

        return $sql;
    }

    function SP_BNP_REPORTE_NOCOBRADOS(){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[SP_BNP_REPORTE_NOCOBRADOS]";

        return $sql;
    }
    
    function REP_BN_COBRANZADIARIA($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[REP_BN_COBRANZADIARIA]  @dFECHA_INI = '{$ls['a1']}', @dFECHA_FIN = '{$ls['a2']}', @vCOD_REGION = '{$ls['a3']}' ";

        return $sql;
    }

    function REP_BN_COBRANZADIARIA_DA($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[REP_BN_COBRANZADIARIA_DA]  @dFECHA_INI = '{$ls['a1']}', @dFECHA_FIN = '{$ls['a2']}', @vCOD_REGION = '{$ls['a3']}' ";

        return $sql;
    }

    function REP_BN_ENVIODIARIO($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[REP_BN_ENVIODIARIO]  @dFECHA_INI = '{$ls['a1']}', @dFECHA_FIN = '{$ls['a2']}', @vCOD_REGION = '{$ls['a3']}' ";

        return $sql;
    }

    function REP_BN_ENVIODIARIO_DA($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[REP_BN_ENVIODIARIO_DA]  @dFECHA_INI = '{$ls['a1']}', @dFECHA_FIN = '{$ls['a2']}', @vCOD_REGION = '{$ls['a3']}' ";
        
        return $sql;
    }

    function SP_BNP_REPORTE_RESUMENCOBRADOS($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[SP_BNP_REPORTE_RESUMENCOBRADOS]  @fechaini = '{$ls['a1']}', @fechafin = '{$ls['a2']}' ";

        return $sql;
    }
    function BCP_CUADRO_RECUPERACIONES_RESGUARDO($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[BCP_CUADRO_RECUPERACIONES_RESGUARDO]  @FechaIni = '{$ls['a1']}', @FechaFin = '{$ls['a2']}',  @CodRegion = '{$ls['a3']}' ";

        return $sql;
    }
    function REP_SOLICITUDES_DESEMBOLSOS($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[REP_SOLICITUDES_DESEMBOLSOS]  @FECHA_INI = '{$ls['a1']}', @FECHA_FIN = '{$ls['a2']}',  @CODREGION = '{$ls['a3']}' ";

        return $sql;
    }
    function OPE_REP_SOLICITUDES_DESEMBOLSOS_CONTROL($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[OPE_REP_SOLICITUDES_DESEMBOLSOS_CONTROL]  @CODREGION = '{$ls['a1']}', @FECHA_FIN = '{$ls['a2']}',  @FECHA_INI = '{$ls['a3']}' ";

        return $sql;
    }
    function SP_REPORTE_CONTA_REGISTRO_DE_VENTAS($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[SP_REPORTE_CONTA_REGISTRO_DE_VENTAS]  @dFECHAINI = '{$ls['a1']}', @dFECHAFIN = '{$ls['a2']}',  @nTIPOCAMBIO = '{$ls['a3']}' ";

        return $sql;
    }

    function ReporteMigradoContabilidad02($ls){
        $sql = "SELECT  REG_VENTAS_DET.ANOPROCESO ,
                  REG_VENTAS_DET.MESPROCESO ,
                  REG_VENTAS_DET.CODREGION ,
                  REG_VENTAS_DET.CODCLIENTE ,
                  REG_VENTAS_DET.CORRE ,
                  REG_VENTAS_DET.FECHAEMI1 ,
                  REG_VENTAS_DET.FECHAVCTO ,
                  REG_VENTAS_DET.TIPO_COM1 ,
                  REG_VENTAS_DET.SERIE_COM1 ,
                  REG_VENTAS_DET.NRO_COM1 ,
                  REG_VENTAS_DET.TIPO_DOCID ,
                  REG_VENTAS_DET.NRO_DOCID ,
                  REG_VENTAS_DET.APENOM_RSOC ,
                  REG_VENTAS_DET.VALOR_FACTEXP ,
                  REG_VENTAS_DET.INTERES ,
                  REG_VENTAS_DET.COMISIONES ,
                  REG_VENTAS_DET.IMP_EXONE ,
                  REG_VENTAS_DET.IMP_INAFE ,
                  REG_VENTAS_DET.ISC ,
                  REG_VENTAS_DET.IGV ,
                  REG_VENTAS_DET.OTROS ,
                  REG_VENTAS_DET.IMP_TOTAL ,
                  REG_VENTAS_DET.TCAMBIO ,
                  REG_VENTAS_DET.FECHA_EMI2 ,
                  REG_VENTAS_DET.TIPO_COM2 ,
                  REG_VENTAS_DET.SERIE_COM2 ,
                  REG_VENTAS_DET.NRO_COM2 ,
                  REG_VENTAS_DET.ESTADO ,
                  REG_VENTAS_DET.TIPOPRODU ,
                  REG_VENTAS_DET.CODMONEDA  
                  FROM REG_VENTAS_DET
                  WHERE  REG_VENTAS_DET.ANOPROCESO = '{$ls['a1']}'  and
                   REG_VENTAS_DET.MESPROCESO = '{$ls['a2']}'  and
                   REG_VENTAS_DET.CODREGION like '{$ls['a3']}'";

        return $sql;
    }

    function SP_REPORTE01_PROYEC_REC_CEXT($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[SP_REPORTE01_PROYEC_REC_CEXT]  @dFECHA_INI = '{$ls['a1']}', @dFECHA_FIN = '{$ls['a2']}',  @vCOD_REGION = '{$ls['a3']}' , @vTIPO_ASOC = '%' ";

        return $sql;
    }

    function SP_REPORTE04_PROYEC_GRAL($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[SP_REPORTE04_PROYEC_GRAL]  @dFECHAINI = '{$ls['a1']}', @dFECHAFIN = '{$ls['a2']}'  ";

        return $sql;
    }

    function IND_CREC_Y_ALC_01($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[IND_CREC_Y_ALC_01]  @dFECHA_INI = '{$ls['a1']}', @dFECHA_FIN = '{$ls['a2']}', @vCOD_REGION = '{$ls['a3']}'  ";

        return $sql;
    }

    function IND_CREC_Y_ALC_01_RES($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[IND_CREC_Y_ALC_01_RES]  @dFECHA_INI = '{$ls['a1']}', @dFECHA_FIN = '{$ls['a2']}', @vCOD_REGION = '{$ls['a3']}'  ";

        return $sql;
    }

    function IND_CREC_Y_ALC_03($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[IND_CREC_Y_ALC_03]  @dFECHA_INI = '{$ls['a1']}', @dFECHA_FIN = '{$ls['a2']}', @vCOD_REGION = '{$ls['a3']}'  ";

        return $sql;
    }

    function IND_CREC_Y_ALC_04($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[IND_CREC_Y_ALC_04]  @FECHACORTE = '{$ls['a1']}' ";

        return $sql;
    }

    function IND_CREC_Y_ALC_05($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[IND_CREC_Y_ALC_05]  @FECHACORTE = '{$ls['a1']}' ";

        return $sql;
    }

    function IND_CREC_Y_ALC_05_RES($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[IND_CREC_Y_ALC_05_RES]  @FECHACORTE = '{$ls['a1']}' ";

        return $sql;
    }

    function IND_EFIC_Y_PROD_01($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[IND_EFIC_Y_PROD_01]  @FECHACORTE = '{$ls['a1']}' ";

        return $sql;
    }

    function IND_EFIC_Y_PROD_02($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[IND_EFIC_Y_PROD_02]  @dFECHACORTE = '{$ls['a1']}' ";

        return $sql;
    }

    function IND_EFIC_Y_PROD_06($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[IND_EFIC_Y_PROD_06] @dFECHA_INI = '{$ls['a1']}', @dFECHA_FIN = '{$ls['a2']}', @vCOD_REGION = '{$ls['a3']}'";

        return $sql;
    }

    function IND_EFIC_Y_PROD_11($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[IND_EFIC_Y_PROD_11]  @dFECHACORTE = '{$ls['a1']}' ";

        return $sql;
    }
    function IND_EFIC_Y_PROD_12($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[IND_EFIC_Y_PROD_12]  @dFECHAINI = '{$ls['a1']}', @dFECHAFIN = '{$ls['a2']}', @vCOD_REGION = '{$ls['a3']}'";

        return $sql;
    }

    function IND_EFIC_Y_PROD_20(){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[IND_EFIC_Y_PROD_20] ";

        return $sql;
    }

    function IND_GESTION_SOCECO_01($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[IND_GESTION_SOCECO_01]   @dFECHA_INI = '{$ls['a1']}', @dFECHA_FIN = '{$ls['a2']}', @vCOD_REGION = '{$ls['a3']}'";

        return $sql;
    }

    function IND_GESTION01($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[IND_GESTION01]   @MES = '{$ls['a1']}', @ANO = '{$ls['a2']}' ";

        return $sql;
    }

    function REP_IND_CONSOLIDADO_005($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[REP_IND_CONSOLIDADO_005]  @vMES = '{$ls['a1']}', @vANO = '{$ls['a2']}' ";

        return $sql;
    }

    function ENVIOS_BIM($ls){
        $sql = "SET NOCOUNT ON;select REGION,DESASOCIACION,APELLIDOSNOMBRES,NRODNI,CELULAR,MTOADICIONAL,FECHADESEMBOLSO,FECHAPROCESOBIM,TIPOCOBRO from(
        select REGION,DESASOCIACION,APELLIDOSNOMBRES,NRODNI,CELULAR,MTOADICIONAL,format(FECHADESEMBOLSO , 'dd-MM-yyyy') as FECHADESEMBOLSO,FECHAPROCESOBIM ,TIPOCOBRO from TENVIOBIM_FINAL where FECHADESEMBOLSO >= '{$ls['a1']}'  and FECHADESEMBOLSO <= '{$ls['a2']}'  and 
                    REGION like '%'+'{$ls['a3']}'+'%'
        union all
        select REGION,'Total Diario','','','',sum(MTOADICIONAL),'',FECHAPROCESOBIM,'' from TENVIOBIM_FINAL where FECHADESEMBOLSO >= '{$ls['a1']}'  and FECHADESEMBOLSO <= '{$ls['a2']}'  and 
                    REGION like '%'+'{$ls['a3']}'+'%'    group by FECHAPROCESOBIM,REGION) as b order by ";

        return $sql;
    }

    function REP_SINFO_RANGOS_MONTOSYPLAZOS($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[REP_SINFO_RANGOS_MONTOSYPLAZOS]  @FECHAINI = '{$ls['a1']}', @FECHAFIN = '{$ls['a2']}' , @TC = '{$ls['a3']}' ";

        return $sql;
    }

    function REP_SINFO_SECTORECONOMICO($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[REP_SINFO_SECTORECONOMICO]  @FECHAINI = '{$ls['a1']}', @FECHAFIN = '{$ls['a2']}' ";

        return $sql;
    }

    function REP_SINFO_SEXO($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[REP_SINFO_SEXO]  @FECHAINI = '{$ls['a1']}', @FECHAFIN = '{$ls['a2']}' ";

        return $sql;
    }

    function REP_OPE_PARALELO_CARTERA_ACTIVA($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[REP_OPE_PARALELO_CARTERA_ACTIVA]  @CODREGION = '{$ls['a1']}', @ANO = '{$ls['a2']}', @MES = '{$ls['a3']}' ";

        return $sql;
    }

    function REP_OPE_PARALELO_DESEMBOLSOS($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[REP_OPE_PARALELO_DESEMBOLSOS]  @CODREGION = '{$ls['a1']}', @FECHAINICIAL = '{$ls['a2']}', @FECHAFINAL = '{$ls['a3']}' ";

        return $sql;
    }

    function OPE_REP_PROMOCIONALES_CARTERA_v2($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[OPE_REP_PROMOCIONALES_CARTERA_v2]  @MES = '{$ls['a1']}', @ANO = '{$ls['a2']}',  @REGION  = '{$ls['a3']}' , @PROMOTORA = '%' ";

        return $sql;
    }

    function OPE_REP_PROMOCIONALES_DSBS_v2($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[OPE_REP_PROMOCIONALES_DSBS_v2] @FECHAINI = '{$ls['a1']}',  @FECHAFIN = '{$ls['a2']}',  @CODREGION   = '{$ls['a3']}' , @CODPROMOTORA = '%' ";

        return $sql;
    }

    function OPE_REP_PROMOCIONALESNUEVOS_CA($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[OPE_REP_PROMOCIONALESNUEVOS_CA] @codregion = '{$ls['a1']}',  @ano = '{$ls['a2']}',  @mes   = '{$ls['a3']}'  ";

        return $sql;
    }

    function OPE_REP_PROMOCIONALESNUEVOS_DE($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[OPE_REP_PROMOCIONALESNUEVOS_DE] @codregion = '{$ls['a1']}',  @fechainicio = '{$ls['a2']}',  @fechafin   = '{$ls['a3']}'  ";

        return $sql;
    }
// --------------------------------------------------
    function OPE_REP_05_INFOGENERAL($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[OPE_REP_05_INFOGENERAL] @MES = '{$ls['a1']}',  @ano = '{$ls['a2']}',  @region   = '{$ls['a3']}'  ";

        return $sql;
    }

    function OPE_DSB_05_INFOGENERAL($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[OPE_DSB_05_INFOGENERAL] @FECHAINI = '{$ls['a1']}',  @FECHAFIN = '{$ls['a2']}',  @REGION   = '{$ls['a3']}' , @CODPROMOTORA = '%' ";

        return $sql;
    }

    function OPE_RETIRADAS_DETALLE_v3($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[OPE_RETIRADAS_DETALLE_v3] @MES = '{$ls['a1']}',  @ANO = '{$ls['a2']}',  @REGION   = '{$ls['a3']}'  ";

        return $sql;
    }

    function OPE_REP_NUEVAS_CONPROM_v2($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[OPE_REP_NUEVAS_CONPROM_v2] @FECHAINI = '{$ls['a1']}',  @FECHAFIN = '{$ls['a2']}',  @CODREGION   = '{$ls['a3']}' , @CODPROMOTORA = '%' ";

        return $sql;
    }

    function INFO_FINAN_GENERAL($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[INFO_FINAN_GENERAL] @MES = '{$ls['a1']}',  @ANO = '{$ls['a2']}',  @REGION   = '{$ls['a3']}'  ";

        return $sql;
    }

    function INFO_FINAN_POR_MONTOS_V2($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[INFO_FINAN_POR_MONTOS_V2]  @MES = '{$ls['a1']}', @ANO = '{$ls['a2']}', @REGION = '{$ls['a3']}', @TIPOCAMBIO = '{$ls['a4']}' ";

        return $sql;
    }

    function OPE_REPORTECARTERAACTIVA($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[OPE_REPORTECARTERAACTIVA] @mes = '{$ls['a1']}',  @ano = '{$ls['a2']}',  @codregion   = '{$ls['a3']}' , @coddepa = '%' ";

        return $sql;
    }

    // // function OPE_REPORTECARTERAACTIVA_RSM($ls){
    // //     $sql = "SET NOCOUNT ON;EXEC  [dbo].[OPE_REPORTECARTERAACTIVA_RSM] @mes = '{$ls['a1']}',  @ano = '{$ls['a2']}',  @codregion   = '{$ls['a3']}' , @coddepa = '%' ";

    // //     return $sql;
    // // }

    function OPE_REPORTECARTERAACTIVA_XDIS($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[OPE_REPORTECARTERAACTIVA_XDIS] @mes = '{$ls['a1']}',  @ano = '{$ls['a2']}',  @codregion   = '{$ls['a3']}' , @coddepa = '%' ";

        return $sql;
    }

    function INFO_FINAN_POR_AREA_v2($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[INFO_FINAN_POR_AREA_v2] @MES = '{$ls['a1']}',  @ANO = '{$ls['a2']}',  @REGION   = '{$ls['a3']}'  ";

        return $sql;
    }

    function INFO_FINAN_POR_CUOTAS_V2($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[INFO_FINAN_POR_CUOTAS_V2] @MES = '{$ls['a1']}',  @ANO = '{$ls['a2']}',  @REGION   = '{$ls['a3']}'  ";

        return $sql;
    }

    function INFO_FINAN_POR_PZO_VENC_V2($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[INFO_FINAN_POR_PZO_VENC_V2] @MES = '{$ls['a1']}',  @ANO = '{$ls['a2']}',  @REGION   = '{$ls['a3']}'  ";

        return $sql;
    }

    function INFO_FINAN_POR_SEC_ECO_V2($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[INFO_FINAN_POR_SEC_ECO_V2] @MES = '{$ls['a1']}',  @ANO = '{$ls['a2']}',  @REGION   = '{$ls['a3']}'  ";

        return $sql;
    }

    function INFO_FINAN_POR_SEXO_V2($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[INFO_FINAN_POR_SEXO_V2] @MES = '{$ls['a1']}',  @ANO = '{$ls['a2']}',  @REGION   = '{$ls['a3']}'  ";

        return $sql;
    }   

    function OPE_REP_SOCIASNUEVAS_X_ANO($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[OPE_REP_SOCIASNUEVAS_X_ANO]   @ANO = '{$ls['a1']}',  @CODREGION   = '{$ls['a2']}'   ";

        return $sql;
    }

    function OPE_REP_SOCIASNUEVAS_X_ANO_DESERCION($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[OPE_REP_SOCIASNUEVAS_X_ANO_DESERCION] @CODREGION = '{$ls['a1']}', @FECHAINI = '{$ls['a2']}', @FECHAFIN = '{$ls['a3']}', @FECHACORTE = '{$ls['a4']}'";

        return $sql;
    }

    function OPE_REP_SOCIAS_CON_SIN_CEXT_CPRO_X_CLI_V2($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[OPE_REP_SOCIAS_CON_SIN_CEXT_CPRO_X_CLI_V2] @ANOPROCESO = '{$ls['a1']}' ,  @MESPROCESO = '{$ls['a2']}', @CODREGION = '{$ls['a3']}' ";

        return $sql;
    }

    function OPE_REP_LISTASOCIAS_CONMORA_FINDEMES_v2($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[OPE_REP_LISTASOCIAS_CONMORA_FINDEMES_v2]  @MES = '{$ls['a1']}',  @ANO   = '{$ls['a2']}', @REGION = '{$ls['a3']}' ,  @MONTOMAY = '{$ls['a4']}'  ";

        return $sql;
    }

    function OPE_BANCOS_EVAL_ANILLOS($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[OPE_BANCOS_EVAL_ANILLOS] @MES = '{$ls['a1']}', @ANO = '{$ls['a2']}', @CODREGION = '{$ls['a3']}'  ";

        return $sql;
    }

    function OPE_REP_REINGRESANTES($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[OPE_REP_REINGRESANTES] @FECHAINI = '{$ls['a1']}',  @FECHAFIN = '{$ls['a2']}',  @CODREGION   = '{$ls['a3']}' , @CODPROMOTORA = '%'  ";

        return $sql;
    }

    function AUD_DESEMBOLSO_MAYOR_MONTOING($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[AUD_DESEMBOLSO_MAYOR_MONTOING] @FECHAINI = '{$ls['a1']}',  @FECHAFIN = '{$ls['a2']}',  @REGION   = '{$ls['a3']}' ,  @MONTOMAYOR = '{$ls['a4']}'   ";

        return $sql;
    }

    function OPE_REPORTE_CONTROLPAGOS_SOCIAS($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[OPE_REPORTE_CONTROLPAGOS_SOCIAS] @mes = '{$ls['a1']}',  @ano = '{$ls['a2']}',  @region   = '{$ls['a3']}'  ";

        return $sql;
    }

    function OPE_REPORTE_F1_INFORMACIONSOCIAS_v4($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[OPE_REPORTE_F1_INFORMACIONSOCIAS_v4] @mes = '{$ls['a1']}' , @ano = '{$ls['a2']}', @region = '{$ls['a3']}' ";

        return $sql;
    } 

    function OPE_REPORTE_CARTERA_RESUMEN_PARALELOS($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[OPE_REPORTE_CARTERA_RESUMEN_PARALELOS] @MES = '{$ls['a1']}', @ANO = '{$ls['a2']}', @REGION = '{$ls['a3']}', @PRODUCTO = '%', @CODPROMOTORA = '%' ";

        return $sql;
    }

    function OPE_REPORTE_DESEMBOLSOS_RESUMEN_PARALELOS($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[OPE_REPORTE_DESEMBOLSOS_RESUMEN_PARALELOS] @ANO = '{$ls['a1']}', @MES = '{$ls['a2']}', @PRODUCTO = '%', @PROMOTORA = '%', @REGION = '{$ls['a3']}'  ";

        return $sql;
    }

    function OPE_REPORTECARTERAACTIVA_SOLO_PAR_IND($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[OPE_REPORTECARTERAACTIVA_SOLO_PAR_IND] @mes = '{$ls['a1']}' , @ano = '{$ls['a2']}' , @codregion = '{$ls['a3']}' , @coddepa = '%' ";

        return $sql;
    }

    function OPE_REP_SOCIASDESEMBOLSOS($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[OPE_REP_SOCIASDESEMBOLSOS] @CODREGION = '{$ls['a1']}',  @FechaFin = '{$ls['a2']}',  @FechaIni   = '{$ls['a3']}'  ";

        return $sql;
    }

    function OPE_REP_LISTASOCIAS_CONMORA_CP_v2($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[OPE_REP_LISTASOCIAS_CONMORA_CP_v2] @MES = '{$ls['a1']}',  @ANO = '{$ls['a2']}',  @REGION   = '{$ls['a3']}'  ";

        return $sql;
    }

    

    function OPE_REPORTECARTERAACTIVA_SOLO_SOCIAS_ACT($ls){
        $sql = "SET NOCOUNT ON;EXEC  [dbo].[OPE_REPORTECARTERAACTIVA_SOLO_SOCIAS_ACT] @mes = '{$ls['a1']}',  @ano = '{$ls['a2']}',  @codregion   = '{$ls['a3']}' , @coddepa = '%'  ";

        return $sql;
    }

    function BusquedaCuentaAbono($ls){
        $sql = "SELECT ( select NOM_CLI from [BD_CREDIMUJER].[dbo].[MAE_CLI] where NUM_DOC COLLATE SQL_Latin1_General_CP1_CI_As = CUENT_ABONO_SOCIA.NRODNI  and IND_ENVIO_STAR = 'S')  as Socia,NROCUENTA,Entidadbancaria, ACTIVO, FECHACREACION from CUENT_ABONO_SOCIA WHERE NRODNI = '{$ls['a1']}'  ";

        return $sql;
    }

    function UltimasCuentasRegistradas(){
        $sql = "SELECT top 10( select NOM_CLI from [BD_CREDIMUJER].[dbo].[MAE_CLI] where NUM_DOC COLLATE SQL_Latin1_General_CP1_CI_As = CUENT_ABONO_SOCIA.NRODNI) as Socia,NROCUENTA,Entidadbancaria, ACTIVO, FECHACREACION from CUENT_ABONO_SOCIA order by NroCuentaid desc ";

        return $sql;
    }

    function _editarCuentaAbono($ls){
        $sql = " UPDATE CUENT_ABONO_SOCIA set ACTIVO = '{$ls['a3']}'  where NROCUENTA = '{$ls['a2']}' ";

        return $sql;
    }

    function _EliminarCuentaAbono($ls){
        $sql = " DELETE from CUENT_ABONO_SOCIA where NROCUENTA = '{$ls['a2']}' and ACTIVO = '{$ls['a3']}' and NRODNI = '{$ls['a1']}'  ";

        return $sql;
    }

    function _Report_EnviosBCP_($ls){
        $sql = " SELECT REGION, DESASOCIACION  , PRODUCTO , CODSOCIA , APELLIDOSNOMBRES , NRODNI , NROCTAAHORROSOCIA ,
                 MTODESEMBOLSADO , MTOADICIONAL , FECHAPROCESO, FECHADESEMBOLSO, TIPOCOBRO 
                from TENVIOBCP where cargatabla = 'S' and CODREGION like  '%'+'{$ls['a1']}' and fechadesembolso >= '{$ls['a2']}' and fechadesembolso <= '{$ls['a3']}' ";

        return $sql;
    }

    function _Report_NroCuentasRegistradas_($ls){
        $sql = "SELECT ( select NOM_CLI from [BD_CREDIMUJER].[dbo].[MAE_CLI] where NUM_DOC  COLLATE SQL_Latin1_General_CP1_CI_As = CUENT_ABONO_SOCIA.NRODNI) as Socia , NROCUENTA , Entidadbancaria , ACTIVO, FECHACREACION
            from CUENT_ABONO_SOCIA
            where ( select top 1 COD_SUCURSAL from [BD_CREDIMUJER].[dbo].[MAE_CLI] where NUM_DOC  COLLATE SQL_Latin1_General_CP1_CI_As = CUENT_ABONO_SOCIA.NRODNI) = '{$ls['a1']}' and FECHACREACION >= '{$ls['a2']}' and FECHACREACION <= '{$ls['a3']}'  ";
        return $sql;
    }

    function _Report_EnviosCajaTrujillo_($ls){
        $sql = "SELECT REGION,DESASOCIACION,APELLIDOSNOMBRES,NRODNI,CTA_AHORRO,MTOADICIONAL,FECHADESEMBOLSO,FECHAPROCESOCMT,TIPOCOBRO from(SELECT REGION,DESASOCIACION,APELLIDOSNOMBRES,NRODNI,CTA_AHORRO,MTOADICIONAL,FECHADESEMBOLSO,FECHAPROCESOCMT,TIPOCOBRO from tenviocmt_final where FECHADESEMBOLSO >= '{$ls['a1']}' and FECHADESEMBOLSO <= '{$ls['a2']}' and REGION like  '%'+'{$ls['a3']}' union all  SELECT REGION,'','','','Total del dia :',SUM(MTOADICIONAL),FECHADESEMBOLSO,FECHAPROCESOCMT,''  from tenviocmt_final where FECHADESEMBOLSO >= '{$ls['a1']}' and FECHADESEMBOLSO <= '{$ls['a2']}' and REGION like  '%'+'{$ls['a3']}' group by FECHAPROCESOCMT,FECHADESEMBOLSO,REGION) as v
            order by REGION asc,FECHAPROCESOCMT desc ,FECHADESEMBOLSO desc,DESASOCIACION desc ";
        return $sql;
    }

    function _Report_EnviosCajaPiura_($ls){
        $sql = "SELECT REGION,DESASOCIACION,APELLIDOSNOMBRES,NRODNI,CTA_AHORRO,MTOADICIONAL,FECHADESEMBOLSO,FECHAPROCESOCMP,TIPOCOBRO from(SELECT REGION,DESASOCIACION,APELLIDOSNOMBRES,NRODNI,CTA_AHORRO,MTOADICIONAL,FECHADESEMBOLSO,FECHAPROCESOCMP,TIPOCOBRO from tenviocmp_final where FECHADESEMBOLSO >= '{$ls['a1']}' and FECHADESEMBOLSO <= '{$ls['a2']}' and REGION like  '%'+'{$ls['a3']}' union all  SELECT REGION,'','','','Total del dia :',SUM(MTOADICIONAL),FECHADESEMBOLSO,FECHAPROCESOCMP,''  from tenviocmp_final where FECHADESEMBOLSO >= '{$ls['a1']}' and FECHADESEMBOLSO <= '{$ls['a2']}' and REGION like  '%'+'{$ls['a3']}' group by FECHAPROCESOCMP,FECHADESEMBOLSO,REGION) as v
            order by REGION asc,FECHAPROCESOCMP desc ,FECHADESEMBOLSO desc,DESASOCIACION desc ";
        return $sql;
    }

    function _Busqueda_banco_comunal_($ls){
        $sql = "SELECT CODASOCIACION,DESASOCIACION from V_ASOCIACIONCOMUNAL where  BANCOBAJA = 'N' and DESASOCIACION like '%'+'{$ls['a1']}'+'%' and CODSUCURSAL_ASOC like '%'+'{$ls['a2']}'+'%' ";         
        return $sql;
    }

    function _Busqueda_banco_comunal_nomsucursal($ls){
        $sql = "SELECT CODASOCIACION,DESASOCIACION from V_ASOCIACIONCOMUNAL where  BANCOBAJA = 'N' and DESASOCIACION like '%'+'{$ls['a1']}'+'%' and CODSUCURSAL_ASOC = (select CODSUCURSAL_REG from SFD_AGENCIAS where NOMSUCURSAL like  '%'+'{$ls['a2']}'+'%' ) ";         
        return $sql;
    }

    function _Busqueda_Solicitud_banco_comunal_($ls){
        $sql = "SELECT count(*) from SOL_CUADRODIARIO where 
        --FECHAPEDIDO = '{$ls['b1']}' and 
        CODASOCIACION = '{$ls['b2']}'  and TIPOPRESTAMO = '{$ls['b3']}' and FECHAPEDIDO >=  format(DATEADD(mm,DATEDIFF(mm,0,GETDATE()),0),'dd-MM-yyyy') and FECHAPEDIDO <= format(DATEADD(ms,-3,DATEADD(mm,0,DATEADD(mm,DATEDIFF(mm,0,GETDATE())+1,0))),'dd-MM-yyyy') ";         
        return $sql;
    }

    function _insert_Solicitud_banco_comunal_($ls){
        $sql = "execute SP_SOL_INSERTABANCO @CodRegion = '{$ls['a1']}' , @CodAsoc = '{$ls['a2']}' , @FechaReg = '{$ls['a3']}' 
        , @TipoDes = '{$ls['a4']}' , @Situ = '{$ls['a5']}' ";         
        return $sql;
    }

    function _Reporte_solicitudes_($ls){
        $sql = "SELECT * FROM (
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
                WHERE ( SOL_CUADRODIARIO.CODREGION like '%'+'{$ls['a1']}') AND  
                      ( SOL_CUADRODIARIO.FECHAPEDIDO >= '{$ls['a2']}') AND  
                      ( SOL_CUADRODIARIO.FECHAPEDIDO <= '{$ls['a3']}') 
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
                WHERE ( SOL_CUADRODIARIO.CODREGION like '%'+'{$ls['a1']}') AND  
                      ( SOL_CUADRODIARIO.FECHAPEDIDO >= '{$ls['a2']}') AND  
                      ( SOL_CUADRODIARIO.FECHAPEDIDO <= '{$ls['a3']}') group by CODREGION,NOMBREREGION) as c order by   NOMBREREGION asc,TIPOASOCIACION asc";         
        return $sql;
    }

  function _Reporte_solicitudes_resumen($ls){
        $sql = "SELECT SOL_CUADRODIARIO.NOMBREREGION, 
                sum(SOL_CUADRODIARIO.BANCONACION) as BANCONACION,   
                sum(SOL_CUADRODIARIO.BANCOCREDITO) as BANCOCREDITO,
                sum(isnull(SOL_CUADRODIARIO.BIM,'0')) as BIM,
                sum(isnull(SOL_CUADRODIARIO.CAJAPIURA,'0')) as CAJAPIURA,
                sum(isnull(SOL_CUADRODIARIO.CAJATRUJILLO,'0')) as CAJATRUJILLO, 
                sum(isnull(SOL_CUADRODIARIO.Coop_SanMartin,'0')) as Coop_SanMartin, 
                sum(SOL_CUADRODIARIO.EFECTIVO) as Efectivo 
                FROM SOL_CUADRODIARIO  
                WHERE ( SOL_CUADRODIARIO.CODREGION like '%'+'{$ls['a1']}') AND  
                ( SOL_CUADRODIARIO.FECHAPEDIDO >= '{$ls['a2']}') AND  
                ( SOL_CUADRODIARIO.FECHAPEDIDO <= '{$ls['a3']}' ) group by  NOMBREREGION";         
        return $sql;
    }

    function _Solicitudes_Dia($ls){
        $sql = "SELECT 
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
                where FECHAPEDIDO = '{$ls['a1']}' and CODREGION in ( select CODREGION from sec_users_sucursal where Login = '{$ls['a2']}')
                ";         
        return $sql;
    }

    function _Update_Solicitud_banco_comunal_($ls){
        $sql = "SET NOCOUNT ON; exec USP_SOL_UPDATE '{$ls['a2']}','{$ls['a12']}','{$ls['a4']}','{$ls['a5']}','{$ls['a6']}','{$ls['a7']}','{$ls['a8']}','{$ls['a9']}','{$ls['a10']}','{$ls['a11']}','{$ls['a13']}','{$ls['a14']}','{$ls['a15']}','{$ls['a1']}','{$ls['a3']}' ";         
        return $sql;
    }

    function _delete_Solicitud_banco_comunal_($ls){
        $sql = "DELETE from SOL_CUADRODIARIO where REG = '{$ls['a1']}' and NOMBREREGION = '{$ls['a2']}' and FECHAPEDIDO = '{$ls['a3']}' ";         
        return $sql;
    }

    function Revertir_proceso_BCP($ls){
        $sql = "SET NOCOUNT ON;EXEC RevertirEnvioBCP  @FECHA_BCP = '{$ls['a1']}' , @codregion = '{$ls['a2']}' ";         
        return $sql;
    }

    function Restriccion_solicitudes($ls){
        $sql = "SELECT count(*) from SOL_FECHASACTIVAS where format(FECHAPEDIDO,'dd-MM-yyyy') = '{$ls['a1']}' and ACTIVO = 'NO' ";         
        return $sql;
    }

    function Editar_Restriccion_solicitudes($ls){
        $sql = " UPDATE SOL_FECHASACTIVAS set ACTIVO = '{$ls['a2']}' where format(FECHAPEDIDO,'dd-MM-yyyy') = '{$ls['a1']}' ";         
        return $sql;
    }

    function SOL_CUADRODIARIO_EJECUTADO_VS_SOLICITADO($ls){
        $sql = "SET NOCOUNT ON;EXEC SOL_REP_VERSUS_PROG_EJEC_Y_VIC  @FECHAINI = '{$ls['a1']}' , @FECHAFIN = '{$ls['a2']}', @CODREGION = '{$ls['a3']}', @MESPER = '{$ls['a4']}', @ANOPER = '{$ls['a5']}' ";         
        return $sql;
    }

    function SOL_CUADRODIARIO_EJECUTADO_VS_SOLICITADO_CONTA($ls){
        $sql = "SET NOCOUNT ON;EXEC SOL_REP_VERSUS_PROG_EJEC_Y_VIC_CONTA  @FECHAINI = '{$ls['a1']}' , @FECHAFIN = '{$ls['a2']}', @FECHAINI_DSB = '{$ls['a3']}', @FECHAFIN_DSB = '{$ls['a4']}', @CODREGION = '{$ls['a5']}' ";         
        return $sql;
    }

    function _Ope_EditaSocia_NoCobrado($ls){
        $sql = " UPDATE tcresocia02 set FLAGCOBRANZA = 'F' where FECHAPROCEBN = '{$ls['a1']}' and NRODNI = '{$ls['a2']}'  ";         
        return $sql;
    }

    function Revertir_Socia_Anulado($ls){
        $sql = "SET NOCOUNT ON;EXEC RevertirAnulados  @dFECHAPROCEBN = '{$ls['a1']}' , @vNRODNI = '{$ls['a2']}' , @vCODREGION = '{$ls['a3']}' ";         
        return $sql;
    }

    function Revertir_Socia_Insertada($ls){
        $sql = "SET NOCOUNT ON;EXEC RevertirInsertado  @dFECHAPROCEBN = '{$ls['a1']}' , @dFECHACREDITO = '{$ls['a2']}' , @vCODSOCIA = '{$ls['a3']}' , @vNRODNI = '{$ls['a4']}' ";         
        return $sql;
    }

    function _Busqueda_Socia_Asistencia_taller($ls){
        $sql = " SELECT a.CODSOCIA,(a.APELLIDOSNOMBRES+' - '+b.DESASOCIACION) as socia  from ASISTENCIAS_TEMAS_DET a left join ASISTENCIA_TEMAS_CAB b on a.CODPROMEN_CAB = b.CODPROMEN_CAB  where a.APELLIDOSNOMBRES like '%'+'{$ls['a1']}'+'%' and a.mes = '{$ls['a2']}' and a.ano = '{$ls['a3']}' ";         
        return $sql;
    }

    function _Listar_Socia_Asistencia_taller($ls){
        $sql = "SELECT a.CODSOCIA,b.DESASOCIACION,a.APELLIDOSNOMBRES, a.ASISTEN_TAT,a.ASISTEN_TCCA from ASISTENCIAS_TEMAS_DET a left join ASISTENCIA_TEMAS_CAB b on a.CODPROMEN_CAB = b.CODPROMEN_CAB where a.CODSOCIA = '{$ls['a1']}' and a.mes = '{$ls['a2']}' and a.ano = '{$ls['a3']}' ";         
        return $sql;
    }

    function _Registro_socia_Asistencia($ls){
        $sql = "UPDATE ASISTENCIAS_TEMAS_DET set ASISTEN_TAT = '{$ls['a4']}' , ASISTEN_TCCA = '{$ls['a5']}' where ano = '{$ls['a3']}' and mes = '{$ls['a2']}' and CODSOCIA = '{$ls['a1']}'";
        return $sql;
    }

    function _Reporte_Educativo_Actividades($ls){
        $sql = "SELECT a.ano as ano,a.MES as mes, a.CODSUCURSAL_REG as codsucursal_reg, a.CODASOCIACION as codasociacion, a.DESASOCIACION as desasociacion, b.CODSOCIA as codsocia, b.APELLIDOSNOMBRES as apellidosnombres,a.TEMAEJECUTADO, isnull(b.Actividad,'-') as codigo, isnull(b.Reto,'-') as Reto, isnull(b.ASISTEN_TAT,'-') as AsistenciaTAT, isnull(b.ASISTEN_TCCA,'-') as AsistenciaTCCA from ASISTENCIA_TEMAS_CAB a inner join ASISTENCIAS_TEMAS_DET b on a.CODPROMEN_CAB = b.CODPROMEN_CAB  where a.ano like '%'+'{$ls['a1']}'+'%' and a.MES like '%'+'{$ls['a2']}'+'%'";
        return $sql;
    }

    function Eliminar_DJ_BANCO_NACION($ls){
    $sql = "SET NOCOUNT ON;EXEC eliminardj @DNI = '{$ls['a1']}' ,@APELLIDOSNOMBRES = '{$ls['a2']}' ,@TIPOCREDITO = '{$ls['a3']}' ,@MTODESEMBOLSO = '{$ls['a4']}' ,@usuario = '{$ls['a5']}'";
        return $sql;
    }

    function Revertir_Eliminar_DJ_BANCO_NACION($ls){
        $sql = "SET NOCOUNT ON;EXEC RevertirELiminarDJ @DNI = '{$ls['a1']}' ,@APELLIDOSNOMBRES = '{$ls['a2']}' ,@TIPOCREDITO = '{$ls['a3']}' ,@MTODESEMBOLSO = '{$ls['a4']}' ";
            return $sql;
    }

    function _DJ_BANCO_NACION($ls){
    $sql = " UPDATE TCRESOCIA01 set  mtoaprobado = '{$ls['a4']}'  where NRODNI = '{$ls['a1']}' and APELLIDOSNOMBRES like '%'+'{$ls['a2']}' and TIPODESEMBOLSO = '{$ls['a3']}' and format(FECHAPROCEBN,'dd-MM-yyyy') = format(getdate(),'dd-MM-yyyy')  ";
        return $sql;
    }

    function _Busqueda_OP_BancoComunal($ls){
        $sql = "SELECT CODASOCIACION,DESASOCIACION from SFD_ASOCIACIONCOMUNAL where BANCOBAJA = 'N' and CODSUCURSAL_ASOC = '{$ls['a1']}' and CODASOC_SUP = ' ' and DESASOCIACION like '%'+'{$ls['a2']}'+'%' ";
        return $sql;
    }

    function _Busqueda_OP_BancoComunal_anillo($ls){
        $sql = "SELECT CODASOCIACION,DESASOCIACION from SFD_ASOCIACIONCOMUNAL where CODASOC_SUP = '{$ls['a1']}' and DESASOCIACION like '%'+'{$ls['a2']}'+'%'  ";
        return $sql;
    }

    function _Busqueda_OP_Saldo_Promotora($ls){
        $sql = "SET NOCOUNT ON; exec OBTENERNROCUENTA_ORDENPAGOS @CODREGION = '{$ls['a1']}' , @CODASOCIACION = '{$ls['a2']}' ";
        return $sql;
    }

    function _Listar_Ordenes_pagos($ls){
        $sql = "SELECT * from Orden_Pagos 
        where FECHA_CREACION = format(getdate(),'dd-MM-yyyy') 
        and CODSUCURSAL in ( select CODREGION from sec_users_sucursal where Login = '{$ls['a1']}' )  ";         
        return $sql;
    }
    
    function _Busqueda_banco_comunal_socia($ls){
        $sql = "select CODSOCIA,APELLIDOSNOMBRES from SFD_RELACION_ASOC_SOCIO where CODASOCIACION = '{$ls['a2']}' and INDBAJA = 'N' and APELLIDOSNOMBRES like '%'+'{$ls['a1']}'+'%' ";
        return $sql;
    }

    function _Insertar_Orden_Pagos($ls){
        $sql ="SET NOCOUNT ON; exec InsertOrdenPagos @CODREGION = '{$ls['a1']}', @Nomsucursal = '{$ls['a2']}' , @codasociacion = '{$ls['a3']}' , @desasociacion = '{$ls['a4']}' , @Codanillo = '{$ls['a5']}' , @DesAnillo = '{$ls['a6']}' , @Fechaproceso = '{$ls['a7']}' ";
        return $sql;
    }

    function _Busqueda_Cuenta_Abono($ls){
        $sql ="SELECT NROCUENTA,(NROCUENTA+' - '+Entidadbancaria) as Descripcion from CUENT_ABONO_SOCIA where Entidadbancaria = '{$ls['a1']}' and NRODNI COLLATE SQL_Latin1_General_CP1_CI_As = (select NRODNI from SFD_SOCIACOMPLETA where CODSOCIA = '{$ls['a2']}') and ACTIVO = 'Y'";
        return $sql;
    }

    function Enlistar_Cuenta_Abono(){
        $sql ="SELECT top 10 b.APELLIDOSNOMBRES as Socia,a.NROCUENTA,a.Entidadbancaria,a.ACTIVO,a.FECHACREACION from CUENT_ABONO_SOCIA a  left join SFD_SOCIACOMPLETA b on a.NRODNI COLLATE SQL_Latin1_General_CP1_CI_As = b.NRODNI where b.ESTADOBAJA = 'N' and a.ACTIVO = 'Y'";
        return $sql;
    }

    function _modifica_socia_orden_pagos($ls){
        $sql = "SET NOCOUNT ON;exec Modifica_Orden_pagos @item = '{$ls['a1']}' , @region = '{$ls['a2']}', @TipoOperacion = '{$ls['a3']}', @TipoCredito = '{$ls['a4']}', @CodSocia = '{$ls['a5']}', @Socia = '{$ls['a6']}', @EntidadBancaria = '{$ls['a7']}', @ImporteTotal = '{$ls['a8']}', @NroCuenta = '{$ls['a9']}', @Celular = '{$ls['a10']}', @CODBANCO = '{$ls['a11']}' ";         
        return $sql;
    }

    function _eliminar_orden_pago($ls){
        $sql = "DELETE from Orden_Pagos where FECHA_CREACION = format(getdate(),'dd-MM-yyyy') and NroRegistro = '{$ls['a1']}'  and CODSUCURSAL like '%'+'{$ls['a2']}'  ";
        return $sql;
    }

    function _Listar_Orden_Pagos_reporte($ls){
        $sql = " SELECT NOMSUCURSAL,CODASOCIACION,DESASOCIACION,CODASOCIACION_anillo,DESASOCIACION_anillo,FECHA_CREACION,FECHA_OPERACION,TIPO_OPERACION,TIPOCREDITO,NOMSOCIA,ImporteTotal,ENTIDADBANCARIA,NROCUENTA,NROCELULAR from (
            select NOMSUCURSAL,CODASOCIACION,DESASOCIACION,CODASOCIACION_anillo,DESASOCIACION_anillo,CONVERT(varchar(24), FECHA_CREACION,5) as FECHA_CREACION ,CONVERT(varchar(24), FECHA_OPERACION,5) as FECHA_OPERACION,TIPO_OPERACION,TIPOCREDITO,NOMSOCIA,ImporteTotal,ENTIDADBANCARIA,NROCUENTA,NROCELULAR 
            from Orden_Pagos where CODSUCURSAL like '%'+'{$ls['a1']}' and  FECHA_OPERACION >= '{$ls['a2']}' and FECHA_OPERACION <= '{$ls['a3']}' and TIPO_OPERACION like '%'+'{$ls['a4']}'
            union all
            select NOMSUCURSAL,'','','','','Total:','','','','',SUM(ImporteTotal) as ImporteTotal,'','','' 
            from Orden_Pagos where CODSUCURSAL like '%'+'{$ls['a1']}' and  FECHA_OPERACION >= '{$ls['a2']}' and FECHA_OPERACION <= '{$ls['a3']}' and TIPO_OPERACION like '%'+'{$ls['a4']}' group by NOMSUCURSAL 
            ) as u order by NOMSUCURSAL desc, FECHA_CREACION asc ";
        return $sql;
    }

    function Editar_Restriccion_OrdenPago($ls){
        $sql = " UPDATE ORD_FECHASACTIVAS set ACTIVO = '{$ls['a2']}' where format(FECHAPEDIDO,'dd-MM-yyyy') = '{$ls['a1']}' ";         
        return $sql;
    }

    function Restriccion_OrdenPago($ls){
        $sql = "SELECT count(*) from ORD_FECHASACTIVAS where format(FECHAPEDIDO,'dd-MM-yyyy') = '{$ls['a1']}' and ACTIVO = 'NO' ";         
        return $sql;
    }


    function Dateformat($v){
       $spl = explode("-", $v);
        if ( count($spl) == 3){
            $year = $spl[0];
            $month =$spl[1] ;
            $day = $spl[2];
           return "{$day}-{$month}-{$year}";
            }
        return $v;
    }
    function DateMonth($v){
       $spl = explode("-", $v);
        if ( count($spl) == 2){            
            $month =$spl[1];            
           return "{$month}";
            }
        return $v;
    }

    function DateYear($v){
       $spl = explode("-", $v);
        if ( count($spl) == 2){
            $year = $spl[0];            
           return "{$year}";
            }
        return $v;
    }
    function DateTXT($v){
       $spl = explode("-", $v);
        if ( count($spl) == 3){
            $year = $spl[0];
            $month =$spl[1] ;
            $day = $spl[2];
           return "{$year}{$month}{$day}";
            }
        return $v;
    }

}

?>