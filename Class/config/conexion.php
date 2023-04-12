<?php
 
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
define('JWT_SECRET_KEY', 'System_Credimujer'); 

class conexion{
    private $server;
    private $user;
    private $password;
    private $database;
    private $conexion;
    function __construct(){
        $listadatos = $this->datosConexion();
        $direccion = dirname(__FILE__);
        $jsondata = file_get_contents($direccion."/"."config");
        // var_dump($jsondata);
        $json = json_decode($jsondata, true);
        foreach ($json as $key => $value) {
            $this->server = $value['server'];
            $this->user = $value['user'];
            $this->password = $value['password'];
            $this->database = $value['database'];
        }
        try {
            $this->conexion = new PDO("sqlsrv:Server=".$this->server.";Database=".$this->database,$this->user,$this->password);
            //$this->conexion->setAttribute(PDO::ATTR_PERSISTENT ,PDO::ATTR_ERRMODE );
             
        } catch (PDOException $exception) {
            print $exception->getMessage();
        }
        // print_r($this->conexion);
        // 
    }
    private function datosConexion(){
        $direccion = dirname(__FILE__);
        $jsondata = file_get_contents($direccion."/"."config");
        return json_decode($jsondata, true);        
    }

 

    public function obtenerDatos($sqlstr){
        $results = $this->conexion->query($sqlstr);
        $statement = $results->fetchAll(PDO::FETCH_ASSOC);  
        return  $statement;

    }

    public function errorPDO($Statement){
        $ErrorArray = implode(',', $Statement->errorInfo());
        $ErrorView  = end((explode(',', $ErrorArray)));
        return @$ErrorView;
    }

    public function nonQuery($sqlstr){
        $results = $this->conexion->query($sqlstr);
        $statement = $results->rowCount();
        return $statement;        
    }

    public function nonQueryId($sqlstr){
        $results = $this->conexion->query($sqlstr);
        $filas = $results->rowCount();
         if($filas >= 1){
            return $this->conexion->lastInsertId();
         }else{
             return 0;
         }
    }
// ENCRIPTAR DATOS // 

 
     
 /* TODO LO RELACIONADO AL TOKEN JWT */
    // Decifra token
    public function DecodToken($token){
        try {
            $decoded = JWT::decode($token, new Key(JWT_SECRET_KEY, 'HS512'));
            $JsonDecoded = json_decode(json_encode($decoded), true);
            $resul = [
                "status" => 200,
                "Data" => $JsonDecoded
            ];
            return ($resul);
        } catch  (Exception $e){
            $resul = [
                "status" => 400,
                "Data" => "",
                "Message" => "Error al decodificar token"
            ];
            return $resul; 
        }

    }

/// FECHAS QUE SE USARAN EN EL SISTEMA

    public function Dateformat($v){
        $spl = explode("-", $v);
         if ( count($spl) == 3){
             $year = $spl[0];
             $month =$spl[1] ;
             $day = $spl[2];
            return "{$day}-{$month}-{$year}";
             }
         return $v;
     }
    public function DateMonth($v){
        $spl = explode("-", $v);
         if ( count($spl) == 2){            
             $month =$spl[1];            
            return "{$month}";
             }
         return $v;
     }
 
    public function DateYear($v){
        $spl = explode("-", $v);
         if ( count($spl) == 2){
             $year = $spl[0];            
            return "{$year}";
             }
         return $v;
     }
    public function DateTXT($v){
        $spl = explode("-", $v);
         if ( count($spl) == 3){
             $year = $spl[0];
             $month =$spl[1] ;
             $day = $spl[2];
            return "{$year}{$month}{$day}";
             }
         return $v;
    }

    public $result = [
        'status' => 401,
        'message' => 'El Token vencido, vuelva a iniciar sesion.',
        'data' => array()
    ];

}
?>