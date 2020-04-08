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
    
    public function CrearUsuarioCliente($user_id,$Nombre,$Direccion,$Telefono) {
        $Validacion= $this->DevuelveValores("client_user", "ID", $user_id);
        if($Validacion['ID']<>''){
            return;
        }
        $tab="client_user";
        
        $Datos["ID"]=$user_id;	
        $Datos["Nombre"]=$Nombre;	
        $Datos["Direccion"]=$Direccion;           
        $Datos["Telefono"]=$Telefono;		
        $Datos["Created"]=date("Y-m-d H:i:s");	
        $sql=$this->getSQLInsert($tab, $Datos);
        $this->Query($sql);
    }
    
    
    /**
     * Fin Clase
     */
}
