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
                    
            $html=$css->getHtmlBoton(1, "MnuClasificacion", "MnuClasificacion", "Clasificación", "onclick=adminClasificacion();Page=1;", "width:150px;");
            $html.=" &nbsp;".$css->getHtmlBoton(2, "MnuProductos", "MnuProductos", "Productos", "onclick=adminProductos();Page=1;", "width:150px;");
            $html.=" &nbsp;".$css->getHtmlBoton(5, "MnuPedidos", "MnuPedidos", "Pedidos", "onclick=adminPedidos();Page=1;", "width:150px;");
            $html.='<input id="BusquedaAdmin" class="form-control" placeholder="Buscar..." onchange="VerMenuSegunID();Page=1;">';
            //$html.=" &nbsp;".$css->getHtmlInput("text", "BusquedaAdmin", "", "", "Buscar", "onchange=VerMenuSegunID()", "style=width:200px;", "", "1");
            $html.='';
            print($html);
            
            
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
            $Acciones["ID"]["js"]="onclick=FormularioAgregarEditar(`2`,`@value`)";
            $Acciones["ID"]["icon"]="mdi mdi-database-edit";
            $Acciones["ID"]["style"]="style=font-size:20px;color:blue;cursor:pointer";
            $htmlTabla=$css->getHtmlTable("<span class='mdi mdi-database-plus' style='font-size:40px;color:green;cursor:pointer' $js></span> <strong>$Titulo</strong>", $Columnas, $Filas,$Acciones);
            print($htmlTabla);
        break;//Fin canoso 4
        
        case 5://Dibuja el listado de los pedidos
            $Limit=20;
            $idLocal=$obCon->normalizar($_SESSION["idLocal"]);            
            $DatosLocal=$obCon->DevuelveValores("locales", "ID", $idLocal);            
            $Page=$obCon->normalizar($_REQUEST["Page"]);
            $Busqueda=$obCon->normalizar($_REQUEST["Busqueda"]);
            if($Page==''){
                $Page=1;
                
            }
            $Condicion=" WHERE local_id='$idLocal' ";
            
            if($Busqueda<>''){
                $Condicion.=" AND (t1.ID='$Busqueda' or t2.Nombre like '%$Busqueda%' or t2.Telefono like '$Busqueda%')";
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
            
            $sql="SELECT t1.ID,t1.Created, t2.Nombre,t2.Direccion,t2.Telefono,t1.Total,t1.Estado,
                    (SELECT EstadoPedido FROM pedidos_estados t3 WHERE t3.ID=t1.Estado LIMIT 1) as NombreEstado 
                     FROM pedidos t1 INNER JOIN client_user t2 ON t2.ID=t1.cliente_id
                     $Condicion ORDER BY ID DESC LIMIT $PuntoInicio,$Limit;";
            $Consulta=$obCon->Query($sql);
            $i=0;
            $Filas[]="";
            while($DatosClasificacion=$obCon->FetchAssoc($Consulta)){
                $Filas[$i]=$DatosClasificacion;
                $i=$i+1;
            }
            
            $z=0;
            $Titulo="PEDIDOS";
            $js="onclick=FormularioAgregarEditar(`2`)";
            $Columnas[$z++]="<strong>PDF</strong>";
            $Columnas[$z++]="<strong>Actualizar Estado</strong>";
            $Columnas[$z++]="<strong>ID</strong>";
            $Columnas[$z++]="<strong>Fecha</strong>";
            $Columnas[$z++]="<strong>Nombre</strong>";
            $Columnas[$z++]="<strong>Direccion</strong>";
            $Columnas[$z++]="<strong>Telefono</strong>";
            $Columnas[$z++]="<strong>Total</strong>";
            $Columnas[$z++]="<strong>Estado Actualizado</strong>";
            $Columnas[$z++]="<strong>Estado Anterior</strong>";
            $Ruta="../../general/Consultas/PDF_Documentos.draw.php?idDocumento=1&ID=@value";
            $values["values"][0]="";
            $values["text"][0]="Cambiar a:";
            $sql="SELECT * FROM pedidos_estados ORDER BY ID ASC";
            $Consulta=$obCon->Query($sql);
            $es=1;
            while($DatosEstados=$obCon->FetchAssoc($Consulta)){
                $values["values"][$es]=$DatosEstados["ID"];
                $values["text"][$es]=$DatosEstados["EstadoPedido"];
                $es=$es+1;
            }
            
            
            $htmlSelect=$css->getHtmlSelectBootstrap("cmbEstado_@value", "cmbEstado_@value", $values, "", "onchange=CambiarEstadoPedido(`@value`)", "style=width:200px;");
            $Acciones["ID"]["html"]='<a href="'.$Ruta.'" target="_blank"><span class="mdi mdi-file-pdf" style="font-size:30px;color:red;cursor:pointer"></span></a>';
            $Acciones["ID"]["html"].='<td>'.$htmlSelect.'</td>';
            $Acciones["Estado"]["Visible"]=0;
            $Acciones["NombreEstado"]["html"]='<span id="spEstado_@ID">@value</span>';
            //$Acciones["ID"]["icon"]="mdi mdi-file-pdf";
            //$Acciones["ID"]["style"]="style=font-size:20px;color:red;cursor:pointer";
            $htmlTabla=$css->getHtmlTable("<span class='mdi mdi-database-plus' style='font-size:40px;color:green;cursor:pointer' $js></span> <strong>$Titulo</strong>", $Columnas, $Filas,$Acciones);
            print($htmlTabla);
        break;//Fin canoso 5
    
        
 }
    
          
}else{
    print("No se enviaron parametros");
}
?>