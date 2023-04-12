<?php 
require($_SERVER['DOCUMENT_ROOT'].'/API_CONSULTAS/vendor/autoload.php');
$openapi = \OpenApi\Generator::scan([$_SERVER['DOCUMENT_ROOT'].'/API_CONSULTAS/Controllers']);
header('Content-Type: application/json');
echo $openapi->toJson();