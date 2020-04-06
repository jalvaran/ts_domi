<?php

include_once("../clases/main.class.php");// se debe incluir la clase del modulo 
include_once("../../../constructores/paginas_constructor.php");// siempre debera de ir ya que utilizara html que esta en el constructor

if(!empty($_REQUEST["Accion"]) ){// se verifica si el indice accion es diferente a vacio 
    
    $css =  new PageConstruct("", "", 1, "", 1, 0);// se instancia para poder utilizar el html
    $obCon = new Domi(1);// se instancia para poder conectarse con la base de datos 
    
    switch($_REQUEST["Accion"]) {
       
        case 1://Listar las categorias
            $sql="SELECT * FROM catalogo_categorias WHERE Estado=1 ORDER BY Orden ASC";
            $Consulta=$obCon->Query($sql);
            while($DatosCategorias=$obCon->FetchAssoc($Consulta)){
                $idItem=$DatosCategorias["ID"];
                $js="onclick=ListarLocales(`$idItem`)";
                $css->divCard(utf8_encode($DatosCategorias["Nombre"]), utf8_encode($DatosCategorias["Descripcion"]), "", $DatosCategorias["Icono"], $DatosCategorias["ColorIcono"],$js,"style=cursor:pointer");       

            }
        break;//Fin caso 1    
        case 2://dibuja el listado de los locales
            $idCategoria=$obCon->normalizar($_REQUEST["Categoria"]);
            $sql="SELECT * FROM locales WHERE idCategoria='$idCategoria' AND Estado=1 ORDER BY Orden ASC";
            $Consulta=$obCon->Query($sql);
            while($DatosCategorias=$obCon->FetchAssoc($Consulta)){
                $idItem=$DatosCategorias["ID"];
                $js="onclick=DibujaLocal(`$idItem`)";
                $Fondo="../../images/image.webp";
                $DatosFondo=$obCon->DevuelveValores("locales_imagenes", "idLocal", $idItem);
                if($DatosFondo["ID"]<>''){
                    $Fondo=$DatosFondo["Ruta"];
                }
                $css->divCardLocales($Fondo,utf8_encode($DatosCategorias["Nombre"]), utf8_encode($DatosCategorias["Descripcion"]), utf8_encode($DatosCategorias["Telefono"]."<br>".$DatosCategorias["Direccion"]), $DatosCategorias["Icono"], $DatosCategorias["ColorIcono"],$js,"style=cursor:pointer");       

            }
            
        break;//fin caso 2
        
        case 3://dibuja la informacion general del local
            
            $idLocal=$obCon->normalizar($_REQUEST["idLocal"]);
            $DatosLocal=$obCon->DevuelveValores("locales", "ID", $idLocal);
            $js="onclick=DibujaLocal(`$idLocal`)";
            $Fondo="../../images/image.webp";
            $DatosFondo=$obCon->DevuelveValores("locales_imagenes", "idLocal", $idLocal);
            if($DatosFondo["ID"]<>''){
                $Fondo=$DatosFondo["Ruta"];
            }
            $dbLocal=$DatosLocal["db"];
            $sql="SELECT * FROM inventarios_clasificacion WHERE Estado=1";
            $Consulta=$obCon->Query2($sql, HOST, USER, PW, $dbLocal, "");
            $i=1;
            $values["values"][0]="";       $values["text"][0]="";  $values["sel"][0]=1;  
            while ($DatosConsulta = $obCon->FetchAssoc($Consulta)) {                
                $values["values"][$i]=$DatosConsulta["ID"];       $values["text"][$i]=$DatosConsulta["Clasificacion"];
                $i=$i+1;
            }
            $css->divCardLocales($Fondo,utf8_encode($DatosLocal["Nombre"]), utf8_encode($DatosLocal["Descripcion"]), utf8_encode($DatosLocal["Telefono"]."<br>".$DatosLocal["Direccion"]), $DatosLocal["Icono"], $DatosLocal["ColorIcono"],$js,"style=cursor:pointer",12);       
            
            $style="style='width:130%;'";
             
            $htmlSelect=$css->getHtmlSelect("cmbClasificacion", "cmbClasificacion", $values, "Clasificacion", $js, $style);
            $Title="Clasificacion";
            $css->divForm($Title, $htmlSelect);
            
            
            
            $html=$css->getHtmlInput("text","BusquedaProducto", "BusquedaProducto", "", "Buscar",'',$style,"search",1);
            $css->divForm("Busqueda", $html, "", "", 6);
            print('<div id="DivProductos" class="mdc-layout-grid__cell--span-12">');
            
            $css->Cdiv();
        break;//fin caso 3
        
        case 4://lista los productos
            $idLocal=$obCon->normalizar($_REQUEST["idLocal"]);
            if($idLocal==''){
                exit("No se recibió un local");
            }
            $DatosLocal=$obCon->DevuelveValores("locales", "ID", $idLocal);
            $idClientUser=$obCon->normalizar($_REQUEST["idClientUser"]);
            print('<div class="page-wrapper mdc-toolbar-fixed-adjust">');
                print('<div class="content-wrapper">');
                    print('<div class="mdc-layout-grid">');                        
                        print('<div class="mdc-layout-grid__inner">');
                            $col=4;
                            
                            $dbLocal=$DatosLocal["db"];
                            $sql="SELECT t1.*,
                                    (SELECT t2.Ruta FROM productos_servicios_imagenes t2 WHERE t1.ID=t2.idProducto ORDER BY t1.ID ASC LIMIT 1) as RutaImagen 
                                    FROM productos_servicios t1 WHERE t1.Estado=1";
                            $Consulta=$obCon->Query2($sql, HOST, USER, PW, $dbLocal, "");
                            while($DatosProductos=$obCon->FetchAssoc($Consulta)){
                                $html=$css->getHtmlInfoProducto($idClientUser, $idLocal, $DatosProductos["ID"], $DatosProductos["Nombre"], $DatosProductos["DescripcionCorta"], $DatosProductos["RutaImagen"], $DatosProductos["PrecioVenta"]);
                                $css->divForm($DatosProductos["Nombre"], $html, "", "style=width:100%", $col);
                            }
                            
                            
                            
                        $css->Cdiv();
                    $css->Cdiv();
                $css->Cdiv();
            $css->Cdiv();
           
        break;//fin caso 4   
        
        case 5:// Lista de pedidos
            
            $idClientUser=$obCon->normalizar($_REQUEST["idClientUser"]);
            if($idClientUser==''){
                exit("No se recibió el id del usuario");
            }
            $sql="SELECT t1.*,t2.Nombre,t2.Telefono,t2.Direccion,t2.db  
                    FROM pedidos t1 INNER JOIN locales t2 ON t1.local_id=t2.ID 
                     
                    WHERE t1.cliente_id='$idClientUser' AND t1.Estado=1 ORDER BY local_id ASC";            
            $Consulta=$obCon->Query($sql);
            
            $TotalPedido=0;
                            
            while($DatosPedido=$obCon->FetchAssoc($Consulta)){
                $html="";
                $idPedido=$DatosPedido["ID"];
                $idLocal=$DatosPedido["local_id"];
                $db=$DatosPedido["db"];
                //$Titulo='Pedido para '.$DatosPedido["Nombre"].', Telefono: '.$DatosPedido["Telefono"].', '.$DatosPedido["Direccion"]; 
                $htmlTitulo='<table style="width:100%;">
                                <tr>
                                    <td colspan=2 style="text-align:center"><strong>Orden de pedido No. </strong>'.$DatosPedido["ID"].'</td>
                                </tr> 
                                <tr>
                                    <td><strong>Local:</strong></td>
                                    <td onclick="DibujaLocal(`'.$idLocal.'`)" style="text-align:right;cursor:pointer;">'.$DatosPedido["Nombre"].' <span class="mdi mdi-eye"></span></td>
                                </tr>
                                <tr>
                                    <td><strong>Telefono:</strong></td>
                                    <td style="text-align:right">'.$DatosPedido["Telefono"].'</td>
                                </tr>
                                <tr>
                                    <td><strong>Direccion:</strong></td>
                                    <td style="text-align:right">'.$DatosPedido["Direccion"].'</td>
                                </tr>
                            </table>';
                $css->CrearTitulo($htmlTitulo,5);
                
                $sql="SELECT t1.*,t2.Nombre,t2.DescripcionCorta,t2.Referencia 
                         FROM pedidos_items t1 INNER JOIN productos_servicios t2 ON t1.product_id=t2.ID
                         
                            WHERE t1.pedido_id='$idPedido' ";
                $ConsultaItems=$obCon->Query2($sql, HOST, USER, PW, $db, "");
                
                while($DatosItems=$obCon->FetchAssoc($ConsultaItems)){
                    $idItem=$DatosItems["ID"];
                    
                    $jsIcon=("onclick=EliminarItemPedido(`$idLocal`,`$idItem`)");
                    
                    $ValorUnitario= number_format($DatosItems["ValorUnitario"]);
                    $Cantidad=$DatosItems["Cantidad"];
                    $idTextCantidad="Cantidad_".$idItem; 
                    $idTextValorUnitario="ValorUnitario_".$idItem; 
                    $htmlCantidad=$css->getHtmlInput("number", $idTextCantidad, $idTextCantidad, $Cantidad, "Cantidad","","onchange=EditarCampoItems(`1`,`$idLocal`,`$idTextCantidad`,`Cantidad`,`$idItem`);ActualiceSpTotalItem(`$idItem`)");
                    //$htmlValorUnitario=$css->getHtmlInput("hidden", $idTextValorUnitario, $idTextValorUnitario, $DatosItems["ValorUnitario"], "","","");
                    $htmlValorUnitario='<input type="hidden" id="'.$idTextValorUnitario.'" value="'.$DatosItems["ValorUnitario"].'">';
                    $Total=number_format($DatosItems["Total"]);
                    $TotalPedido=$TotalPedido+$DatosItems["Total"];
                    $htmlBody='<hr>Vr. Unitario: <strong style="font-size:15px;">$'.$ValorUnitario.'</strong>';
                    $htmlBody.='<hr><strong style="font-size:15px;">'.$htmlValorUnitario.$htmlCantidad.'</strong>';
                    $htmlBody.='<hr>Total: <strong style="font-size:20px;">$<span id="spTotalItem_'.$idItem.'">'.$Total.'</span></strong>';
                    
                    $idTextObservaciones="Observaciones_".$idItem; 
                    $htmlObservaciones=$css->getHtmlInput("textarea","Observaciones_".$idItem, "Observaciones", $DatosItems["Observaciones"], "Observaciones",'',"onchange=EditarCampoItems(`1`,`$idLocal`,`$idTextObservaciones`,`Observaciones`,`$idItem`)","",1);
                    $css->divCard(utf8_encode($DatosItems["Nombre"]), ($htmlBody), $htmlObservaciones, "mdi mdi-playlist-remove", "danger","","",$jsIcon,"style=cursor:pointer");       

                }
                
                
            }
                
                $inputObservaciones=$css->getHtmlInput("textarea", "ObservacionesPedido_".$DatosPedido["ID"], "ObservacionesPedido_".$DatosPedido["ID"], "", "Observaciones Generales","");
                
                $inputNombre=$css->getHtmlInput("text", "NombreCliente", "NombreCliente", "", "Nombre","","","input",1);
                $inputDireccion=$css->getHtmlInput("text", "DireccionCliente", "DireccionCliente", "", "Direccion","","","home",1);
                $inputTelefono=$css->getHtmlInput("text", "Telefono", "Telefono", "", "Telefono","","","telephone",1);
                $htmInputs="<br>".$inputNombre."<br>".$inputDireccion."<br>".$inputTelefono."<br>".$inputObservaciones;
                $htmlBotonCancelar=$css->getHtmlBoton(2, "btnDescartarPedido", "btnDescartarPedido", "Descartar", "onclick=ConfimarDescartarPedidos(`$idClientUser`)", "width:100px;");
                $htmlBotonConfirmar=$css->getHtmlBoton(1, "btnGuardarPedido", "btnGuardarPedido", "Solicitar", "onclick=ConfimarSolicitarPedidos(`$idClientUser`)", "width:100px;");
                $htmlFormPedido='<table style="width:100%;background-color:white">
                                <tr>
                                    <td><strong>Total de este Pedido:</strong></td>
                                    <td style="text-align:right"><strong>$<span id="spTotalFormPedido">'. number_format($TotalPedido).'</span></strong></td>
                                </tr>
                                <tr>
                                    <td colspan=2 style="text-align:center"><br>'.$inputNombre.'</td>
                                </tr> 
                                <tr>
                                    <td colspan=2 style="text-align:center"><br>'.$inputDireccion.'</td>
                                </tr> 
                                <tr>
                                    <td colspan=2 style="text-align:center"><br>'.$inputTelefono.'</td>
                                </tr> 
                                <tr>
                                    <td colspan=2 style="text-align:center"><br>'.$inputObservaciones.'<br></td>
                                </tr> 
                                <tr>
                                    <td>'.$htmlBotonCancelar.'</td>
                                    <td style="text-align:right">'.$htmlBotonConfirmar.'</td>
                                </tr>
                                
                                
                            </table>';
                $css->CrearTitulo($htmlFormPedido,8);
            
        break;//Fin caso 5    
        
 }
    
          
}else{
    print("No se enviaron parametros");
}
?>