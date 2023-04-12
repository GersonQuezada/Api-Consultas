<?php
    namespace EasyProjects\SimpleRouter;

    class Response{
        public function status($status){
            if(is_int($status)){

            }else{
                intval($status);
            }

            http_response_code($status);

            return $this;
        }

        public function send($object){
            header('content-type: application/json; charset=utf-8');
            header('Access-Control-Allow-Origin: *'); 
            echo json_encode($object);
            exit();
        }
    }
