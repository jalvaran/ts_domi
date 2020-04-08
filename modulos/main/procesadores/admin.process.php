<?php
session_start();
include_once("../clases/admin.class.php");

if( !empty($_REQUEST["Accion"]) ){
    
    $obCon=new Admin(1);
    
    switch ($_REQUEST["Accion"]) {
        
        case 1: //Validar inicio de sesion y setearla
            $user_domi=$obCon->normalizar($_REQUEST["user_domi"]);
            $pw_domi=$obCon->normalizar($_REQUEST["pw_domi"]);
            $sql="SELECT ID,Nombre FROM locales WHERE Email LIKE '$user_domi' AND Password='$pw_domi'";
            $DatosValidacion=$obCon->FetchAssoc($obCon->Query($sql));
            if($DatosValidacion["ID"]==''){
                exit("E1;Usuario o Contraseña incorrectos");
            }else{
                $_SESSION['idLocal'] = $DatosValidacion["ID"];
                $_SESSION['Token'] = $_REQUEST["Token_user"];
                exit("OK;Bienvenid@ ".$DatosValidacion["Nombre"]);
                
            }
        break;//Fin caso 1
        
        case 2://Destruir sesion
            session_destroy();
            print("OK;Sesion terminada");
        break;//Fin caso 2   
        
        case 3://Cambiar pedido de estado
            $Estado=$obCon->normalizar($_REQUEST["Estado"]);
            $idPedido=$obCon->normalizar($_REQUEST["idPedido"]);
            if($idPedido==''){
                exit("E1;No se recibió el id del pedido");
            }
            if($Estado==''){
                exit("E1;Seleccione una opción");
            }
            $sql="UPDATE pedidos SET Estado='$Estado' WHERE ID='$idPedido'";
            $obCon->Query($sql);
            $DatosEstados=$obCon->DevuelveValores("pedidos_estados", "ID", $Estado);
            print("OK;El estado del pedido fué actualizado;".$DatosEstados["EstadoPedido"]);
        break;//Fin caso 4    
    
        
        
    }
          
}else{
    print("No se enviaron parametros");
}
?>