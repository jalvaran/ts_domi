<?php

include_once("../clases/main.class.php");// se debe incluir la clase del modulo 
include_once("../../../constructores/paginas_constructor.php");// siempre debera de ir ya que utilizara html que esta en el constructor

$ipUser=$_SERVER['REMOTE_ADDR'];

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
                $css->divCard("",($DatosCategorias["Nombre"]), ($DatosCategorias["Descripcion"]), "", $DatosCategorias["Icono"], $DatosCategorias["ColorIcono"],$js,"style=cursor:pointer");       

            }
            
            $idCliente=$obCon->normalizar($_REQUEST["idClientUser"]);
            $idPantalla=$obCon->normalizar($_REQUEST["idPantalla"]); 
            $obCon->logVisit($idCliente, $idPantalla, 0, $ipUser);
            
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
                $css->divCardLocales($Fondo,($DatosCategorias["Nombre"]), ($DatosCategorias["Descripcion"]), ($DatosCategorias["Telefono"]."<br>".$DatosCategorias["Direccion"]), $DatosCategorias["Icono"], $DatosCategorias["ColorIcono"],$js,"style=cursor:pointer");       

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
            $values["values"][0]="";       $values["text"][0]="Todas";  $values["sel"][0]=1;  
            while ($DatosConsulta = $obCon->FetchAssoc($Consulta)) {                
                $values["values"][$i]=$DatosConsulta["ID"];       $values["text"][$i]=$DatosConsulta["Clasificacion"];
                $i=$i+1;
            }
            $css->divCardLocales($Fondo,($DatosLocal["Nombre"]), ($DatosLocal["Descripcion"]), ($DatosLocal["Telefono"]."<br>".$DatosLocal["Direccion"]), $DatosLocal["Icono"], $DatosLocal["ColorIcono"],$js,"style=cursor:pointer",12);       
            
            $style="style='width:130%;'";
            $js="onchange=ListarProductos(`$idLocal`);Page=1;"; 
            $htmlSelect=$css->getHtmlSelectBootstrap("cmbClasificacion", "cmbClasificacion", $values, "Clasificacion", $js, $style);
            $Title="Clasificacion";
            $css->divForm($Title, $htmlSelect);
            
            
            
            $html=$css->getHtmlInput("text","BusquedaProducto", "BusquedaProducto", "", "Buscar",$js,$style,"search",1);
            $css->divForm("Busqueda", $html, "", "", 6);
            
            if(isset($_REQUEST["idClientUser"]) and isset($_REQUEST["idPantalla"])){
                $idCliente=$obCon->normalizar($_REQUEST["idClientUser"]);
                $idPantalla=$obCon->normalizar($_REQUEST["idPantalla"]); 
                $obCon->logVisit($idCliente, $idPantalla, $idLocal, $ipUser);
            }
            print('<div id="DivProductos" class="mdc-layout-grid__cell--span-12">');
            
            $css->Cdiv();
        break;//fin caso 3
        
        case 4://lista los productos
            $Limit=20;
            $idLocal=$obCon->normalizar($_REQUEST["idLocal"]);
            $BusquedaProducto=$obCon->normalizar($_REQUEST["BusquedaProducto"]);
            $cmbClasificacion=$obCon->normalizar($_REQUEST["cmbClasificacion"]);
            $Page=$obCon->normalizar($_REQUEST["Page"]);
            if($idLocal==''){
                exit("No se recibió un local");
            }
            if($Page==''){
                $Page=1;
                $NumPage=1;
            }
            
            $Condicion=" WHERE t1.Estado=1 ";
            if($cmbClasificacion<>''){
                $Condicion.=" AND idClasificacion='$cmbClasificacion'";
            }
            if($BusquedaProducto<>''){
                $Condicion.=" AND Nombre like '%$BusquedaProducto%'";
            }
            
            $DatosLocal=$obCon->DevuelveValores("locales", "ID", $idLocal);
            $idClientUser=$obCon->normalizar($_REQUEST["idClientUser"]);
            $dbLocal=$DatosLocal["db"];
            $PuntoInicio = ($Page * $Limit) - $Limit;
            
            $sql = "SELECT COUNT(t1.ID) as Items 
                   FROM productos_servicios t1 $Condicion;";
            
            $Consulta2=$obCon->QueryExterno($sql, HOST, USER, PW, $dbLocal, "");
            $totales = $obCon->FetchAssoc($Consulta2);
            $ResultadosTotales = $totales['Items'];
            
            if($ResultadosTotales>$Limit){
                $TotalPaginas= ceil($ResultadosTotales/$Limit);
                if($Page>1){
                    $js="onclick=pageMinus();";
                    $css->botonNavegacion($js, "green", "pageNav-pageBack-icon mdi mdi-arrow-left-bold", "PageMinus");
                }
                if($ResultadosTotales>($PuntoInicio+$Limit)){
                    $js="onclick=pageAdd();";
                    $css->botonNavegacion($js, "green", "pageNav-pageForward-icon mdi mdi-arrow-right-bold", "PageAdd");
                }
            }
            
            print('<div class="page-wrapper mdc-toolbar-fixed-adjust">');
                print('<div class="content-wrapper">');
                    print('<div class="mdc-layout-grid">');                        
                        print('<div class="mdc-layout-grid__inner">');
                            $col=4;
                            
                            
                            $sql="SELECT t1.*,
                                    (SELECT t2.Ruta FROM productos_servicios_imagenes t2 WHERE t1.ID=t2.idProducto ORDER BY t1.ID ASC LIMIT 1) as RutaImagen 
                                    FROM productos_servicios t1 $Condicion ORDER BY ID DESC LIMIT $PuntoInicio,$Limit;";
                            
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
                    $idCardItem="divCardItem_".$idItem;
                    $jsIcon=("onclick=EliminarItemPedido(`$idLocal`,`$idItem`,`$idCardItem`)");
                    
                    $ValorUnitario= number_format($DatosItems["ValorUnitario"]);
                    $Cantidad=$DatosItems["Cantidad"];
                    $idTextCantidad="Cantidad_".$idItem; 
                    $idTextValorUnitario="ValorUnitario_".$idItem; 
                    
                    $htmlSpCantidad='<div style="text-align:center;width:100px;height:40px;padding: 10px;"><span id="spCantidadItem_'.$idItem.'" style="font-size:20px;">'.number_format($Cantidad).'</span></div>';
                    $htmlButtonAdd='<button class="btn btn-success" style="width:100px;" onclick=SumaRestaCantidad(`1`,`'.$idTextCantidad.'`,`'.$idLocal.'`,`'.$idItem.'`)><span class="mdi mdi-arrow-up-bold-outline"></span></button>';
                   // $htmlCantidad=$css->getHtmlInput("hidden", $idTextCantidad, $idTextCantidad, $Cantidad, "","onchange=EditarCampoItems(`1`,`$idLocal`,`$idTextCantidad`,`Cantidad`,`$idItem`);ActualiceSpTotalItem(`$idItem`);",'style=width:100px;','','',0);
                    $htmlCantidad="<input type='hidden' id='$idTextCantidad' value='$DatosItems[Cantidad]'>";
                    $htmlButtonMinus='<button class="btn btn-warning" style="width:100px;" onclick=SumaRestaCantidad(`2`,`'.$idTextCantidad.'`,`'.$idLocal.'`,`'.$idItem.'`)><span class="mdi mdi-arrow-down-bold-outline"></span></button>';
                    $htmlValorUnitario='<input type="hidden" id="'.$idTextValorUnitario.'" value="'.$DatosItems["ValorUnitario"].'">';
                    $Total=number_format($DatosItems["Total"]);
                    $TotalPedido=$TotalPedido+$DatosItems["Total"];
                    $htmlBody='<hr>Vr. Unitario: <strong style="font-size:15px;">$'.$ValorUnitario.'</strong>';
                    $htmlBody.='<hr><strong style="font-size:15px;">'.$htmlValorUnitario.$htmlButtonAdd."<br>".$htmlCantidad.$htmlSpCantidad."".$htmlButtonMinus.'</strong>';
                    $htmlBody.='<hr>Total: <strong style="font-size:20px;">$<span id="spTotalItem_'.$idItem.'">'.$Total.'</span></strong>';
                    
                    $idTextObservaciones="Observaciones_".$idItem; 
                    $htmlObservaciones=$css->getHtmlInput("textarea","Observaciones_".$idItem, "Observaciones", $DatosItems["Observaciones"], "Observaciones",'',"onchange=EditarCampoItems(`1`,`$idLocal`,`$idTextObservaciones`,`Observaciones`,`$idItem`)","",1);
                    $css->divCard($idCardItem,($DatosItems["Nombre"]), ($htmlBody), $htmlObservaciones, "mdi mdi-playlist-remove", "danger","","",$jsIcon,"style=cursor:pointer");       

                }
                
                
            }
            if($TotalPedido>0){
                $inputObservaciones=$css->getHtmlInput("textarea", "ObservacionesPedido", "ObservacionesPedido", "", "Observaciones Generales","");
                
                $inputNombre=$css->getHtmlInput("text", "NombreCliente", "NombreCliente", "", "Nombre","","","input",1);
                $inputDireccion=$css->getHtmlInput("text", "DireccionCliente", "DireccionCliente", "", "Direccion","","","home",1);
                $inputTelefono=$css->getHtmlInput("number", "Telefono", "Telefono", "", "Telefono","","","telephone",1);
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
            }else{
                $css->CrearTitulo("<strong>Tu Cesta está vacía!<strong>",4);
            }
            
            if(isset($_REQUEST["idClientUser"]) and isset($_REQUEST["idPantalla"])){
                $idCliente=$obCon->normalizar($_REQUEST["idClientUser"]);
                $idPantalla=$obCon->normalizar($_REQUEST["idPantalla"]); 
                $obCon->logVisit($idCliente, $idPantalla, 0, $ipUser);
            }
            
        break;//Fin caso 5    
        
        case 6://dibuja el listado de los locales de acuerdo a la busqueda
            $Busqueda=$obCon->normalizar($_REQUEST["Busqueda"]);
            $sql="SELECT * FROM locales WHERE Nombre LIKE '%$Busqueda%' AND Estado=1 ORDER BY Orden ASC LIMIT 50";
            $Consulta=$obCon->Query($sql);
            while($DatosCategorias=$obCon->FetchAssoc($Consulta)){
                $idItem=$DatosCategorias["ID"];
                $js="onclick=DibujaLocal(`$idItem`)";
                $Fondo="../../images/image.webp";
                $DatosFondo=$obCon->DevuelveValores("locales_imagenes", "idLocal", $idItem);
                if($DatosFondo["ID"]<>''){
                    $Fondo=$DatosFondo["Ruta"];
                }
                $css->divCardLocales($Fondo,($DatosCategorias["Nombre"]), ($DatosCategorias["Descripcion"]), ($DatosCategorias["Telefono"]."<br>".$DatosCategorias["Direccion"]), $DatosCategorias["Icono"], $DatosCategorias["ColorIcono"],$js,"style=cursor:pointer");       

            }
            
        break;//fin caso 6
        
        case 7://formulario para iniciar sesion
            
            print('
              <div class="stretch-card mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-1-tablet"></div>
              <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-6-tablet">
                <div class="mdc-card">
                  <form>
                    <div class="mdc-layout-grid">
                      <div class="mdc-layout-grid__inner">
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                          <div class="mdc-text-field w-100 mdc-ripple-upgraded" style="--mdc-ripple-fg-size:209px; --mdc-ripple-fg-scale:1.7296289512582848; --mdc-ripple-fg-translate-start:15.83331298828125px, -84.5px; --mdc-ripple-fg-translate-end:69.79998779296875px, -82px;">
                            <input class="mdc-text-field__input" id="user_domi">
                            <div class="mdc-line-ripple" style="transform-origin: 120.333px center 0px;"></div>
                            <label for="text-field-hero-input" class="mdc-floating-label">Usuario</label>
                          </div>
                        </div>
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                          <div class="mdc-text-field w-100 mdc-ripple-upgraded" style="--mdc-ripple-fg-size:209px; --mdc-ripple-fg-scale:1.7296289512582848; --mdc-ripple-fg-translate-start:56.83331298828125px, -83.5px; --mdc-ripple-fg-translate-end:69.79998779296875px, -82px;">
                            <input class="mdc-text-field__input" type="password" id="pw_domi">
                            <div class="mdc-line-ripple" style="transform-origin: 161.333px center 0px;"></div>
                            <label for="text-field-hero-input" class="mdc-floating-label">Password</label>
                          </div>
                        </div>
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                          
                        </div>
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop d-flex align-items-center justify-content-end">
                          
                        </div>
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                          <a href="#" class="mdc-button mdc-button--raised w-100 mdc-ripple-upgraded" onclick=ValidarLogin();>
                            Entrar
                          </a>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <div class="stretch-card mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-1-tablet"></div>
            ');
            
        break;//Fin caso 7    
        
 }
    
          
}else{
    print("No se enviaron parametros");
}
?>