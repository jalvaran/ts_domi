<?php
/**
 * Pagina que será la portada del centro comercial
 * 2020-04-02, Julian Alvaran Techno Soluciones SAS
 *  
 */

$myPage="portada.php";  // identifica la pagina para poder controlar el acceso
$myTitulo="Domi Buga";  //Titulo en la pestaña del navegador
//include_once("../../sesiones/php_control_usuarios.php"); //Controla los permisos de los usuarios
include_once("../../modelo/php_conexion.php"); //clase que permite la conexion con la base de datos
include_once("../../constructores/paginas_constructor.php"); //Construye la pagina, estan las herramientas para construir los objetos de la pagina

$css =  new PageConstruct($myTitulo); //instancia para el objeto con las funciones del html

$obCon = new conexion(1); //instancia para Conexion a la base de datos

$css->PageInit($myTitulo);
    /*
     * Inicio de la maqueta propia de cada programador
     */
    
$css->PageEnd();

//print('<script src="jsPages/tesoreria_pagos.js"></script>');  //script propio de la pagina

$css->Cbody();
$css->Chtml();

?>