<?php   
    $params = session_get_cookie_params();
    $params["lifetime"] = 3600; // tiempo de vida de la sesión en segundos (1 hora)
    $params["path"] = "/";
    // $params["domain"] = "consultas.credimujer.com"; // reemplaza ejemplo.com con tu dominio
    $params["secure"] = true; // solo permitir cookies seguras HTTPS
    $params["httponly"] = true; // solo permitir acceso por HTTP
    session_set_cookie_params($params);
    session_start();
    
 
    require_once __DIR__."/vendor/autoload.php";
    // require_once "vendor/autoload.php";
    require_once __DIR__."/paths.php";
    
    require_once  CONTROLLER_PATH."AuthenticationController.php";
    require_once  CONTROLLER_PATH."CuentasSociasController.php"; 
    require_once  CONTROLLER_PATH."ListaCatalogoController.php"; 
    require_once  CONTROLLER_PATH."ProcesosFinancierosController.php"; 

    use EasyProjects\SimpleRouter\Router as Router;
    use EasyProjects\SimpleRouter\Request as Request;
    use EasyProjects\SimpleRouter\Response as Response;   
    
    $router = new Router();

    $router->get('/get/{id}', function(Request $req, Response $res){
        $res->status(200)->send( $req->params);
    });    

    // //! SESIONES Y USUARIOS
 
    $router->post('/Authentication/Login', function(Request $req, Response $res){ 
        $_log = new AuthenticationController;
        $_response = $_log->Login();
        // setcookie('Cookie', '132', true);
        $res->status($_response["status"])->send($_response);
    });

    $router->post('/Authentication/Logout', function(Request $req, Response $res){
        $_log = new AuthenticationController;
        $_response = $_log->logout();
        $res->status($_response["status"])->send($_response);
    });

    // $router->post('/Authentication/StatusSession', function(Request $req, Response $res){
    //     $headers = apache_request_headers();  
    //     $_log = new AuthenticationController;
    //     isset($headers['Authorization']) ? $_response = $_log->StatusSession($headers['Authorization']) : $res->status(401)->send("Token no Ingresado");       
    //     $res->status($_response["status"])->send($_response);
    // });

    $router->post('/Authentication/RestriccionModulo', function(Request $req, Response $res){ 
        $headers = apache_request_headers();  
        $_Class = new AuthenticationController;
        isset($headers['Authorization']) ? $_response = $_Class->RestriccionModulo($headers['Authorization']) : $res->status(401)->send("Token no Ingresado");
        $res->status($_response["status"])->send($_response);
        // $res->status(200)->send($headers);
    });

    $router->post('/Authentication/RestriccionModuloClave', function(Request $req, Response $res){
        $headers = apache_request_headers();  
        $_Class = new AuthenticationController;
        isset($headers['Authorization']) ? $_response = $_Class->RestriccionModuloClave($headers['Authorization']) : $res->status(401)->send("Token no Ingresado");
        $res->status($_response["status"])->send($_response);
    });

    // //! Lista Catalogo

    $router->get('/ListaCatalogo/ObtenerListaDetalle/{id_cab}', function(Request $req, Response $res){         
        $headers = apache_request_headers();        
        $_Class = new EnListarCatalogo; 
        isset($headers['Authorization']) ? $_response = $_Class->ListaCatalodoDetalle($req->params,$headers['Authorization']) : $res->status(401)->send("Token no Ingresado");
        $res->status($_response["status"])->send($_response);
        // $res->status(200)->send( $req->params);
    });
 


    //! Proceso de Cuenta de abono de las Socias.

    $router->get('/CuentasSocias/ObtenerCuentasSociasDNI/{usuario}/{dni}/', function(Request $req, Response $res){
        $headers = apache_request_headers();        
        $_Class = new CuentasSociasController; 
        isset($headers['Authorization']) ? $_response = $_Class->ObternerCuentasSociasDNI   ($req->params,$headers['Authorization']) : $res->status(401)->send("Token no Ingresado");
        $res->status($_response["status"])->send($_response);        
    });

    $router->get('/CuentasSocias/ObtenerCuentasSocias/{usuario}', function(Request $req, Response $res){
        $headers = apache_request_headers();        
        $_Class = new CuentasSociasController; 
        isset($headers['Authorization']) ? $_response = $_Class->ObternerCuentasSocias($req->params,$headers['Authorization']) : $res->status(401)->send("Token no Ingresado");
        $res->status($_response["status"])->send($_response);
    });

    $router->post('/CuentasSocias/RegistrarCuentaSocias',function(Request $req, Response $res){
        $headers = apache_request_headers();
        $_Class = new CuentasSociasController;
        isset($headers['Authorization']) ? $_response = $_Class->RegistrarCuentaSocia($headers['Authorization']) : $res->status(401)->send("Token no Ingresado");
        $res->status($_response["status"])->send($_response);        
    });

    $router->put('/CuentasSocias/ModificarCuentaSocias',function(Request $req, Response $res){
        $headers = apache_request_headers();
        $_Class = new CuentasSociasController;
        isset($headers['Authorization']) ? $_response = $_Class->ModificarCuentaSocia($headers['Authorization']) : $res->status(401)->send("Token no Ingresado");
        $res->status($_response["status"])->send($_response);        
    });

    $router->post('/CuentasSocias/EliminarCuentaSocias',function(Request $req, Response $res){
        $headers = apache_request_headers();
        $_Class = new CuentasSociasController;
        isset($headers['Authorization']) ? $_response = $_Class->EliminarCuentaSocia($headers['Authorization']) : $res->status(401)->send("Token no Ingresado");
        $res->status($_response["status"])->send($_response);        
    });
    

    //! Proceso de BCP.

    $router->get('/ProcesosFinancieros/ChequeGerenciaBCP/{fechaproceso}/{region}/{user}',function(Request $req, Response $res){
        $headers = apache_request_headers();        
        $_Class = new ProcesosFinancieros;
        isset($headers['Authorization'])? $_response = $_Class->ProcesoBCP_ChequeGenerancia($req->params,$headers['Authorization']) : $res->status(401)->send("Token no Ingresado");
        $res->status($_response["status"])->send($_response);
    });

    $router->post('/ProcesosFinancieros/ModificaSociaPlantillaBCP',function(Request $req, Response $res){
        $headers = apache_request_headers();        
        $_Class = new ProcesosFinancieros;
        isset($headers['Authorization'])? $_response = $_Class->EditaSociaPlantillaBCP($headers['Authorization']) : $res->status(401)->send("Token no Ingresado");
        $res->status($_response["status"])->send($_response);
    });

    $router->delete('/ProcesosFinancieros/EliminaSociaPlantillaBCP',function(Request $req, Response $res){
        $headers = apache_request_headers();        
        $_Class = new ProcesosFinancieros;
        isset($headers['Authorization'])? $_response = $_Class->EliminarSociaPlantillaBCP($headers['Authorization']) : $res->status(401)->send("Token no Ingresado");
        $res->status($_response["status"])->send($_response);
    });

    $router->post('/ProcesosFinancieros/GeneraPlantillaTXT_BCP',function(Request $req, Response $res){
        $headers = apache_request_headers();        
        $_Class = new ProcesosFinancieros;
        isset($headers['Authorization'])? $_response = $_Class->GeneraArchivoBCP_txt($headers['Authorization']) : $res->status(401)->send("Token no Ingresado");
        $res->status($_response["status"])->send($_response);
    });    

    $router->post('/ProcesosFinancieros/RevertirProcesoBCP',function(Request $req, Response $res){
        $headers = apache_request_headers();        
        $_Class = new ProcesosFinancieros;
        isset($headers['Authorization'])? $_response = $_Class->RevertirProcesoBCP($headers['Authorization']) : $res->status(401)->send("Token no Ingresado");
        $res->status($_response["status"])->send($_response);
    });    


    $router->start();