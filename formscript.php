<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER['REQUEST_METHOD'];
if($method == "OPTIONS") {
    die();
}

$connect = mysqli_connect("localhost", "root", "528639", "estela");
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