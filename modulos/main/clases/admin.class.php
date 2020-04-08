<?php
if(file_exists("../../../modelo/php_conexion.php")){
    include_once("../../../modelo/php_conexion.php");
}
class Admin extends conexion{
    
    public function VerificaSesion($Token_user) {
        if(isset($_SESSION["idLocal"])){
            if($_SESSION["Token"]==$Token_user){
                $DatosSesion["Estado"]="OK";
                $DatosSesion["Mensaje"]="Sesion iniciada correctamente";
            }else{
                $DatosSesion["Estado"]="E1";
                $DatosSesion["Mensaje"]="El token ha cambiado, debe iniciar sesion de nuevo";
            }
            
        }else{
            $DatosSesion["Estado"]="E1";
            $DatosSesion["Mensaje"]="No se ha iniciado sesion";
        }
        return($DatosSesion);
    }
        
    public function RegistreImagenProducto($DataBase,$idProducto,$destino,$Tamano, $NombreArchivo, $Extension, $idUser) {
        
        $tab="productos_servicios_imagenes";
        
        $Datos["idProducto"]=$idProducto;
        
        $Datos["Ruta"]=$destino;    
        $Datos["NombreArchivo"]=$NombreArchivo;    
        $Datos["Extension"]=$Extension;    
        $Datos["Tamano"]=$Tamano; 
        $Datos["idUser"]=$idUser;		
        $Datos["Created"]=date("Y-m-d H:i:s");	
        $sql=$this->getSQLInsert($tab, $Datos);
        $this->QueryExterno($sql, HOST, USER, PW, $DataBase, "");
    }
    
    
    /**
     * Fin Clase
     */
}
