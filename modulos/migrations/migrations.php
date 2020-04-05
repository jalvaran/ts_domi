<?php
/**
 * Pagina que será la portada del centro comercial
 * 2020-04-02, Julian Alvaran Techno Soluciones SAS
 *  
 */

$myPage="migrations.php";  // identifica la pagina para poder controlar el acceso
$myTitulo="Domi Buga";  //Titulo en la pestaña del navegador
//include_once("../../sesiones/php_control_usuarios.php"); //Controla los permisos de los usuarios
include_once("../../modelo/php_conexion.php"); //clase que permite la conexion con la base de datos
include_once("../../constructores/paginas_constructor.php"); //Construye la pagina, estan las herramientas para construir los objetos de la pagina

$css =  new PageConstruct($myTitulo); //instancia para el objeto con las funciones del html

$obCon = new conexion(1); //instancia para Conexion a la base de datos

if(!isset($_REQUEST["p"])){
    exit("no se envió la contraseña");
}
$Contrasena=$_REQUEST["p"];
if($Contrasena<>"domipirlo1985"){
    exit("Contraseña incorrecta");
}
$css->PageInit($myTitulo);
    
    $css->divCol("", "", "12", "", "");

    $css->div("", "col-md-2", "", "", "", "", "");
   
        $css->h3("", "", "", "");
                print("<strong>Migraciones</strong>");
        $css->Ch3();
    $css->Cdiv(); 
           
    $css->div("", "col-md-3", "", "", "", "", "");
        
        print("<strong>Ejecutar:</strong><br>");
        print('<button id="BtnSubir" onclick="ConfirmarMigracion();" class="mdc-button mdc-button--raised filled-button--secondary mdc-ripple-upgraded" style="--mdc-ripple-fg-size:65px; --mdc-ripple-fg-scale:1.9291179361344377; --mdc-ripple-fg-translate-start:9.5px, -20.5px; --mdc-ripple-fg-translate-end:22.316665649414062px, -14.5px;">
                      Iniciar
                    </button>');
        $css->Cdiv();
    print("<br><br><br><br><br><br><br>");
    $css->div("DivProgress", "col-md-3", "", "", "", "", "");    
        $css->ProgressBar("PgProgresoUp", "LyProgresoUP", "", 0, 0, 100, 0, "0%", "", "");
    $css->Cdiv();
    $css->div("DivMensajes", "col-md-3", "", "", "", "", "");    
   
    
    $css->Cdiv();
    
    $css->div("DivProcess", "col-md-3", "", "", "", "", "");  
    
    
    $css->Cdiv();
    $css->Cdiv();
$css->PageEnd();

print('<script src="jsPages/migrations.js"></script>');  //script propio de la pagina

$css->Cbody();
$css->Chtml();

?>