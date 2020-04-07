<?php

include_once("../clases/main.class.php");

if( !empty($_REQUEST["Accion"]) ){
    
    $obCon=new Domi(1);
    
    switch ($_REQUEST["Accion"]) {
        
        case 1: //Agregar Item a un pedido
            
            $user_id=$obCon->normalizar($_REQUEST["user_id"]);
            $local_id=$obCon->normalizar($_REQUEST["local_id"]);
            $product_id=$obCon->normalizar($_REQUEST["product_id"]);
            
            $Observaciones=$obCon->normalizar($_REQUEST["Observaciones"]);
            $Cantidad=1;
            if($user_id==''){
                exit("E1;No se recibió el id del usuario");
            }
            if($local_id==''){
                exit("E1;No se recibió el id del local");
            }
            if($product_id==''){
                exit("E1;No se recibió el id del producto");
            }
            $DatosLocal=$obCon->DevuelveValores("locales", "ID", $local_id);
            $local_db=$DatosLocal["db"];     
            
            $obCon->CrearUsuarioCliente($user_id, "", "", "");//Creo el cliente usuario si no existe            
            $pedido_id=$obCon->CrearPedido($user_id, $local_id, 0, "", 1); //Creo el pedido si no existe y si existe devuelvo el id
            
            //Verifico el valor unitario del producto
           
            $sql="SELECT PrecioVenta FROM productos_servicios WHERE ID='$product_id';";
            $Consulta= $obCon->Query2($sql, HOST, USER, PW, $local_db, ""); 
            $DatosProducto= $obCon->FetchAssoc($Consulta);
            
            $ValorUnitario=$DatosProducto["PrecioVenta"];
            
            //agrego o edito el item al pedido
            $obCon->AgregarItemAPedido($local_db, $pedido_id, $product_id, $Cantidad, $ValorUnitario, $Observaciones);
            
            //Actualizo la cantidad de items y el total en el pedido general
            $sql="UPDATE pedidos SET CantidadItems=CantidadItems+'$Cantidad', Total=Total+$ValorUnitario 
                         WHERE ID='$pedido_id'";
            $obCon->Query($sql);
            //obtengo la cantidad de items y el total del pedido
            $sql="SELECT SUM(CantidadItems) AS CantidadItems,SUM(Total) AS Total FROM pedidos WHERE cliente_id='$user_id' AND Estado=1";
            $DatosPedido=$obCon->FetchAssoc($obCon->Query($sql));
            $Items=$DatosPedido["CantidadItems"];
            $Total=$DatosPedido["Total"];
            $NumberTotal= number_format($DatosPedido["Total"]);
            print("OK;Producto Agregado;$Items;$Total;$NumberTotal");
            
        break;//Fin caso 1
        
        case 2://Obtenga la cantidad de items en pedidos en curso por un usuario
            $user_id=$obCon->normalizar($_REQUEST["user_id"]);
            if($user_id==''){
                exit("E1;No se recibió el id del usuario");
            }
            $sql="SELECT SUM(CantidadItems) AS CantidadItems,SUM(Total) AS Total FROM pedidos WHERE cliente_id='$user_id' AND Estado=1";
            $DatosPedido=$obCon->FetchAssoc($obCon->Query($sql));
            $Items=$DatosPedido["CantidadItems"];
            $Total=$DatosPedido["Total"];
            $NumberTotal= number_format($DatosPedido["Total"]);
            print("OK;$Items;$Total;$NumberTotal");
        break;//fin caso 2    
        
        case 3://Editar un campo de una tabla
            $Tab=$obCon->normalizar($_REQUEST["Tab"]);
            $idLocalEdit=$obCon->normalizar($_REQUEST["idLocalEdit"]);
            $Field=$obCon->normalizar($_REQUEST["Field"]);
            $idEdit=$obCon->normalizar($_REQUEST["idEdit"]);
            $FieldValue=$obCon->normalizar($_REQUEST["FieldValue"]);
            
            if($Tab==''){
                exit("E1;No se recibió la tabla");
            }
            if($idLocalEdit==''){
                exit("E1;No se recibió el local");
            }
            if($Field==''){
                exit("E1;No se recibió el campo");
            }
            if($idEdit==''){
                exit("E1;No se recibió el id");
            }
            
            if($Tab==1){
                
                $dbLocal=$obCon->getDataBaseLocal($idLocalEdit);                
                $sql="UPDATE pedidos_items SET $Field='$FieldValue', Total=Cantidad*ValorUnitario 
                        WHERE ID='$idEdit'";
                $obCon->Query2($sql, HOST, USER, PW, $dbLocal, "");
                if($Field=="Cantidad"){
                    $sql="SELECT pedido_id FROM pedidos_items 
                        WHERE ID='$idEdit'";
                    $DatosPedido=$obCon->FetchAssoc($obCon->Query2($sql, HOST, USER, PW, $dbLocal, ""));
                    $obCon->ActualizarValoresPedido($idLocalEdit, $DatosPedido["pedido_id"]);
                }
                
                
            }
            
            print("OK;Registro Actualizado");
        break;//Fin caso 3    
        
        case 4://Eliminar item
            
            $idLocalEdit=$obCon->normalizar($_REQUEST["idLocalEdit"]);            
            $idItem=$obCon->normalizar($_REQUEST["idItem"]);
            
            if($idLocalEdit==''){
                exit("E1;No se recibió el local");
            }
            
            if($idItem==''){
                exit("E1;No se recibió el id");
            }
            
            
                
            $dbLocal=$obCon->getDataBaseLocal($idLocalEdit);                
            
            $sql="SELECT pedido_id FROM pedidos_items 
                WHERE ID='$idItem'";
            $DatosPedido=$obCon->FetchAssoc($obCon->Query2($sql, HOST, USER, PW, $dbLocal, ""));
            
            $sql="DELETE FROM pedidos_items 
                WHERE ID='$idItem'";
            $obCon->Query2($sql, HOST, USER, PW, $dbLocal, "");
            
            $obCon->ActualizarValoresPedido($idLocalEdit, $DatosPedido["pedido_id"]);
          
            
            print("OK;Item Eliminado");
        break;//Fin caso 4
        
        case 5://Solicitar pedido
            $idUserClient=$obCon->normalizar($_REQUEST["idUserClient"]);  
            $NombreCliente=$obCon->normalizar($_REQUEST["NombreCliente"]);  
            $DireccionCliente=$obCon->normalizar($_REQUEST["DireccionCliente"]);  
            $Telefono=$obCon->normalizar($_REQUEST["Telefono"]); 
            $ObservacionesPedido=$obCon->normalizar($_REQUEST["ObservacionesPedido"]); 
            
            if($idUserClient==""){
                exit("E1;No se recibió el id del cliente");
            }
            if($NombreCliente==""){
                exit("E1;Debes escribir tu Nombre;NombreCliente");
            }
            if($DireccionCliente==""){
                exit("E1;Debes escribir una dirección para poder enviarte el pedido;DireccionCliente");
            }
            if($Telefono==""){
                exit("E1;Debes escribir un Número Telefónico;Telefono");
            }
            
            $obCon->ActualiceDatosCliente($idUserClient, $NombreCliente, $DireccionCliente, $Telefono);
            
            $sql="UPDATE pedidos SET Estado=2,Observaciones='$ObservacionesPedido' WHERE cliente_id='$idUserClient' AND Estado=1";
            $obCon->Query($sql);
            
            print("OK;Tu Pedido ha sido Solicitado");
        break;//Fin caso 5   
        
        case 6://Descartar pedido
            $idUserClient=$obCon->normalizar($_REQUEST["idUserClient"]);  
            
            if($idUserClient==""){
                exit("E1;No se recibió el id del cliente");
            }
            
            $sql="UPDATE pedidos SET Estado=20 WHERE cliente_id='$idUserClient' AND Estado=1";
            $obCon->Query($sql);
            
            print("OK;Tu Pedido fué descartado");
        break;//Fin caso 6
        
    }
          
}else{
    print("No se enviaron parametros");
}
?>