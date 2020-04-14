<?php
session_start();
include_once("../clases/admin.class.php");// se debe incluir la clase del modulo 
include_once("../../../constructores/paginas_constructor.php");// siempre debera de ir ya que utilizara html que esta en el constructor

$ipUser=$_SERVER['REMOTE_ADDR'];
$Accion=$_REQUEST["Accion"];

$css =  new PageConstruct("", "", 1, "", 1, 0);// se instancia para poder utilizar el html
$obCon = new Admin(1);// se instancia para poder conectarse con la base de datos 
    
if($Accion<>1){
    $Token=$obCon->normalizar($_REQUEST["Token_user"]);
    $DatosSesion=$obCon->VerificaSesion($Token);
    if($DatosSesion["Estado"]=="E1"){
       $css->CrearTitulo($DatosSesion["Mensaje"], 3);
        exit();
    }
}
            
if(!empty($_REQUEST["Accion"]) ){// se verifica si el indice accion es diferente a vacio 
    
    
    
    switch($_REQUEST["Accion"]) {
       
        case 1://formulario para iniciar sesion
            $Token=$obCon->normalizar($_REQUEST["Token_user"]);
            $DatosSesion=$obCon->VerificaSesion($Token);
           
            if($DatosSesion["Estado"]=="OK"){
                
                exit("OK");
            }
            
            include_once("../../../constructores/paginas_constructor.php");// siempre debera de ir ya que utilizara html que esta en el constructor

            $ipUser=$_SERVER['REMOTE_ADDR'];
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
                            <input class="mdc-text-field__input" type="password" id="pw_domi" onchange=ValidarLogin();>
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
            
        break;//Fin caso 2
        
        case 2://Dibuja el panel de administracion
            $idLocal=$obCon->normalizar($_SESSION["idLocal"]);            
            $DatosLocal=$obCon->DevuelveValores("locales", "ID", $idLocal);
            $css->CrearTitulo("<strong>".$DatosLocal["Nombre"]."</strong>", 1);
            print('<div id="divMenu" class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12 mdc-layout-grid__cell--span-12-tablet">');
            $html="";
            if($idLocal==1){
                $html=$css->getHtmlBoton(4, "MnuLocales", "MnuLocales", "Locales", "onclick=adminLocales();Page=1;", "width:150px;");
                $html.=$css->getHtmlBoton(3, "MnuMigraciones", "MnuMigraciones", "Migraciones", "onclick=ConfirmarMigracion();", "width:150px;");
            } 
            $html.=" &nbsp;";
            $css->Cdiv();
            print('<div id="divMenu" class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12 mdc-layout-grid__cell--span-12-tablet">');
                   
            $html.=$css->getHtmlBoton(1, "MnuClasificacion", "MnuClasificacion", "Clasificación", "onclick=adminClasificacion();Page=1;", "width:150px;");
            $html.=" &nbsp;".$css->getHtmlBoton(2, "MnuProductos", "MnuProductos", "Productos", "onclick=adminProductos();Page=1;", "width:150px;");
            $html.=" &nbsp;".$css->getHtmlBoton(5, "MnuPedidos", "MnuPedidos", "Pedidos", "onclick=adminPedidos();Page=1;", "width:150px;");
            $html.='<input id="BusquedaAdmin" class="form-control" placeholder="Buscar..." onchange="VerMenuSegunID();Page=1;">';
            //$html.=" &nbsp;".$css->getHtmlInput("text", "BusquedaAdmin", "", "", "Buscar", "onchange=VerMenuSegunID()", "style=width:200px;", "", "1");
            $html.='';
            
            print($html);
            print('</div>');
            print('<div id="divMenu" class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12 mdc-layout-grid__cell--span-12-tablet">');
             
                
                $sql="SELECT * FROM pedidos_estados ORDER BY ID ASC";
                $Consulta=$obCon->Query($sql);
                $valuesEstados["values"][0]="";
                $valuesEstados["text"][0]="Mostrar pedidos por estado";
                $es=1;
                while($DatosEstados=$obCon->FetchAssoc($Consulta)){
                    $valuesEstados["values"][$es]=$DatosEstados["ID"];
                    $valuesEstados["text"][$es]=$DatosEstados["EstadoPedido"];
                    $es=$es+1;
                }

                $htmlSelect=$css->getHtmlSelectBootstrap("cmbSelectFiltroPedidos", "cmbSelectFiltroPedidos", $valuesEstados, "Seleccione un estado", "onchange=adminPedidos();Page=1;", "");
                print($htmlSelect);
            print('</div>');
            
            print('<div  class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12 mdc-layout-grid__cell--span-12-tablet">');
                print('<div id="divAdmin" class="mdc-card" style="width:100%">

                    </div>');
            print('</div>');
            
        break;//Fin caso 2
    
        case 3://Dibuja el listado de las clasificaciones
            $Limit=20;
            $idLocal=$obCon->normalizar($_SESSION["idLocal"]);            
            $DatosLocal=$obCon->DevuelveValores("locales", "ID", $idLocal);            
            $Page=$obCon->normalizar($_REQUEST["Page"]);
            $Busqueda=$obCon->normalizar($_REQUEST["Busqueda"]);
            if($Page==''){
                $Page=1;
                
            }
            $Condicion=" WHERE ID>0 ";
            
            if($Busqueda<>''){
                $Condicion.=" AND Clasificacion like '%$Busqueda%'";
            }
            
            $PuntoInicio = ($Page * $Limit) - $Limit;
            
            $sql = "SELECT COUNT(t1.ID) as Items 
                   FROM inventarios_clasificacion t1 $Condicion;";
            
            $Consulta2=$obCon->QueryExterno($sql, HOST, USER, PW, $DatosLocal["db"], "");
            $totales = $obCon->FetchAssoc($Consulta2);
            $ResultadosTotales = $totales['Items'];
            
            if($ResultadosTotales>$Limit){
                $TotalPaginas= ceil($ResultadosTotales/$Limit);
                if($Page>1){
                    $js="onclick=pageMinusAdmin();";
                    $css->botonNavegacion($js, "green", "pageNav-pageBack-icon mdi mdi-arrow-left-bold", "PageMinus");
                }
                if($ResultadosTotales>($PuntoInicio+$Limit)){
                    $js="onclick=pageAddAdmin();";
                    $css->botonNavegacion($js, "green", "pageNav-pageForward-icon mdi mdi-arrow-right-bold", "PageAdd");
                }
            }
            
            $sql="SELECT ID, Clasificacion, Estado FROM inventarios_clasificacion $Condicion ORDER BY ID DESC LIMIT $PuntoInicio,$Limit;";
            $Consulta=$obCon->QueryExterno($sql, HOST, USER, PW, $DatosLocal["db"], "");
            $i=0;
            $Filas[]="";
            while($DatosClasificacion=$obCon->FetchAssoc($Consulta)){
                $Filas[$i]=$DatosClasificacion;
                $i=$i+1;
            }
            $js="onclick=FormularioAgregarEditar(`1`)";
            $Columnas[0]="<strong>Editar</strong>";
            $Columnas[1]="<strong>ID</strong>";
            $Columnas[2]="<strong>Clasificación</strong>";
            $Columnas[3]="<strong>Estado</strong>";
            $Acciones["ID"]["js"]="onclick=FormularioAgregarEditar(`1`,`@value`)";
            $Acciones["ID"]["icon"]="mdi mdi-database-edit";
            $Acciones["ID"]["style"]="style=font-size:20px;color:blue;cursor:pointer";
            $htmlTabla=$css->getHtmlTable("<span class='mdi mdi-database-plus' style='font-size:40px;color:green;cursor:pointer' $js></span> <strong>CLASIFICACIONES</strong>", $Columnas, $Filas,$Acciones);
            print($htmlTabla);
        break;//Fin canoso 3
        
        case 4://Dibuja el listado de los productos
            
            $Limit=20;
            $idLocal=$obCon->normalizar($_SESSION["idLocal"]);            
            $DatosLocal=$obCon->DevuelveValores("locales", "ID", $idLocal);            
            $Page=$obCon->normalizar($_REQUEST["Page"]);
            $Busqueda=$obCon->normalizar($_REQUEST["Busqueda"]);
            
            print("<h3>Agregar Producto</h3>");
            
            $css->select("idClasificacion", "form-control", "idClasificacion", "", "", "", "");
                $css->option("", "", "", "", "", "");
                    print("Seleccione una Clasificacion");
                $css->Coption();
                $sql="SELECT * FROM inventarios_clasificacion";
                $ConsultaClasificacion=$obCon->QueryExterno($sql, HOST, USER, PW, $DatosLocal["db"], "");
                while($DatosConsultaClasificacion=$obCon->FetchAssoc($ConsultaClasificacion)){
                    $css->option("", "", "", $DatosConsultaClasificacion["ID"], "", "");
                        print($DatosConsultaClasificacion["Clasificacion"]);
                    $css->Coption();
                }
            $css->Cselect();
            print("<hr>");
            $css->input("text", "Nombre", "form-control", "Nombre", "", "", "Nombre", "off", "", "", "");
            print("<hr>");
            $css->input("number", "PrecioVenta", "form-control", "PrecioVenta", "", "", "PrecioVenta", "off", "", "", "");
            print("<hr>");
            print('<input type="file" class="form-control"  name="images[]" id="imgsProducto" multiple>');
            print("<hr>");
            $htmlBoton=$css->getHtmlBoton(1, "btnGuardarProducto", "btnGuardarProducto", "Agregar", "onclick=GuardarProductoRapido()");
            print($htmlBoton);
            
            
            if($Page==''){
                $Page=1;
                
            }
            $Condicion=" WHERE ID<>'' ";
            
            if($Busqueda<>''){
                $Condicion.=" AND (ID='$Busqueda' OR Nombre like '%$Busqueda%' or Referencia like '$Busqueda%')";
            }
            
            $PuntoInicio = ($Page * $Limit) - $Limit;
            
            $sql = "SELECT COUNT(t1.ID) as Items 
                   FROM productos_servicios t1 $Condicion;";
            
            $Consulta2=$obCon->QueryExterno($sql, HOST, USER, PW, $DatosLocal["db"], "");
            $totales = $obCon->FetchAssoc($Consulta2);
            $ResultadosTotales = $totales['Items'];
            
            if($ResultadosTotales>$Limit){
                $TotalPaginas= ceil($ResultadosTotales/$Limit);
                if($Page>1){
                    $js="onclick=pageMinusAdmin();";
                    $css->botonNavegacion($js, "green", "pageNav-pageBack-icon mdi mdi-arrow-left-bold", "PageMinus");
                }
                if($ResultadosTotales>($PuntoInicio+$Limit)){
                    $js="onclick=pageAddAdmin();";
                    $css->botonNavegacion($js, "green", "pageNav-pageForward-icon mdi mdi-arrow-right-bold", "PageAdd");
                }
            }
            
            $sql="SELECT ID, Nombre,PrecioVenta, DescripcionCorta FROM productos_servicios $Condicion ORDER BY ID DESC LIMIT $PuntoInicio,$Limit;";
            $Consulta=$obCon->QueryExterno($sql, HOST, USER, PW, $DatosLocal["db"], "");
            $i=0;
            $Filas[]="";
            while($DatosClasificacion=$obCon->FetchAssoc($Consulta)){
                $Filas[$i]=$DatosClasificacion;
                $i=$i+1;
            }
            $Titulo="PRODUCTOS";
            $js="onclick=FormularioAgregarEditar(`2`)";
            $Columnas[0]="<strong>Editar</strong>";
            $Columnas[1]="<strong>ID</strong>";
            $Columnas[2]="<strong>Nombre</strong>";
            $Columnas[3]="<strong>Precio de Venta</strong>";
            $Columnas[4]="<strong>Descripcion</strong>";
            //$Acciones["ID"]["js"]="onclick=FormularioAgregarEditar(`2`,`@value`)";
            //$Acciones["ID"]["icon"]="mdi mdi-database-edit";
            //$Acciones["ID"]["style"]="style=font-size:20px;color:blue;cursor:pointer";
            $Acciones["ID"]["html"]='<span class="mdi mdi-database-edit" style="font-size:20px;color:blue;cursor:pointer" onclick=FormularioAgregarEditar(`2`,`@value`)></span> || 
                    <span class="mdi mdi-camera-plus" style="font-size:20px;color:green;cursor:pointer" onclick=FormularioAgregarImagenProducto(`@value`);Page=1;></span>';
            $htmlTabla=$css->getHtmlTable("<span class='mdi mdi-database-plus' style='font-size:40px;color:green;cursor:pointer' $js></span> <strong>$Titulo</strong>", $Columnas, $Filas,$Acciones);
            print($htmlTabla);
        break;//Fin canoso 4
        
        case 5://Dibuja el listado de los pedidos
            $Limit=20;
            $idLocal=$obCon->normalizar($_SESSION["idLocal"]);            
            $DatosLocal=$obCon->DevuelveValores("locales", "ID", $idLocal);            
            $Page=$obCon->normalizar($_REQUEST["Page"]);
            $Busqueda=$obCon->normalizar($_REQUEST["Busqueda"]);
            $FiltroEstado=$obCon->normalizar($_REQUEST["FiltroEstado"]);
            if($Page==''){
                $Page=1;
                
            }
            $Condicion=" WHERE local_id='$idLocal' ";
            
            if($Busqueda<>''){
                $Condicion.=" AND (t1.ID='$Busqueda' or t2.Nombre like '%$Busqueda%' or t2.Telefono like '$Busqueda%')";
            }
            if($FiltroEstado<>''){
                $Condicion.=" AND Estado='$FiltroEstado'";
            }
            $PuntoInicio = ($Page * $Limit) - $Limit;
            
            $sql = "SELECT COUNT(t1.ID) as Items 
                   FROM pedidos t1 INNER JOIN client_user t2 ON t2.ID=t1.cliente_id
                   $Condicion;";
            
            $Consulta2=$obCon->Query($sql);
            $totales = $obCon->FetchAssoc($Consulta2);
            $ResultadosTotales = $totales['Items'];
            
            if($ResultadosTotales>$Limit){
                $TotalPaginas= ceil($ResultadosTotales/$Limit);
                if($Page>1){
                    $js="onclick=pageMinusAdmin();";
                    $css->botonNavegacion($js, "green", "pageNav-pageBack-icon mdi mdi-arrow-left-bold", "PageMinus");
                }
                if($ResultadosTotales>($PuntoInicio+$Limit)){
                    $js="onclick=pageAddAdmin();";
                    $css->botonNavegacion($js, "green", "pageNav-pageForward-icon mdi mdi-arrow-right-bold", "PageAdd");
                }
            }
            
            
            $sql="SELECT * FROM pedidos_estados ORDER BY ID ASC";
            $Consulta=$obCon->Query($sql);
            $es=1;
            while($DatosEstados=$obCon->FetchAssoc($Consulta)){
                $valuesEstados["values"][$es]=$DatosEstados["ID"];
                $valuesEstados["text"][$es]=$DatosEstados["EstadoPedido"];
                $es=$es+1;
            }
            
            
            $sql="SELECT t1.ID,t1.Created, t2.Nombre,t2.Direccion,t2.Telefono,t1.Total,t1.Estado,
                    (SELECT EstadoPedido FROM pedidos_estados t3 WHERE t3.ID=t1.Estado LIMIT 1) as NombreEstado 
                     FROM pedidos t1 INNER JOIN client_user t2 ON t2.ID=t1.cliente_id
                     $Condicion ORDER BY ID DESC LIMIT $PuntoInicio,$Limit;";
            $Consulta=$obCon->Query($sql);
            
            
            
            $i=0;
            $TablaFilas="";
            $TotalPedidos=0;
            $Items=0;
            while($DatosPedidos=$obCon->FetchAssoc($Consulta)){
                $TotalPedidos=$DatosPedidos["Total"];
                $Items=$Items+1;
                $TablaFilas.=$css->FilaTabla(16);
                $id=$DatosPedidos["ID"];                
                $Ruta="../../general/Consultas/PDF_Documentos.draw.php?idDocumento=1&ID=$id";
                $LinkPDF='<a href="'.$Ruta.'" target="_blank"><span class="mdi mdi-file-pdf" style="font-size:30px;color:red;cursor:pointer"></span></a>';
                $TablaFilas.=$css->ColTabla($LinkPDF, 1, "L");
                
                $idSel=0;
                foreach ($valuesEstados["values"] as $key => $value) {
                    if($DatosPedidos["Estado"]==$value){
                        $idSel=$key;
                        //print("$key || $value");
                    }
                }
                $valuesEstados["sel"][$idSel]=1;
                
                $htmlSelect=$css->getHtmlSelectBootstrap("cmbEstado_".$id, "cmbEstado_".$id, $valuesEstados, "", "onchange=CambiarEstadoPedido(`$id`)", "style=width:180px;");
                unset($valuesEstados["sel"][$idSel]);
                
                
                foreach ($DatosPedidos as $key => $value) {
                    $Align="L";
                    if($key=="Estado"){
                        continue;
                    }if($key=="NombreEstado"){
                        continue;
                    }
                    if($key=="Total"){
                        $value= number_format($value);
                        $Align="R";
                    }
                    
                    if($key=="ID"){
                        $TablaFilas.=$css->ColTabla($value."<br>".$htmlSelect, 1, $Align);
                        continue;
                    }
                    
                    $TablaFilas.=$css->ColTabla($value, 1, $Align);
                      
                }
                                
                $TablaFilas.=$css->CierraFilaTabla();  
                
                
            }
            
            $z=0;
            $Titulo="MOSTRANDO <strong>".number_format($Items)."</strong> PEDIDOS PARA UN TOTAL DE: <strong>$". number_format($TotalPedidos)."</strong>";
            $TablaTitulo=$css->FilaTabla(18);
                $TablaTitulo.=$css->ColTabla($Titulo, 8, "C","",1);
            $TablaTitulo.=$css->CierraFilaTabla();
            $js="onclick=FormularioAgregarEditar(`2`)";
            $Columnas[$z++]="<strong>PDF</strong>";
            $Columnas[$z++]="<strong>ID</strong>";
            $Columnas[$z++]="<strong>Fecha</strong>";
            $Columnas[$z++]="<strong>Nombre</strong>";
            $Columnas[$z++]="<strong>Direccion</strong>";
            $Columnas[$z++]="<strong>Telefono</strong>";
            $Columnas[$z++]="<strong>Total</strong>";
            //$Columnas[$z++]="<strong>Estado</strong>";
            $TablaColumnas=$css->FilaTabla(18);
            foreach ($Columnas as $value) {
                $TablaColumnas.=$css->ColTabla($value, 1, "C","",1);
            }   
            $TablaColumnas.=$css->CierraFilaTabla();
            $TablaApertura=$css->CrearTabla("TablaPedidos", 2);
            $TablaCierre=$css->CerrarTabla();
            $headTable=$css->HeadTable();
            $cHeadTable=$css->CheadTable();
            $htmlTabla=$TablaApertura.$headTable.$TablaTitulo.$TablaColumnas.$cHeadTable.$TablaFilas.$TablaCierre;
            
            $values["values"][0]="";
            $values["text"][0]="Cambiar a:";
            
            
            /*
            $htmlSelect=$css->getHtmlSelectBootstrap("cmbEstado_@value", "cmbEstado_@value", $values, "", "onchange=CambiarEstadoPedido(`@value`)", "style=width:200px;");
            $Acciones["ID"]["html"]='<a href="'.$Ruta.'" target="_blank"><span class="mdi mdi-file-pdf" style="font-size:30px;color:red;cursor:pointer"></span></a>';
            $Acciones["ID"]["html"].='<td>'.$htmlSelect.'</td>';
            $Acciones["Estado"]["Visible"]=0;
            $Acciones["NombreEstado"]["html"]='<span id="spEstado_@ID">@value</span>';
            //$Acciones["ID"]["icon"]="mdi mdi-file-pdf";
            //$Acciones["ID"]["style"]="style=font-size:20px;color:red;cursor:pointer";
            $htmlTabla=$css->getHtmlTable("<span class='mdi mdi-database-plus' style='font-size:40px;color:green;cursor:pointer' $js></span> <strong>$Titulo</strong>", $Columnas, $Filas,$Acciones);
            */
            print($htmlTabla);
        break;//Fin canoso 5
        
        case 6://Formulario para agregar o editar una clasificacion
            $idItem=$obCon->normalizar($_REQUEST["idItem"]);
            $Editar=0;
            if($idItem<>''){
                $Editar=1;
            }
            $tab="inventarios_clasificacion";
            $idLocal=$obCon->normalizar($_SESSION["idLocal"]);            
            $DatosLocal=$obCon->DevuelveValores("locales", "ID", $idLocal);
            $sql="SELECT * FROM $tab WHERE ID='$idItem'";
            $DatosActuales=$obCon->FetchAssoc($obCon->QueryExterno($sql, HOST, USER, PW, $DatosLocal["db"], ""));
            $Titulo="<strong>Crear o Editar Clasificación</strong>";
            $html='
                        <div class="mdc-card">
                          <h6 class="card-title">'.$Titulo.'</h6>
                          <div class="template-demo">
                            <div class="mdc-layout-grid__inner">';
            $Cols=6;
            $html.='<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-'.$Cols.'-desktop">';
            $html.=$css->getHtmlInput("text", "Clasificacion", "Clasificacion", $DatosActuales["Clasificacion"], "Clasificacion", "", "", "", 1);
            $html.="</div>";
            $html.='<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-'.$Cols.'-desktop">';
            $values["values"][0]="1";
            $values["text"][0]="Activado";
            $values["values"][1]="0";
            $values["text"][1]="Deshabilitado";
            if($DatosActuales["Estado"]==1 or $DatosActuales["Estado"]==''){
                $values["sel"][0]="1";
            }
            if($DatosActuales["Estado"]==0 and $DatosActuales["Estado"]<>''){
                $values["sel"][1]="1";
            }
            $html.=$css->getHtmlSelect("Estado", "Estado", $values, "Estado", "", "style=width:100%;");            
            $html.="</div><br>";
            
            $html.='<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-'.$Cols.'-desktop">';
            $html.=$css->getHtmlBoton(1, "BtnGuardarEditar", "BtnGuardarEditar", "Guardar", "onclick=ConfirmaGuardarEditar(`1`,`$idItem`)", "width:100px;");
            $html.="</div>";
            $html.="</div></div></div>";
            print($html);
            
        break;//Fin caso 6    
        
        case 7://Formulario para agregar o editar un producto
            $idItem=$obCon->normalizar($_REQUEST["idItem"]);
            $Editar=0;
            if($idItem<>''){
                $Editar=1;
            }
            $tab="productos_servicios";
            $idLocal=$obCon->normalizar($_SESSION["idLocal"]);            
            $DatosLocal=$obCon->DevuelveValores("locales", "ID", $idLocal);
            $sql="SELECT * FROM $tab WHERE ID='$idItem'";
            $DatosActuales=$obCon->FetchAssoc($obCon->QueryExterno($sql, HOST, USER, PW, $DatosLocal["db"], ""));
            $Titulo="<strong>Crear o Editar Producto</strong>";
            $html='
                        <div class="mdc-card">
                          <h6 class="card-title">'.$Titulo.'</h6>
                          <div class="template-demo">
                            <div class="mdc-layout-grid__inner">';
            $Cols=6;
            if($DatosActuales["Referencia"]==''){
                $Referencia=$obCon->getUniqId();
            } else {
                $Referencia=$DatosActuales["Referencia"];
            }
            $html.='<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-'.$Cols.'-desktop">';
            $valuesClasificacion["values"][0]="";
            $valuesClasificacion["text"][0]="Clasificacion";
            $sql="SELECT * FROM inventarios_clasificacion";
            $Consulta=$obCon->QueryExterno($sql, HOST, USER, PW, $DatosLocal["db"], "");
            $i=1;
            while($DatosConsulta=$obCon->FetchAssoc($Consulta)){
                $valuesClasificacion["values"][$i]=$DatosConsulta["ID"];
                $valuesClasificacion["text"][$i]=$DatosConsulta["Clasificacion"];
                if($DatosActuales["idClasificacion"]==$DatosConsulta["ID"]){
                    $valuesClasificacion["sel"][$i]="1";
                }
                $i=$i+1;
            }
                        
            $html.=$css->getHtmlSelect("idClasificacion", "idClasificacion", $valuesClasificacion, "Clasificacion", "", "style=width:100%;"); 
            $html.="";
            $html.='<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-'.$Cols.'-desktop">';
            $html.=$css->getHtmlInput("text", "Referencia", "Referencia", $Referencia, "Referencia", "", "", "", 1);
            $html.="</div>";
            $html.='<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-'.$Cols.'-desktop">';
            $html.=$css->getHtmlInput("text", "Nombre", "Nombre", $DatosActuales["Nombre"], "Nombre", "", "", "", 1);
            $html.="</div>";
            $html.='<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-'.$Cols.'-desktop">';
            $html.=$css->getHtmlInput("text", "PrecioVenta", "PrecioVenta", $DatosActuales["PrecioVenta"], "Precio de Venta", "", "", "", 1);
            $html.="</div>";
            $html.='<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-'.$Cols.'-desktop">';
            $html.=$css->getHtmlInput("textarea", "DescripcionCorta", "DescripcionCorta", $DatosActuales["DescripcionCorta"], "Descripcion Corta", "", "", "", 1);
            $html.="</div>";
            $html.='<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-'.$Cols.'-desktop">';
            $html.=$css->getHtmlInput("textarea", "DescripcionLarga", "DescripcionLarga", $DatosActuales["DescripcionLarga"], "Descripcion Larga", "", "", "", 1);
            $html.="</div>";
            $html.='<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-'.$Cols.'-desktop">';
            $Orden=$DatosActuales["Orden"];
            if($DatosActuales["Orden"]==""){
                $Orden=1;
            }
            $html.=$css->getHtmlInput("number", "Orden", "Orden", $Orden, "Orden", "", "", "", 1);
            $html.="</div>";
            $html.='<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-'.$Cols.'-desktop">';
            $html.=$css->getHtmlInput("file", "ImagenProducto", "ImagenProducto", "", "Imagen", "", "", "", 1);
            $html.="</div>";
            $html.='<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-'.$Cols.'-desktop">';
            $values["values"][0]="1";
            $values["text"][0]="Activado";
            $values["values"][1]="0";
            $values["text"][1]="Deshabilitado";
            if($DatosActuales["Estado"]==1 or $DatosActuales["Estado"]==''){
                $values["sel"][0]="1";
            }
            if($DatosActuales["Estado"]==0 and $DatosActuales["Estado"]<>''){
                $values["sel"][1]="1";
            }
            $html.=$css->getHtmlSelect("Estado", "Estado", $values, "Estado", "", "style=width:100%;");            
            $html.="</div><br>";
            
            $html.='<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-'.$Cols.'-desktop">';
            $html.=$css->getHtmlBoton(1, "BtnGuardarEditar", "BtnGuardarEditar", "Guardar", "onclick=ConfirmaGuardarEditar(`2`,`$idItem`)", "width:100px;");
            $html.="</div>";
            $html.="</div></div></div>";
            print($html);
            
        break;//Fin caso 7
        
        case 8://Dibujo el listado de los locales
            $Limit=20;
            $idLocal=$obCon->normalizar($_SESSION["idLocal"]);            
            $DatosLocal=$obCon->DevuelveValores("locales", "ID", $idLocal);            
            $Page=$obCon->normalizar($_REQUEST["Page"]);
            $Busqueda=$obCon->normalizar($_REQUEST["Busqueda"]);
            if($Page==''){
                $Page=1;
                
            }
            $Condicion=" WHERE ID>0 ";
            
            if($Busqueda<>''){
                $Condicion.=" AND ( ID='$Busqueda' or Nombre like '%$Busqueda%' or Telefono like '%$Busqueda%'  )";
            }
            
            $PuntoInicio = ($Page * $Limit) - $Limit;
            
            $sql = "SELECT COUNT(t1.ID) as Items 
                   FROM locales t1 $Condicion;";
            
            $Consulta2=$obCon->QueryExterno($sql, HOST, USER, PW, DB, "");
            $totales = $obCon->FetchAssoc($Consulta2);
            $ResultadosTotales = $totales['Items'];
            
            if($ResultadosTotales>$Limit){
                $TotalPaginas= ceil($ResultadosTotales/$Limit);
                if($Page>1){
                    $js="onclick=pageMinusAdmin();";
                    $css->botonNavegacion($js, "green", "pageNav-pageBack-icon mdi mdi-arrow-left-bold", "PageMinus");
                }
                if($ResultadosTotales>($PuntoInicio+$Limit)){
                    $js="onclick=pageAddAdmin();";
                    $css->botonNavegacion($js, "green", "pageNav-pageForward-icon mdi mdi-arrow-right-bold", "PageAdd");
                }
            }
            
            $sql="SELECT ID, Nombre,Direccion,Telefono,Email, Estado FROM locales $Condicion ORDER BY ID DESC LIMIT $PuntoInicio,$Limit;";
            $Consulta=$obCon->QueryExterno($sql, HOST, USER, PW, DB, "");
            $i=0;
            $Filas[]="";
            while($DatosClasificacion=$obCon->FetchAssoc($Consulta)){
                $Filas[$i]=$DatosClasificacion;
                $i=$i+1;
            }
            $z=0;
            $js="onclick=FormularioAgregarEditar(`3`)";
            $Columnas[$z++]="<strong>Editar</strong>";
            $Columnas[$z++]="<strong>ID</strong>";
            $Columnas[$z++]="<strong>Nombre</strong>";
            $Columnas[$z++]="<strong>Direccion</strong>";
            $Columnas[$z++]="<strong>Telefono</strong>";
            $Columnas[$z++]="<strong>Email</strong>";
            $Columnas[$z++]="<strong>Estado</strong>";
            $Acciones["ID"]["js"]="onclick=FormularioAgregarEditar(`3`,`@value`)";
            $Acciones["ID"]["icon"]="mdi mdi-database-edit";
            $Acciones["ID"]["style"]="style=font-size:20px;color:blue;cursor:pointer";
            $htmlTabla=$css->getHtmlTable("<span class='mdi mdi-database-plus' style='font-size:40px;color:green;cursor:pointer' $js></span> <strong>LOCALES</strong>", $Columnas, $Filas,$Acciones);
            print($htmlTabla);
        break;//fin caso 8    
        
        case 9://Formulario para agregar o editar un local
            $idItem=$obCon->normalizar($_REQUEST["idItem"]);
            $Editar=0;
            if($idItem<>''){
                $Editar=1;
            }
            $tab="locales";
            $idLocal=$obCon->normalizar($_SESSION["idLocal"]);
            if($idLocal<>1){
                exit("Zona prohibida");
            }
            
            $sql="SELECT * FROM $tab WHERE ID='$idItem'";
            $DatosActuales=$obCon->FetchAssoc($obCon->QueryExterno($sql, HOST, USER, PW, DB, ""));
            $Titulo="<strong>Crear o Editar un local</strong>";
            $html='
                        <div class="mdc-card">
                          <h6 class="card-title">'.$Titulo.'</h6>
                          <div class="template-demo">
                            <div class="mdc-layout-grid__inner">';
            $Cols=6;
            
            $html.='<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-'.$Cols.'-desktop">';
            $valuesClasificacion["values"][0]="";
            $valuesClasificacion["text"][0]="Categoria";
            $sql="SELECT * FROM catalogo_categorias";
            $Consulta=$obCon->QueryExterno($sql, HOST, USER, PW, DB, "");
            $i=1;
            while($DatosConsulta=$obCon->FetchAssoc($Consulta)){
                $valuesClasificacion["values"][$i]=$DatosConsulta["ID"];
                $valuesClasificacion["text"][$i]=$DatosConsulta["Nombre"];
                if($DatosActuales["idCategoria"]==$DatosConsulta["ID"]){
                    $valuesClasificacion["sel"][$i]="1";
                }
                $i=$i+1;
            }
                        
            $html.=$css->getHtmlSelect("idCategoria", "idCategoria", $valuesClasificacion, "Categoria", "", "style=width:100%;"); 
                        
            $html.='<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-'.$Cols.'-desktop">';
            $html.=$css->getHtmlInput("text", "Nombre", "Nombre", $DatosActuales["Nombre"], "Nombre", "", "", "", 1);
            $html.="</div>";
            $html.='<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-'.$Cols.'-desktop">';
            $html.=$css->getHtmlInput("text", "Direccion", "Direccion", $DatosActuales["Direccion"], "Direccion", "", "", "", 1);
            $html.="</div>";            
            $html.='<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-'.$Cols.'-desktop">';
            $html.=$css->getHtmlInput("text", "Telefono", "Telefono", $DatosActuales["Telefono"], "Telefono", "", "", "", 1);
            $html.="</div>";
            $html.='<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-'.$Cols.'-desktop">';
            $html.=$css->getHtmlInput("text", "Propietario", "Propietario", $DatosActuales["Propietario"], "Propietario", "", "", "", 1);
            $html.="</div>";
            $html.='<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-'.$Cols.'-desktop">';
            $html.=$css->getHtmlInput("number", "Tarifa", "Tarifa", $DatosActuales["Tarifa"], "Tarifa", "", "", "", 1);
            $html.="</div>";
            $html.='<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-'.$Cols.'-desktop">';
            $html.=$css->getHtmlInput("email", "Email", "Email", $DatosActuales["Email"], "Email", "", "", "", 1);
            $html.="</div>";     
            $html.='<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-'.$Cols.'-desktop">';
            $html.=$css->getHtmlInput("password", "Password", "Password", $DatosActuales["Password"], "Password", "", "", "", 1);
            $html.="</div>";     
            $html.='<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-'.$Cols.'-desktop">';
            $html.=$css->getHtmlInput("textarea", "Descripcion", "Descripcion", $DatosActuales["Descripcion"], "Descripcion", "", "", "", 1);
            $html.="</div>";
            
            $html.='<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-'.$Cols.'-desktop">';
            $Orden=$DatosActuales["Orden"];
            if($DatosActuales["Orden"]==""){
                $Orden=1;
            }
            $html.=$css->getHtmlInput("number", "Orden", "Orden", $Orden, "Orden", "", "", "", 1);
            $html.="</div>";
            $html.='<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-'.$Cols.'-desktop">';
            $html.=$css->getHtmlInput("file", "Fondo", "Fondo", "", "Imagen", "", "", "", 1);
            $html.="</div>";
            $html.='<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-'.$Cols.'-desktop">';
            $values["values"][0]="1";
            $values["text"][0]="Activado";
            $values["values"][1]="0";
            $values["text"][1]="Deshabilitado";
            if($DatosActuales["Estado"]==1 or $DatosActuales["Estado"]==''){
                $values["sel"][0]="1";
            }
            if($DatosActuales["Estado"]==0 and $DatosActuales["Estado"]<>''){
                $values["sel"][1]="1";
            }
            $html.=$css->getHtmlSelect("Estado", "Estado", $values, "Estado", "", "style=width:100%;");            
            $html.="</div><br>";
            
            $html.='<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-'.$Cols.'-desktop">';
            $html.=$css->getHtmlBoton(1, "BtnGuardarEditar", "BtnGuardarEditar", "Guardar", "onclick=ConfirmaGuardarEditar(`3`,`$idItem`)", "width:100px;");
            
            $html.="</div>";
            $html.="</div></div></div>";
            print($html);
            
        break;//Fin caso 9
        
        case 10://listado de imagenes de los productos
            $Limit=20;
            $idLocal=$obCon->normalizar($_SESSION["idLocal"]);
            $idProducto=$obCon->normalizar($_REQUEST["idProducto"]);            
            $DatosLocal=$obCon->DevuelveValores("locales", "ID", $idLocal);            
            $Page=$obCon->normalizar($_REQUEST["Page"]);
            $Busqueda=$obCon->normalizar($_REQUEST["Busqueda"]);
            
            if($Page==''){
                $Page=1;
                
            }
            if($idProducto==''){
                exit("No se recibió el id del producto");                
            }
            $Condicion=" WHERE idProducto='$idProducto' ";
            
            if($Busqueda<>''){
                $Condicion.=" AND (NombreArchivo like '%$Busqueda%' )";
            }
            
            $PuntoInicio = ($Page * $Limit) - $Limit;
            
            $sql = "SELECT COUNT(t1.ID) as Items 
                   FROM productos_servicios_imagenes t1 $Condicion;";
            
            $Consulta2=$obCon->QueryExterno($sql, HOST, USER, PW, $DatosLocal["db"], "");
            $totales = $obCon->FetchAssoc($Consulta2);
            $ResultadosTotales = $totales['Items'];
            
            if($ResultadosTotales>$Limit){
                $TotalPaginas= ceil($ResultadosTotales/$Limit);
                if($Page>1){
                    $js="onclick=pageMinusAdmin();";
                    $css->botonNavegacion($js, "green", "pageNav-pageBack-icon mdi mdi-arrow-left-bold", "PageMinus");
                }
                if($ResultadosTotales>($PuntoInicio+$Limit)){
                    $js="onclick=pageAddAdmin();";
                    $css->botonNavegacion($js, "green", "pageNav-pageForward-icon mdi mdi-arrow-right-bold", "PageAdd");
                }
            }
            
            $sql="SELECT ID,Ruta, NombreArchivo,Tamano FROM productos_servicios_imagenes $Condicion ORDER BY ID DESC LIMIT $PuntoInicio,$Limit;";
            $Consulta=$obCon->QueryExterno($sql, HOST, USER, PW, $DatosLocal["db"], "");
            $i=0;
            $Filas[]="";
            while($DatosClasificacion=$obCon->FetchAssoc($Consulta)){
                $DatosClasificacion["Ruta"]= str_replace("../", "", $DatosClasificacion["Ruta"]);
                $DatosClasificacion["Ruta"]="../../".$DatosClasificacion["Ruta"];
                $Filas[$i]=$DatosClasificacion;
                $i=$i+1;
            }
            $z=0;
            $Titulo="IMAGENES";
            $js="onclick=FormularioAgregarEditar(`2`)";
            $Columnas[$z++]="<strong>Eliminar</strong>";
           // $Columnas[$z++]="<strong>ID</strong>";
            $Columnas[$z++]="<strong>Imagen</strong>";
            $Columnas[$z++]="<strong>Nombre</strong>";
            $Columnas[$z++]="<strong>Tamaño</strong>";
            
            $Acciones["ID"]["Visible"]=0;
            $Acciones["Ruta"]["Visible"]=0;
            //$Acciones["ID"]["js"]="onclick=FormularioAgregarEditar(`2`,`@value`)";
            //$Acciones["ID"]["icon"]="mdi mdi-database-edit";
            //$Acciones["ID"]["style"]="style=font-size:20px;color:blue;cursor:pointer";
            $htmlInputFile=$css->getHtmlInput("file", "imgProducto", "imgProducto", "", "Imagen");
            $htmlInputFile.="<br><br>".$css->getHtmlBoton(3, "btnSubir", "Subir", "Guardar", "onclick=ConfirmaGuardarEditar(`4`,`$idProducto`)");
            $Acciones["ID"]["html"]='<span class="mdi mdi-database-remove" style="font-size:40px;color:red;cursor:pointer" onclick=EliminarFotoProducto(`@ID`)></span>';
            $Acciones["Ruta"]["html"]='<a href="@value" target="_blank"><img src="@value" style="width:200px;"><img></a>';
            $htmlTabla=$css->getHtmlTable("<strong>$Titulo</strong> <br><br>$htmlInputFile", $Columnas, $Filas,$Acciones);
            print($htmlTabla);
        break;//fin caso 10    
        
 }      
    
          
}else{
    print("No se enviaron parametros");
}
?>