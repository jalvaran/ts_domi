<?php 
include_once 'modelo/php_conexion.php';
$obCon=new conexion(1);
$Domain=$_SERVER['HTTP_HOST'];
$urlRequest=$obCon->normalizar($_SERVER['REQUEST_URI']);
$urlRequest= explode("/", $urlRequest);
$urlLocal=$urlRequest["2"];
print($Domain." URL:".$urlLocal);

$sql="SELECT ID FROM locales WHERE UrlCorta like '$urlLocal'";
//Consulta
//header("location: modulos/main/main.php");


$redirect = $_SERVER['REQUEST_URI']; // You can also use $_SERVER['REDIRECT_URL'];


switch ($redirect) {

    case '/'  :

    case ''   :

        header("location: modulos/main/main.php");

        break;


    case '/contact' :

        print("Contatos");

        break;

    default:

        header("location: modulos/main/main.php");

        break;

}


?>