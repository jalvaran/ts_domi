<?php
include_once 'html_estruct_class.php';
if(file_exists('../../modelo/php_conexion.php')){
    include_once '../../modelo/php_conexion.php';
}
/**
 * Description of pages_construct Clase para generar paginas
 *
 * @author Julian Andres Alvaran
 */	

class PageConstruct extends html_estruct_class{
    /**
     * Constructor
     * @param type $Titulo ->Titulo de la pagina
     * @param type $ng_app ->Se define si se desea ingresar un modulo del framework angular
     * @param type $Vector -> uso futuro
     */
    function __construct($Titulo,$Inicializar=1){
        if($Inicializar==1){
            $this->tipo_html();
            $this->html("es","","");
            $this->head();
                print('<meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <meta http-equiv="X-UA-Compatible" content="ie=edge">
                        <title>DomiBuga</title>
                        <!-- plugins:css -->
                        <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
                        <link rel="stylesheet" href="../../assets/vendors/mdi/css/materialdesignicons.min.css">                        
                        <link rel="stylesheet" href="../../assets/vendors/css/vendor.bundle.base.css">
                        
                        <!-- endinject -->
                        <!-- Plugin css for this page -->
                        <link rel="stylesheet" href="../../assets/vendors/flag-icon-css/css/flag-icon.min.css">
                        <link rel="stylesheet" href="../../assets/vendors/jvectormap/jquery-jvectormap.css">
                        <link rel="stylesheet" href="../../assets/alertify/themes/alertify.core.css" />
                        <link rel="stylesheet" href="../../assets/alertify/themes/alertify.default.css" id="toggleCSS" />
                        <!-- End plugin css for this page -->
                        <!-- Layout styles -->
                        <link rel="stylesheet" href="../../assets/css/demo/style.css">
                        <link rel="stylesheet" href="../../assets/css/techno/carrito.css">
                        <link rel="stylesheet" href="../../assets/css/techno/navegacion_techno.css">
                        
                        <!-- End layout styles -->
                        <link rel="shortcut icon" href="../../assets/images/favicon.png" />');
            $this->Chead();
            $this->body("", "");
                print('<script src="../../assets/js/preloader.js"></script>');
                print('<script src="https://www.google.com/recaptcha/api.js?render=6LdoC-gUAAAAADi7iGr_b8WtxMijj24V8v-dAtB-"></script>');
                
                print('<div class="body-wrapper">');
            //$this->CrearDiv("", "body-wrapper", "", 1, 1);
        }
    }   
    
    /**
     * Inicio de la cabecera
     * @param type $Title
     */
    function BarraLateralIni($Title,$Link="#",$js="",$Logo="logoTechno.png"){
        
        print('
            <aside class="mdc-drawer mdc-drawer--dismissible mdc-drawer--open">
                <div class="mdc-drawer__header">
                  <a href="#" class="brand-logo">
                    <img src="../../LogosEmpresas/'.$Logo.'" alt="logo" style="height:80px;width:200px;">
                  </a>
                </div>
                <div class="mdc-drawer__content">
                  <div class="user-info">
                    <p class="name">Domi Buga</p>
                    <p class="email">info@domibuga.com</p>
                            <p class="email">317 7740609</p>
                  </div>
                  <div class="mdc-list-group">
                    <nav class="mdc-list mdc-drawer-menu">
                      

                    
            
        ');
    }
    
    public function MenuLateral($Nombre,$Ruta,$js) {
        print('<div class="mdc-list-item mdc-drawer-item">
                <a class="mdc-drawer-link" '.$js.'>
                  <i class="material-icons mdc-list-item__start-detail mdi mdi-login-variant" aria-hidden="true"> </i>
                  '.$Nombre.'
                </a>
              </div>');
    }
    public function BarraLateralFin() {
        print('</nav>
                  </div>
                  <div class="profile-actions">

                    <span class="divider"></span>
                    <a href="#" onclick=TerminarSesion();>Salir</a>
                  </div>

                </div>
              </aside>');
    }
    public function MainWraper() {
        print('<div class="main-wrapper mdc-drawer-app-content">');   
    }
    public function Cabecera($Titulo,$Busqueda=0) {
        print('<header class="mdc-top-app-bar">
        <div class="mdc-top-app-bar__row">
          <div class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
            <button class="material-icons mdc-top-app-bar__navigation-icon mdc-icon-button sidebar-toggler">menu</button>
            <span class="mdc-top-app-bar__title">'.$Titulo.'</span>
            <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon search-text-field  d-md-flex">
              <i class="material-icons mdc-text-field__icon">b</i>
              <input class="mdc-text-field__input" id="BusquedaLocal" onchange=BuscarLocal()>
              <div class="mdc-notched-outline">
                <div class="mdc-notched-outline__leading"></div>
                <div class="mdc-notched-outline__notch">
                  <label for="text-field-hero-input" class="mdc-floating-label">Buscar Local..</label>
                </div>
                <div class="mdc-notched-outline__trailing"></div>
              </div>
            </div>
          </div>
          <div class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end mdc-top-app-bar__section-right">
            
          <div class="menu-button-container">
              <button class="mdc-button mdc-menu-button" onclick=ListarCategoria()>
                
              </button>
          </div>

            <div class="divider d-none d-md-block"></div>
            
            
            
            <div class="menu-button-container">
              <button class="mdc-button mdc-menu-button">
                
              </button>
              <div class="mdc-menu mdc-menu-surface" tabindex="-1">
                <ul class="mdc-list" role="menu" aria-hidden="true" aria-orientation="vertical">
                  <li class="mdc-list-item" role="menuitem">
                    <div class="item-thumbnail item-thumbnail-icon-only">
                      <i class="mdi mdi-lock-outline text-primary"></i>
                    </div>
                    <div class="item-content d-flex align-items-start flex-column justify-content-center">
                      <h6 class="item-subject font-weight-normal">Iniciar sesion</h6>
                    </div>
                  </li>
                  <li class="mdc-list-item" role="menuitem">
                    <div class="item-thumbnail item-thumbnail-icon-only">
                      <i class="mdi mdi-logout-variant text-primary"></i>                      
                    </div>
                    <div class="item-content d-flex align-items-start flex-column justify-content-center">
                      <h6 class="item-subject font-weight-normal">Salir</h6>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </header>');
    }
    
    public function ContentInit() {
        print('<div class="page-wrapper mdc-toolbar-fixed-adjust">
                <main class="content-wrapper">
                  <div class="mdc-layout-grid">
                    <div id="divMain" class="mdc-layout-grid__inner">');
    }
    
    /**
     * Inicia todos los elementos de la pagina en general
     * @param type $myTitulo
     */
    public function PageInit($myTitulo) {
        //$NombreUsuario= utf8_encode($_SESSION["nombre"]);
        //$idUser=$_SESSION["idUser"];
        $this->BarraLateralIni($myTitulo,"",""); 
            $this->MenuLateral(" Administrar ", "index.php", "onclick=FormularioIniciarSesion();");
        $this->BarraLateralFin();    
        $this->MainWraper();
            $this->Cabecera($myTitulo);
                $this->ContentInit();
    }
    
    public function ContentEnd() {
        print('</div>
          </div>
        </main>');
    }
    
    public function PageFooter() {
        print('<footer>
          <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
              <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                <span class="tx-14">Copyright © 2020 <a href="https://www.technosoluciones.com.co/" target="_blank">TECHNO SOLUCIONES SAS</a>. All rights reserved.</span>
              </div>
              <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop d-flex justify-content-end">
                
              </div>
            </div>
          </div>
        </footer>');
    }
    
    public function WrapperEnd() {
        print('</div>
            </div>
          </div>');
    }
    public function AgregaJS() {
        print('<script src="../../assets/vendors/js/vendor.bundle.base.js"></script>
                <!-- endinject -->
                <!-- Plugin js for this page-->
                <script src="../../assets/vendors/chartjs/Chart.min.js"></script>
                <script src="../../assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
                <script src="../../assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
                
                <script src="../../assets/js/dashboard.js"></script>
                <script src="../../assets/js/jquery.min.js"></script>
                <script src="../../assets/bootstrap/js/bootstrap.min.js"></script>
                <script src="../../assets/js/popper.min.js"></script>
                <!-- End plugin js for this page-->
                <!-- inject:js -->
                <script src="../../assets/alertify/lib/alertify.min.js"></script>
                <script src="../../assets/js/uuid.min.js"></script>
                <script src="../../assets/js/js.cookie.js"></script>
                <script src="../../assets/js/material.js"></script>
                <script src="../../general/js/formularios.js"></script>
                <script src="../../general/js/number_format.js"></script>
                <script src="../../assets/js/misc.js"></script>
                
                <!-- endinject -->
                <!-- Custom js for this page-->
                
                ');
                /*
                print("<script>
                        grecaptcha.ready(function() {
                            grecaptcha.execute('6LdoC-gUAAAAADi7iGr_b8WtxMijj24V8v-dAtB-', {action: 'homepage'}).then(function(token) {
                               
                            });
                        });
                        </script>
                        ");
                 * 
                 */
        
        
    }
    
    public function PageEnd() {
        $this->ContentEnd();
        $this->PageFooter();
        $this->WrapperEnd();
        $this->AgregaJS();
        
    }
    
    public function divCol($id,$Name,$Cols,$js,$style) {
        print('<div id="'.$id.'" class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-'.$Cols.'-desktop mdc-layout-grid__cell--span-12-tablet">');
    }
    
    public function divCard($id,$Title,$Content,$Footer,$icon,$ColorIcon,$js="",$style="",$jsIcon="",$styleIcon=""){
        
        
        
        print('<div id="'.$id.'" class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-3-tablet" '.$js.' '.$style.'>
                <div class="mdc-card info-card info-card--'.$ColorIcon.'">
                  <div class="card-inner">
                    <h5 class="card-title">'.$Title.'</h5>
                    <h5 class="font-weight-light pb-2 mb-1 border-bottom">'.$Content.'</h5>
                    <p class="tx-12 text">'.$Footer.'</p>
                    <div '.$jsIcon.' class="card-icon-wrapper" '.$styleIcon.'>
                      <i class="'.$icon.'"></i>
                    </div>
                  </div>
                </div>
              </div>');
    }
    
    public function divCardLocales($link,$Fondo,$Title,$Content,$Footer,$icon,$ColorIcon,$js="",$style="",$Cols=3){
        
        print('<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-'.$Cols.'-desktop mdc-layout-grid__cell--span-'.$Cols.'-tablet" '.$js.' '.$style.'>
                <div class="mdc-card info-card info-card--'.$ColorIcon.'">
                  <div class="card-inner" style="background-image:url('.$Fondo.');background-repeat: no-repeat;background-size: 300px 90%;">
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                  </div>
                  <div class="card-inner">
                    <h5 class="card-title">'.$Title.'</h5>
                    <h5 class="font-weight-light pb-2 mb-1 border-bottom">'.$Content.'</h5>
                    <p class="tx-12 text" style="font-size:16px;color:black"><strong>'.$Footer.'</strong></p>
                    '.$link.'     
                    <div class="card-icon-wrapper">
                      <i class="'.$icon.'"></i>
                    </div>
                  </div>
                </div>
              </div>');
    }
    
    public function divForm($Title,$Content,$js="",$style="",$Cols=6,$ColorIcon="info",$styleTitle=""){
        
        print('<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-'.$Cols.'-desktop mdc-layout-grid__cell--span-'.$Cols.'-tablet" '.$js.' '.$style.'>
                <div class="mdc-card info-card info-card--'.$ColorIcon.'">
                  <div class="card-inner">
                    <h3 class="" '.$styleTitle.' >'.$Title.'</h3>
                    '.$Content.'                    
                  </div>
                </div>
              </div>');
    }
    
    public function getHtmlSelect($id,$name,$values,$placeholder,$js,$style) {
        $html='<div class="mdc-select demo-width-class" data-mdc-auto-init="MDCSelect" '.$style.' >
                      <input id="'.$id.'" type="hidden" name="'.$name.'" '.$js.'>
                      <i class="mdc-select__dropdown-icon" ></i>
                      <div class="mdc-select__selected-text" ></div>
                      <div class="mdc-select__menu mdc-menu-surface demo-width-class">
                        <ul class="mdc-list" >';
        foreach ($values["values"] as $key => $value){
            $sel="false";
            $selected="";
            if(isset($values["sel"][$key])){
                $sel="true";
                $selected="--selected";
            }
            $html.='<li class="mdc-list-item mdc-list-item'.$selected.'" data-value="'.$value.'" aria-selected="'.$sel.'">';
                $html.= ($values["text"][$key]);
            $html.='</li>';
        }
        $html.='</ul>
                      </div>
                      <span class="mdc-floating-label">'.$placeholder.'</span>
                      <div class="mdc-line-ripple"></div>
                    </div>
                  </div>';
        return($html);
    }
    
    public function getHtmlSelectBootstrap($id,$name,$values,$placeholder,$js,$style) {
        $html='
                      <select id="'.$id.'" name="'.$name.'" class="form-control" '.$js.' '.$style.'>
                      ';
        foreach ($values["values"] as $key => $value){
            $sel="false";
            $selected="";
            if(isset($values["sel"][$key])){
                $sel="true";
                $selected=" selected = $sel ";
            }
            $html.='<option value="'.$value.'" '.$selected.'">';
                $html.= ($values["text"][$key]);
            $html.='</option>';
        }
        $html.='</select>';
        return($html);
    }
    
    public function getHtmlInput($type,$id,$name,$value,$placeholder,$js="",$style="",$icon='',$iconPostion=1,$Habilitado=1) {
        if($iconPostion==1){
            $iconPostion="trailing";
            
        }else{
            $iconPostion="leading";
        }
        $disabled="";
        if($Habilitado==0){
           $disabled="disabled"; 
        }
        if($type<>"textarea"){
            $html='<div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-'.$iconPostion.'-icon" '.$style.'>
                    <i class="material-icons mdc-text-field__icon">'.$icon.'</i>
                    <input type="'.$type.'" id="'.$id.'" name="'.$name.'" value="'.$value.'" class="mdc-text-field__input" '.$js.' '.$disabled.'>
                    <div class="mdc-notched-outline mdc-notched-outline--upgraded">
                      <div class="mdc-notched-outline__leading"></div>
                      <div class="mdc-notched-outline__notch" style="">
                        <label for="text-field-hero-input" class="mdc-floating-label" style="">'.$placeholder.'</label>
                      </div>
                      <div class="mdc-notched-outline__trailing"></div>
                    </div>
                  </div>';
        } 
        
        if($type=="textarea"){
            
            $html='
                   <textarea id="'.$id.'" name="'.$name.'" class="form-control" placeholder="'.$placeholder.'" '.$disabled.' '.$style.'>'.$value.'</textarea>';
        }
        
        return($html);
    }
    
    public function ProgressBar($NombreBarra,$NombreLeyenda,$Tipo,$Valor,$Min,$Max,$Ancho,$Leyenda,$Color,$Vector) {
        print('<div class="progress">
                <div id="'.$NombreBarra.'" name="'.$NombreBarra.'" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="'.$Valor.'" aria-valuemin="'.$Min.'" aria-valuemax="'.$Max.'" style="width:'.$Ancho.'%">
                  <div id="'.$NombreLeyenda.'" name="'.$NombreLeyenda.'"">'.$Leyenda.'</div>
                </div>
              </div>');
    }
    
    public function getHtmlBoton($type,$id,$name,$value,$js,$moreStyles="") {
        $moreClass="";
        $Color="";
        if($type==1){
            $Color="--mdc-ripple-fg-size:57px; --mdc-ripple-fg-scale:1.9678808653005644; --mdc-ripple-fg-translate-start:27.5px, -8.5px; --mdc-ripple-fg-translate-end:19.308334350585938px, -10.5px";
            
        }
        if($type==2){
            $Color="--mdc-ripple-fg-size:65px; --mdc-ripple-fg-scale:1.9291179361344377; --mdc-ripple-fg-translate-start:39.5px, -22.5px; --mdc-ripple-fg-translate-end:22.316665649414062px, -14.5px;";
            $moreClass="filled-button--secondary";            
        }
        if($type==3){
            $Color="--mdc-ripple-fg-size:65px; --mdc-ripple-fg-scale:1.9291179361344377; --mdc-ripple-fg-translate-start:39.5px, -22.5px; --mdc-ripple-fg-translate-end:22.316665649414062px, -14.5px;";
            $moreClass="filled-button--success";            
        }
        if($type==4){
            $Color="--mdc-ripple-fg-size:65px; --mdc-ripple-fg-scale:1.9291179361344377; --mdc-ripple-fg-translate-start:39.5px, -22.5px; --mdc-ripple-fg-translate-end:22.316665649414062px, -14.5px;";
            $moreClass="filled-button--warning";            
        }
        if($type==5){
            $Color="--mdc-ripple-fg-size:65px; --mdc-ripple-fg-scale:1.9291179361344377; --mdc-ripple-fg-translate-start:39.5px, -22.5px; --mdc-ripple-fg-translate-end:22.316665649414062px, -14.5px;";
            $moreClass="filled-button--dark";            
        }
        if($type==6){
            $Color="--mdc-ripple-fg-size:65px; --mdc-ripple-fg-scale:1.9291179361344377; --mdc-ripple-fg-translate-start:39.5px, -22.5px; --mdc-ripple-fg-translate-end:22.316665649414062px, -14.5px;";
            $moreClass="filled-button--info";            
        }
        if($type==7){
            $Color="--mdc-ripple-fg-size:65px; --mdc-ripple-fg-scale:1.9291179361344377; --mdc-ripple-fg-translate-start:39.5px, -22.5px; --mdc-ripple-fg-translate-end:22.316665649414062px, -14.5px;";
            $moreClass="filled-button--light";            
        }
        $html='<button id="'.$id.'" name="'.$name.'"  '.$js.' class="mdc-button mdc-button--raised '.$moreClass.' mdc-ripple-upgraded" style="'.$Color.';width:100%;'.$moreStyles.'">
                '.$value.'
              </button>';
        return($html);
    }
    
    function getHtmlInfoProducto($idClientUser,$idLocal,$idProducto,$NombreProducto,$Descripcion,$RutaImagen,$PrecioVenta) {
        $col=4;
        
        $style="style='width:130%;'";
        $html='<div class="col-md-12">';
            $html.='<a href="javascript:void(0)" onclick=MostrarGaleriaProducto(`'.$idLocal.'`,`'.$idProducto.'`)><img src="'.$RutaImagen.'" style="width:200px;height:150px;"></img></a>';
        $html.='</div>';
        $html.='</br>';
        $html.='<div class="col-md-12">';
            $html.='<input id="PrecioVenta_'.$idProducto.'" type="hidden" value='.$PrecioVenta.'>';
            $html.="<strong>Precio:</strong><h3 style='color:#0b00b9'>$". number_format($PrecioVenta)."</h3>";
        $html.='</div><hr>';

        $html.='<div class="col-md-12" style="text-align: justify;">';
            $html.=($Descripcion);
        $html.='</div>';

        $html.='</br>';
        $html.='<div class="col-md-12">';
            $style="style='width:130%;height:30px;'";
            $html.=$this->getHtmlInput("textarea","Observaciones_".$idProducto, "Observaciones", "", "Observaciones",'',$style,"",1);
        $html.='</div>';
        $html.='</br>';
        $html.='<div class="col-md-12">';    
        $ancho="width:130%;";
        $html.=$this->getHtmlBoton(1, "btnCarAdd_".$idProducto, "btnAgregar", "Agregar al Carrito", "onclick=AgregarAlCarrito(`$idClientUser`,`$idLocal`,`$idProducto`)", $ancho);
        $html.='</div>';
        
        return($html);
        
    }
    
    public function ShoppingCar($js,$id="aShoppingCAr",$idSp="spItemsCar",$idSpTotal="spTotalCar",$Color="#d91d1d") {
        print('<a id="'.$id.'" class="cart-icon mdi mdi-cart" '.$js.' style="color:'.$Color.';">        
            <span class="cart-icon-sp" id="'.$idSp.'">0</span> 
            <span class="cart-icon-sp-total" id="'.$idSpTotal.'">0</span>     
        </a>');
    }
    
    public function miniChat($js,$id="aShoppingCAr",$idSp="spItemsCar",$idSpTotal="spTotalCar",$Color="#3fd21b") {
        print('<a id="'.$id.'" class="chat-icon mdi mdi-chat" '.$js.' style="color:'.$Color.';">        
            <span class="chat-icon-sp" id="'.$idSp.'">0</span> 
                
        </a>');
    }
    
    public function botonNavegacion($js,$Color,$class,$id="") {
        print('<a id="'.$id.'" class="'.$class.'" '.$js.' style="color:'.$Color.';">             
        </a>');
    }
    
    public function modal($id,$Titulo,$idDivContent,$Tipo=2) {
        $ClassLarge="";
        if($Tipo==1){
            $ClassLarge="modal-sm";
        }
        if($Tipo==2){
            $ClassLarge="modal-lg";
        }
        if($Tipo==3){
            $ClassLarge="modal-xl";
        }
        print('<div class="modal fade" id="'.$id.'">
                    <div class="modal-dialog modal-dialog-scrollable '.$ClassLarge.'">
                      <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                          <h1 class="modal-title">'.$Titulo.'</h1>
                          <button type="button" class="close" data-dismiss="modal">×</button>
                        </div>

                        <!-- Modal body -->
                        <div id='.$idDivContent.' class="modal-body" >
                          
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>

                      </div>
                    </div>
                  </div>');
    }
    
    public function modalMDD($id,$Titulo,$idDivContent,$Tipo=2) {
        $ClassLarge="";
        if($Tipo==1){
            $ClassLarge="modal-sm";
        }
        if($Tipo==2){
            $ClassLarge="modal-lg";
        }
        if($Tipo==3){
            $ClassLarge="modal-xl";
        }
        print('<div class="modal fade" id="'.$id.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-2">
		<div class="modal-dialog modal-dialog modal-dialog-scrollable '.$ClassLarge.'" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel-2">'.$Titulo.'</h4>
				</div>

				<div id="'.$idDivContent.'" class="modal-body" >
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec in ligula id sem tristique ultrices eget id neque. Duis enim turpis, tempus at accumsan vitae, lobortis id sapien. Pellentesque nec orci mi, in pharetra ligula. Nulla facilisi. Nulla facilisi. Mauris convallis venenatis massa, quis consectetur felis ornare quis. Sed aliquet nunc ac ante molestie ultricies. Nam pulvinar ultricies bibendum.</p>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-dialog" data-dismiss="modal">Cerrar</button>
					
				</div>
                                
			</div><!-- modal-content -->
		</div><!-- modal-dialog -->
	</div><!-- modal -->');
        
    }
    
    function getHtmlTable($Titulo,$Columnas,$Filas,$Acciones=""){
        $html='<div class="mdc-card p-0">
                  <h6 class="card-title card-padding pb-0">'.$Titulo.'</h6>
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>';
        
        foreach ($Columnas as $key => $value) {
            $html.='<th class="text-left">'.$value.'</th>';
        }
        
        $html.='</tr>
                </thead>
                      <tbody>
                ';
        if(is_array($Filas[0])){
            foreach ($Filas as $DatosItems) {
                $html.='<tr >';
                foreach ($DatosItems as $key => $value) {
                    
                    if(isset($Acciones[$key]["js"])){
                        $jsIcon= str_replace("@value", $value, $Acciones[$key]["js"]);
                        $html.='<td class="text-left"><span class="'.$Acciones[$key]["icon"].'" '.$Acciones[$key]["style"].' '.$jsIcon.'></span></td>';
                    }
                    if(isset($Acciones[$key]["html"])){
                        $htmlCol= str_replace("@value", $value, $Acciones[$key]["html"]);
                        $htmlCol= str_replace("@ID", $DatosItems["ID"], $htmlCol);
                        $html.='<td class="text-left">'.$htmlCol.'</td>';
                    }
                    if(isset($Acciones[$key]["Visible"]) AND $Acciones[$key]["Visible"]==0){
                        continue;
                    }
                    $html.='<td class="text-left">'.$value.'</td>';
                    
                    
                   


                }
                $html.='</tr>';
            }
        }
        $html.='</tbody>
                    </table>
                  </div>
                </div>
                ';
        
        return($html);
    }
    
    public function CrearTitulo($Titulo,$Tipo=1) {
        $Color="success";
        if($Tipo==1){
            $Color="success";
        }
        if($Tipo==2){
            $Color="info";
        }
        if($Tipo==3){
            $Color="warning";
        }
        if($Tipo==4){
            $Color="danger";
        }
        if($Tipo==5){
            $Color="primary";
        }
        if($Tipo==6){
            $Color="secondary";
        }
        if($Tipo==7){
            $Color="dark";
        }
        if($Tipo==8){
            $Color="light";
        }
        print('<div class="alert alert-'.$Color.' mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12-desktop mdc-layout-grid__cell--span-12-tablet">
            '.$Titulo.'
          </div>');
    }
    
    public function CrearTabla($id="",$type=1){
            $class="table table-bordered table table-hover";
            if($type==2){
                $class="table table-striped";
            }
            if($type==3){
                $class="table table-bordered";
            }
            if($id<>''){
                $id="id=".$id;
            }
            return('<div  class="table-responsive"><table '.$id.'  class="'.$class.'" >');		
	}
    
        public function HeadTable() {
            return('<thead>');
        }
        public function CheadTable() {
            return('</thead>');
        }
        
        /**
         * Fila tabla
         * @param type $FontSize
         */
	function FilaTabla($FontSize,$styles=''){
            
            
            return('<tr class="odd gradeX" style="font-size:'.$FontSize.'px;'.$styles.'">');
		
	}
	/**
         * Cierra una Fila de una tabla
         */
	function CierraFilaTabla(){
            return('</tr>');
		
	}
	
	/**
         * Columna de una tabla
         * @param type $Contenido
         * @param type $ColSpan
         * @param type $align-> alineacion: L izquierda, R Derecha, C centro
         */
	function ColTabla($Contenido,$ColSpan,$align="L",$moreStyles="",$th=0){
            $Etiqueta="td";
            if($th==1){
                $Etiqueta="th";
            }
            if($align=="L"){
              $align="left";  
            }
            if($align=="R"){
              $align="right";  
            }
            if($align=="C"){
              $align="center";  
            }
            return('<'.$Etiqueta.' colspan="'.$ColSpan.' " style="text-align:'.$align.';'.$moreStyles.'"   >'.$Contenido.'</'.$Etiqueta.'>');
		
	}
	/**
         * Cierre columna de tabla
         */
	function CierraColTabla(){
            return('</td>');		
	}
	/**
         * Cierra la tabla
         */
	function CerrarTabla(){
            return('</table></div>');		
	}
    
   //Fin Clases
}
	
	

?>