<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER['REQUEST_METHOD'];
if($method == "OPTIONS") {
    die();
}

        /**  CHECK VALUES  **/
if(strlen($_POST['nombre'])>75){
    exit("Favor de ingresar un nombre de maximo 75 caracteres");
}

if(preg_match('/[A-Za-z]/', $_POST['telefono'])){
    exit("Formato de telefono no válido");
}

if(!str_contains($_POST['email'], "@")){
    echo $_POST['email'];
    exit("Favor de ingresar un correo válido");
}

        /**  SAVE DATA TO DB  **/
$connect = mysqli_connect("localhost", "root", "1234", "estela");
$sql = "CALL contactosweb_insert ('{$_POST["nombre"]}', '{$_POST["telefono"]}', '{$_POST["email"]}', {$_POST["newsletter"]})";
$result = $connect->query($sql);
    
if($result){
    $toReturn = array("text"=>"Datos guardados");

        /**  WEB SERVICE  **/
    $random = rand(0, 10000);
    $url = 'https://www.dataaccess.com/webservicesserver/numberconversion.wso?WSDL';
    $client = new SoapClient($url);
    $data = array("dNum"=>$random);
    $result = $client->NumberToDollars($data);
    
    $webServResult = $result->NumberToDollarsResult;
    array_push($toReturn, $webServResult);
    print_r(json_encode($toReturn));
} else {
    echo "Error al guardar datos";
}

?>