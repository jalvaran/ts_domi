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
            $sql="SELECT CantidadItems,Total FROM pedidos WHERE ID='$pedido_id'";
            $DatosPedido=$obCon->FetchAssoc($obCon->Query($sql));
            $Items=$DatosPedido["CantidadItems"];
            $Total=$DatosPedido["Total"];
            print("OK;Producto Agregado;$Items;$Total");
            
        break;//Fin caso 1
        
    }
          
}else{
    print("No se enviaron parametros");
}
?>