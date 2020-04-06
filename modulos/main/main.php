<?php
/**
 * Pagina que será la portada del centro comercial
 * 2020-04-02, Julian Alvaran Techno Soluciones SAS
 *  
 */

$myPage="main.php";  // identifica la pagina para poder controlar el acceso
$myTitulo="Domi Buga";  //Titulo en la pestaña del navegador
//include_once("../../sesiones/php_control_usuarios.php"); //Controla los permisos de los usuarios
include_once("../../modelo/php_conexion.php"); //clase que permite la conexion con la base de datos
include_once("../../constructores/paginas_constructor.php"); //Construye la pagina, estan las herramientas para construir los objetos de la pagina

$css =  new PageConstruct($myTitulo); //instancia para el objeto con las funciones del html

$obCon = new conexion(1); //instancia para Conexion a la base de datos

$css->ShoppingCar("onclick=VerCarrito();");
//$css->modal("modalMain", "DOMI", "DivModal");
//$css->modalMDD("modalMain", "DOMI", "DivModal");

$css->PageInit($myTitulo);
    
$css->PageEnd();

print('<script src="jsPages/main.js"></script>');  //script propio de la pagina

$css->Cbody();
$css->Chtml();

?>