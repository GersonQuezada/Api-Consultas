<?php
require_once CLASS_PATH."config/conexion.php"; 
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
date_default_timezone_set('America/Lima'); 
    class auth 
    extends conexion
    {
        private $tableToken = "seg_Usuarios_Token" ; 

        public function login($json){      
            $result = [];       
            $dato = json_decode($json,true);                       
            if(!isset($dato['email']) || !isset($dato["pswd"])){
                $result = [
                    "status" => 401,
                    "message" => "Campos vacios.",
                    "data" => ""
                ];
                return $result; 
            }else{
                //todo esta bien 
                $usuario = $dato['email'];
                $password = $dato['pswd'];
                // $password = $password;
                $datos = $this->obtenerDatosUsuario($usuario);
                if($datos){                    
                    //verificar si la contraseña es igual
                        if(password_verify($password,$datos[0]['Password']) ){
                                if($datos[0]['Estado'] == "1"){
                                    //crear el token
                                    $verificar  = $this->insertarToken($datos[0]['UsuarioID']);                                                                   
                                    if($verificar['status'] == 200){                                           
                                        $result = [
                                            "status" => 200,
                                            "token" => $verificar['Token'],
                                            "NombreUsuario" => $datos[0]['NombreCompleto'],
                                            "id_Usuario" => $datos[0]['UsuarioID'],
                                            "usuario" => $datos[0]['Usuario'],
                                            "Areas" =>  $datos[0]['CargoUsuario'],
                                            "id_Areas"=> $datos[0]['ID_Grupo']
                                            
                                        ];
                                        // session_regenerate_id(true);
                                        $name = $datos[0]['NombreCompleto'];
                                        $user_ID = $datos[0]['UsuarioID'];
                                        $user = $datos[0]['Usuario'];
                                        $grupo = $datos[0]['CargoUsuario'];
                                        $grupo_ID = $datos[0]['ID_Grupo'];                                        
                                        // $token = (string) $verificar;
                                        //* Se prefiere usar SESION PHP que Cookies
                                        // setcookie('contador',$verificar , time() + 365 * 24 * 60 * 60 , '/', NULL, 0); 
                                        $_SESSION["s_usuario"] = $name;
                                        $_SESSION["User_ID"] = $user_ID;
                                        $_SESSION["User_Log"] = $user;
                                        $_SESSION["grupo"] = $grupo_ID;
                                        $_SESSION["Cargo"] = $grupo;
                                       	$_SESSION["Token"]	= $verificar['Token'];
                                        $_SESSION["Version_cod"] = '01'; 
                                        return $result;
                                    }else{

                                        $result = [
                                            "status" => 500,
                                            "message" => "Error interno, No hemos podido guardar.",
                                            "data" => ""
                                        ];
                                        return $result;
                                    }
                                }else{
                                    $result = [
                                        "status" => 401,
                                        "message" => "El usuario esta inactivo.",
                                        "data" => ""
                                    ];
                                    return $result;                                     
                                }                                
                        }else{
                            //la contraseña no es igual
                            $result = [
                                "status" => 401,
                                "message" => "El password es invalido.",
                                "data" => ""
                            ];
                            return $result;                         
                        }                        
                }else{
                    //no existe el usuario
                    $result = [
                        "status" => 401,
                        "message" => "El usuaro $usuario  no existe.",
                        "data" => ""
                    ];
                    return $result;                    
                }
                // return $datos;
            }
        }

        public function logout($json){

            $data = json_decode($json,true);
            if(!isset($data['User_ID']) || !isset($data["Token"])){
                $result = [
                    "status" => 401,
                    "message" => "Campos vacios debe enviar el ID y el Token.",
                    "data" => ""
                ];
                return $result; 
            }else{
                $Usuarioid =  $data["User_ID"];
                $Token =  $data["Token"];
                $_NewDateExpire = date("d-m-Y H:i:s",time());   
                $modif = $this->ModificaEstadoUserToken($Usuarioid,$Token,'0',$_NewDateExpire,$_NewDateExpire);
                $result = [
                    "status" => 200,
                    "message" => "Session cerrada",
                    "data" => ""
                ];
                return $result;  
            }


        }

        public function ObtenerRestriccionesSistemas($Json,$token){
            $_auth = new auth;  
            $EstadoToken = $_auth->VerificaRefreshToken($token); 
            if($EstadoToken["status"] == 200){
                $DatosQuery = $this->MuestraRestriccionModulosSistemas($Json); 
                $this ->result  = [ 'status' => 200,'message' => 'Request successful','data' => $DatosQuery];
                return $this->result;  
            }else{                    
                http_response_code(401);
                return $this->result;  
            }                                                      
        } 

        public function ObtenerRestriccionesSistemasClave($Json,$token){
            $_auth = new auth;  
            $EstadoToken = $_auth->VerificaRefreshToken($token); 
            if($EstadoToken["status"] == 200){
                $DatosQuery = $this->MuestraRestriccionModulosSistemasCLave($Json); 
                $this ->result  = [ 'status' => 200,'message' => 'Request successful','data' => $DatosQuery];
                return $this->result;  
            }else{                    
                http_response_code(401);
                return $this->result;  
            }                                                      
        } 


        private function obtenerDatosUsuario($User){
            $query = "SELECT SUBSTRING(su.VC_name , 1, 21)+'.' as NombreCompleto,(su.VC_pswd) as 'Password',su.BT_active as Estado,su.IN_ID as UsuarioID, su.VC_EMAIL as Usuario,
            scd.VC_Descripcion as CargoUsuario,scd.VC_codigo  as ID_Grupo
            from seg_Usuarios su inner join seg_Usuario_Grupo sug on su.IN_ID = sug.IN_ID_USUARIO  inner JOIN seg_Catalogo_DET scd on sug.IN_group_id = scd.IN_id 
            where su.VC_EMAIL  = '$User'";
            $datos = !empty(parent::obtenerDatos($query)) ? parent::obtenerDatos($query) : 0 ;
            return $datos; 
        }
       
        Private function MuestraRestriccionModulosSistemas($BodyJson){ 
            $usuario = $BodyJson['Usuario_Id'];
            $modulo = $BodyJson['Modulo_Id'];
            $accion = $BodyJson['Accion_Id'];
            // Falta completar el procedure      
            $query = "SELECT IN_id_Usuario as ID_Usuario,
                    (SELECT VC_name  from seg_Usuarios su where su.IN_id = IN_id_Usuario) as VC_Usuario,
                    IN_id_Modulo_Sistema as ID_Modulo,
                    (select vc_descripcion from seg_Catalogo_DET scd where scd.IN_id = IN_id_Modulo_Sistema) as Modulo,
                    IN_id_Acciones as ID_Accion,
                    (select vc_descripcion from seg_Catalogo_DET scd where scd.IN_id = IN_id_Acciones) as Modulo,
                    BT_ESTADO as Estado
                    from seg_Usuarios_Restriccion_Modulos where IN_id_Usuario = '$usuario' and IN_id_Modulo_Sistema = '$modulo' 
                    and IN_id_Acciones = '$accion' ";                 
            $datos = parent::obtenerDatos($query);
            return $datos;
        }

        Private function MuestraRestriccionModulosSistemasCLave($BodyJson){           
            $modulo = $BodyJson['Modulo_Id']; 
            // Falta completar el procedure      
            $query = "SELECT *
                    from seg_Usuarios_Restriccion_Modulos_Claves where IN_id_Modulo_Sistema = '$modulo' ";                 
            $datos = parent::obtenerDatos($query);
            return $datos;
        }
 

        private function insertarToken($usuarioid){
            $result = [];
            $token = $this->generaJWT_token($usuarioid);
            // $_SESION["Token"] =  $token;
            // $token = "123123";
            $iat = time();
            $exp = $iat + (60*15)  ;        
            $dateCrea = date("d-m-Y H:i:s", $iat);
            $dateExpira = date("d-m-Y H:i:s", $exp);
            $estado = "1";
            $query = "EXEC USP_INSERT_TOKEN_USUARIO '$usuarioid','$token','$estado','$dateCrea','$dateExpira' ";
            $verifica = parent::obtenerDatos($query);
            if(isset($verifica[0]['ErrorMessage'])){                
                $result=  ['status' => 400,
                        'Token' => false ];                
            }   
            $result=  ['status' => 200,
                        'Token' => $token ];
            return $result;
        }

        private function generaJWT_token($Usuario){        
            $iat = time();
            $exp = $iat  + (60*15) ;        
            $payload = array(
                'InicioToken' => $iat, /* Tiempo creato Token */
                'ExpiraToken' =>  $exp,  /* expira en 15 horas */
                'SitioWeb' => 'SistemasCredimujer',            
                'sub' => $Usuario
            );
            $jwt = JWT::encode($payload,JWT_SECRET_KEY,'HS512');
            return $jwt;
        }

        private function ModificaEstadoUserToken($Usuario,$token,$estado,$fechaVencimiento,$fechaCaducidad = null,$tokenRefresh = null ){
            if(empty($fechaCaducidad)){
                $fechaCaducidad = date("d-m-Y H:i:s",time() + (60*60*1));
            }
            $query = "UPDATE " .$this->tableToken." set VC_Token_Refresh = '$tokenRefresh' ,DT_Fecha_Vencimiento = '$fechaVencimiento', BT_Estado = '$estado', DT_Fecha_Caducidad = '$fechaCaducidad'  where VC_Token = '$token' and IN_id_usuario = '$Usuario'";
             
            if( parent::nonQuery($query) == 1 ){
                return true;
            }else{
                return false;
            } 
        }

        //Verifica la fecha de venciamiento del token si es menor refresca token nuevo
        public function VerificaRefreshToken($token){    
            $query = "SELECT IN_id_usuario,VC_Token,VC_Token_Refresh,BT_Estado,format(DT_Fecha_Creado,'dd-MM-yyyy HH:mm:ss') as DT_Fecha_Creado,format(DT_Fecha_Vencimiento,'dd-MM-yyyy HH:mm:ss') as DT_Fecha_Vencimiento,format(DT_Fecha_Caducidad,'dd-MM-yyyy HH:mm:ss') as DT_Fecha_Caducidad from seg_Usuarios_Token where VC_Token = '$token'";
            $datos = $this->obtenerDatos($query);
            
            // return $datos;
            if($datos[0]['DT_Fecha_Vencimiento'] <= date("d-m-Y H:i:s",time())){
                $ModificaTokenCaducado = $this->ModificaEstadoUserToken($datos[0]['IN_id_usuario'],$datos[0]['VC_Token'],'0',$datos[0]['DT_Fecha_Vencimiento'],$datos[0]['DT_Fecha_Vencimiento']);
                $result = [
                    'status' => 400,
                    'Status Token' => 'Token vencido'
                ];
                if($ModificaTokenCaducado = true){  
                    return $result;
                }                
            }else{    
                $_NewDateExpire = date("d-m-Y H:i:s",time() + (60*60*1));                
                $_TokenRefresh = $this->generaJWT_token($datos[0]['VC_Token']);
                $ModificaTokenCaducado = $this->ModificaEstadoUserToken($datos[0]['IN_id_usuario'],$datos[0]['VC_Token'],'1',$_NewDateExpire,null,$_TokenRefresh);
                $result = [
                    'status' => 200,
                    'Status Token' => 'Token Renovado'
                ];
                if($ModificaTokenCaducado = true){
                    header('Content-Type: application/json');
                    http_response_code(200);
                    return $result;
                }  
            } 
 

        }
  

        
    }

?>