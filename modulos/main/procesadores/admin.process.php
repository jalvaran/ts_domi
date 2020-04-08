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
        
        case 4://Guardar o editar clasificacion
            $idItem=$obCon->normalizar($_REQUEST["idItem"]);
            $Datos["Estado"]=$obCon->normalizar($_REQUEST["Estado"]);
            $Datos["Clasificacion"]=$obCon->normalizar($_REQUEST["Clasificacion"]);
            foreach ($Datos as $key => $value) {
                if($value==""){
                    exit("E1;El campo $key no puede estar vacío;$key");
                }
            }
            $Token=$obCon->normalizar($_REQUEST["Token_user"]);
            $DatosSesion=$obCon->VerificaSesion($Token);
            if($DatosSesion["Estado"]=="E1"){               
                exit($DatosSesion["Estado"].";".$DatosSesion["Mensaje"]);
            }
            $idLocal=$_SESSION["idLocal"];
            $DatosLocal=$obCon->DevuelveValores("locales", "ID", $idLocal);
            $Tabla="inventarios_clasificacion";
            if($idItem==''){
                $sql=$obCon->getSQLInsert($Tabla, $Datos);
            }else{
                $sql=$obCon->getSQLUpdate($Tabla, $Datos);
                $sql.=" WHERE ID='$idItem'";
            }
            $obCon->QueryExterno($sql, HOST, USER, PW, $DatosLocal["db"], "");
            
            print("OK;Registro Guardado");
        break;//Fin caso 4
        
        case 5://Guardar o editar producto
            $idItem=$obCon->normalizar($_REQUEST["idItem"]);
            $Datos["Estado"]=$obCon->normalizar($_REQUEST["Estado"]);
            $Datos["idClasificacion"]=$obCon->normalizar($_REQUEST["idClasificacion"]);
            $Datos["Referencia"]=$obCon->normalizar($_REQUEST["Referencia"]);
            $Datos["Nombre"]=$obCon->normalizar($_REQUEST["Nombre"]);
            $Datos["PrecioVenta"]=$obCon->normalizar($_REQUEST["PrecioVenta"]);
            $Datos["DescripcionCorta"]=$obCon->normalizar($_REQUEST["DescripcionCorta"]);
            $Datos["DescripcionLarga"]=$obCon->normalizar($_REQUEST["DescripcionLarga"]);
            $Datos["Orden"]=$obCon->normalizar($_REQUEST["Orden"]);
            foreach ($Datos as $key => $value) {
                if($value=="" AND $key<>'Orden'){
                    exit("E1;El campo $key no puede estar vacío;$key");
                }
            }
            if(!is_numeric($Datos["Orden"]) or $Datos["Orden"]<0){
                exit("E1;El campo Orden Debe ser un numero mayor o igual a cero;Orden");
            }
            if(!is_numeric($Datos["PrecioVenta"]) or $Datos["PrecioVenta"]<0){
                exit("E1;El campo Orden Debe ser un numero mayor o igual a cero;PrecioVenta");
            }
            $Token=$obCon->normalizar($_REQUEST["Token_user"]);
            $DatosSesion=$obCon->VerificaSesion($Token);
            if($DatosSesion["Estado"]=="E1"){               
                exit($DatosSesion["Estado"].";".$DatosSesion["Mensaje"]);
            }
            
            if($idItem==''){
                if(empty($_FILES['ImagenProducto']['name'])){

                    exit("E1;Debe Adjuntar una Imagen para el Producto;ImagenProducto");
                }else{
                    $info = new SplFileInfo($_FILES['ImagenProducto']['name']);
                    $Extension=($info->getExtension());  
                    if($Extension<>'jpg' and $Extension<>'png' and $Extension<>'jpeg'){
                        exit("E1;Solo se permiten imagenes;ImagenProducto");
                    }
                } 
            }
            
            $idLocal=$_SESSION["idLocal"];
            $DatosLocal=$obCon->DevuelveValores("locales", "ID", $idLocal);
            $Tabla="productos_servicios";
            if($idItem==''){
                $Datos["ID"]=$obCon->getUniqId();
                $idProducto=$Datos["ID"];
                $Datos["Created"]=date("Y-m-d H:i:s");
                $sql=$obCon->getSQLInsert($Tabla, $Datos);
            }else{
                $sql=$obCon->getSQLUpdate($Tabla, $Datos);
                $sql.=" WHERE ID='$idItem'";
                $idProducto=$idItem;
            }
            $obCon->QueryExterno($sql, HOST, USER, PW, $DatosLocal["db"], "");
            
            
            $Extension="";
            if(!empty($_FILES['ImagenProducto']['name'])){
                
                $info = new SplFileInfo($_FILES['ImagenProducto']['name']);
                $Extension=($info->getExtension()); 
                if($Extension<>'jpg' and $Extension<>'png' and $Extension<>'jpeg'){
                    exit("E1;Solo se permiten imagenes;ImagenProducto");
                }
                $Tamano=filesize($_FILES['ImagenProducto']['tmp_name']);
                $DatosConfiguracion=$obCon->DevuelveValores("configuracion_general", "ID", 2001);
                
                $carpeta=$DatosConfiguracion["Valor"];
                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0777);
                }
                $carpeta=$DatosConfiguracion["Valor"].$idLocal."/";
                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0777);
                }
                $carpeta=$DatosConfiguracion["Valor"].$idLocal."/".$idProducto."/";
                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0777);
                }
                
                opendir($carpeta);
                $idAdjunto=uniqid(true);
                $destino=$carpeta.$idAdjunto.".".$Extension;
                
                
                if($idItem<>''){
                    $sql="SELECT ID,Ruta FROM productos_servicios_imagenes WHERE idProducto='$idItem' LIMIT 1";
                    $Consulta=$obCon->QueryExterno($sql, HOST, USER, PW, $DatosLocal["db"], "");
                    $DatosValidacion=$obCon->FetchAssoc($Consulta);
                    $idImagen=$DatosValidacion["ID"];
                    if (file_exists($DatosValidacion["Ruta"])) {
                        unlink($DatosValidacion["Ruta"]);
                    }
                    $sql="DELETE FROM productos_servicios_imagenes WHERE ID='$idImagen'";
                    $obCon->QueryExterno($sql, HOST, USER, PW, $DatosLocal["db"], "");
                }
                move_uploaded_file($_FILES['ImagenProducto']['tmp_name'],$destino);
                $obCon->RegistreImagenProducto($DatosLocal["db"],$idItem, $destino, $Tamano, $_FILES['ImagenProducto']['name'], $Extension, 1);
            }
            
            print("OK;Registro Guardado");
        break;//Fin caso 5
    
        
        
    }
          
}else{
    print("No se enviaron parametros");
}
?>