/**
 * Controlador para la pagina principal
 * JULIAN ANDRES ALVARAN
 * 2020-04-04
 */

var idPantalla=1;
var lastLocal=1;
var lastCategory=1;
var Page=1;
var idClientUser=getIdClientUser();
function VerPantallaSegunID(){
    
    if(idPantalla==1){
        ListarCategoria();
    }
    if(idPantalla==2){
        ListarLocales(lastCategory);
    }
    if(idPantalla==3){
        DibujaLocal(lastLocal);
    }
    
    if(idPantalla==4){
        VerCarrito();
    }
}

function ListarAnterior(){
    if(idPantalla>1){
        idPantalla=parseInt(idPantalla)-1;
    }
    VerPantallaSegunID();
}

function ListarSiguiente(){
    if(idPantalla<4){
        idPantalla=parseInt(idPantalla)+1;
    }
    VerPantallaSegunID();
}

function pageMinus(){
    if(Page>1){
        Page=parseInt(Page)-1;
    }
    ListarProductos(lastLocal);
}

function pageAdd(){
    Page=parseInt(Page)+1;
    ListarProductos(lastLocal);
}

function getIdClientUser(){
    var idClientUser = Cookies.get('idClientUser');    
    if(idClientUser==undefined){        
        idClientUser=uuid.v4();
        Cookies.set('idClientUser',idClientUser,{expires: 9999});
    }
    //console.log(idClientUser);
    return(idClientUser);
    
}

function setTextareaHeight(textareas) {
    //console.log("Redimensionando text areas");
    textareas.each(function () {
        var textarea = $(this);
 
        if ( !textarea.hasClass('autoHeightDone') ) {
            textarea.addClass('autoHeightDone');
 
            var extraHeight = parseInt(textarea.css('padding-top')) + parseInt(textarea.css('padding-bottom')), // to set total height - padding size
                h = textarea[0].scrollHeight - extraHeight;
 
            // init height
            textarea.height('auto').height(h);
 
            textarea.bind('keyup', function() {
 
                textarea.removeAttr('style'); // no funciona el height auto
 
                h = textarea.get(0).scrollHeight - extraHeight;
 
                textarea.height(h+'px'); // set new height
            });
        }
    })
}


function ListarCategoria(){
    idPantalla=1;
    var idDiv="divMain";
    document.getElementById(idDiv).innerHTML='<div id="GifProcess">cargando...<br><img   src="../../images/loading.gif" alt="Cargando" height="100" width="100"></div>';
    
    var form_data = new FormData();
        form_data.append('Accion', 1);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        form_data.append('idPantalla', idPantalla);
        form_data.append('idClientUser', idClientUser);
        
       $.ajax({// se arma un objecto por medio de ajax  
        url: 'Consultas/main.draw.php',// se indica donde llegara la informacion del objecto
        
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post', // se especifica que metodo de envio se utilizara normalmente y por seguridad se utiliza el post
        success: function(data){            
            document.getElementById(idDiv).innerHTML=data; //La respuesta del servidor la dibujo en el div DivTablasBaseDatos                      
             },
        error: function (xhr, ajaxOptions, thrownError) {// si hay error se ejecuta la funcion
            document.getElementById(idDiv).innerHTML="hay un problema!";
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

function ListarLocales(Categoria=''){
    idPantalla=2;
    lastCategory=Categoria;
    var idDiv="divMain";
    document.getElementById(idDiv).innerHTML='<div id="GifProcess">cargando...<br><img   src="../../images/loading.gif" alt="Cargando" height="100" width="100"></div>';
    
    var form_data = new FormData();
        form_data.append('Accion', 2);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        form_data.append('Categoria', Categoria);
        form_data.append('idPantalla', idPantalla);
        form_data.append('idClientUser', idClientUser);
        
       $.ajax({// se arma un objecto por medio de ajax  
        url: 'Consultas/main.draw.php',// se indica donde llegara la informacion del objecto
        
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post', // se especifica que metodo de envio se utilizara normalmente y por seguridad se utiliza el post
        success: function(data){            
            document.getElementById(idDiv).innerHTML=data; //La respuesta del servidor la dibujo en el div DivTablasBaseDatos                      
             },
        error: function (xhr, ajaxOptions, thrownError) {// si hay error se ejecuta la funcion
            document.getElementById(idDiv).innerHTML="hay un problema!";
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

function DibujaLocal(idLocal=''){
    Page=1;
    idPantalla=3;
    lastLocal=idLocal;
    var idDiv="divMain";
    document.getElementById(idDiv).innerHTML='<div id="GifProcess">cargando...<br><img   src="../../images/loading.gif" alt="Cargando" height="100" width="100"></div>';
    
    var form_data = new FormData();
        form_data.append('Accion', 3);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        form_data.append('idLocal', idLocal);
        form_data.append('idPantalla', idPantalla);
        form_data.append('idClientUser', idClientUser);
        
       $.ajax({// se arma un objecto por medio de ajax  
        url: 'Consultas/main.draw.php',// se indica donde llegara la informacion del objecto
        
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post', // se especifica que metodo de envio se utilizara normalmente y por seguridad se utiliza el post
        success: function(data){            
            document.getElementById(idDiv).innerHTML=data; //La respuesta del servidor la dibujo en el div DivTablasBaseDatos                      
             
             initForm();
             ListarProductos(idLocal);
            },
        error: function (xhr, ajaxOptions, thrownError) {// si hay error se ejecuta la funcion
            document.getElementById(idDiv).innerHTML="hay un problema!";
            alert(xhr.status);
            alert(thrownError);
          }
      });
}


function ListarProductos(idLocal=''){
    
    var idDiv="DivProductos";
    document.getElementById(idDiv).innerHTML='<div id="GifProcess">cargando...<br><img   src="../../images/loading.gif" alt="Cargando" height="100" width="100"></div>';
    var cmbClasificacion = document.getElementById('cmbClasificacion').value;
    var BusquedaProducto = document.getElementById('BusquedaProducto').value;
    var form_data = new FormData();
        form_data.append('Accion', 4);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        form_data.append('idLocal', idLocal);
        form_data.append('idClientUser', idClientUser);
        form_data.append('cmbClasificacion', cmbClasificacion);
        form_data.append('BusquedaProducto', BusquedaProducto);
        form_data.append('Page', Page);
                
       $.ajax({// se arma un objecto por medio de ajax  
        url: 'Consultas/main.draw.php',// se indica donde llegara la informacion del objecto
        
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post', // se especifica que metodo de envio se utilizara normalmente y por seguridad se utiliza el post
        success: function(data){            
            document.getElementById(idDiv).innerHTML=data; //La respuesta del servidor la dibujo en el div DivTablasBaseDatos                      
             setTextareaHeight($('textarea'));
             initForm();
            },
        error: function (xhr, ajaxOptions, thrownError) {// si hay error se ejecuta la funcion
            document.getElementById(idDiv).innerHTML="hay un problema!";
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

function AgregarAlCarrito(user_id,local_id,product_id){
    
    
    var idBoton='btnCarAdd_'+product_id;
    document.getElementById(idBoton).disabled=true;
    var idObservaciones="Observaciones_"+product_id;
    var Observaciones=document.getElementById(idObservaciones).value;         
    var form_data = new FormData();
        form_data.append('Accion', '1'); 
        form_data.append('user_id', user_id);
        form_data.append('local_id', local_id);
        form_data.append('product_id', product_id);
        form_data.append('Observaciones', Observaciones);
        
        
        $.ajax({
        url: './procesadores/main.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById(idBoton).disabled=false;
            var respuestas = data.split(';'); //Armamos un vector separando los punto y coma de la cadena de texto
            if(respuestas[0]=="OK"){                
                alertify.success(respuestas[1],1000);
                document.getElementById('spItemsCar').innerHTML=respuestas[2];
                document.getElementById('spTotalCar').innerHTML=respuestas[4];
                
            }else if(respuestas[0]=="E1"){  
                alertify.error(respuestas[1]);
                MarqueErrorElemento(respuestas[2]);
                
            }else{
                alertify.alert(data);                
            }
                    
        },
        error: function (xhr, ajaxOptions, thrownError) {
            document.getElementById(idBoton).disabled=false;   
            alert(xhr.status);
            alert(thrownError);
          }
      });
    
}

function ActualizarTotalItemsCarro(user_id){
    
    var form_data = new FormData();
        form_data.append('Accion', '2'); 
        form_data.append('user_id', user_id);
                
        $.ajax({
        url: './procesadores/main.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            
            var respuestas = data.split(';'); //Armamos un vector separando los punto y coma de la cadena de texto
            if(respuestas[0]=="OK"){                
                if(respuestas[1]==''){
                    respuestas[1]=0;
                }
                document.getElementById('spItemsCar').innerHTML=respuestas[1];
                document.getElementById('spTotalCar').innerHTML=respuestas[3];
                if(document.getElementById('spTotalFormPedido')){
                    document.getElementById('spTotalFormPedido').innerHTML=respuestas[3];
                }
                
            }else if(respuestas[0]=="E1"){  
                alertify.error(respuestas[1]);
                
            }else{
                alertify.alert(data);                
            }
                    
        },
        error: function (xhr, ajaxOptions, thrownError) {
            
            alert(xhr.status);
            alert(thrownError);
          }
      });
    
}
    
function VerCarrito(){
    idPantalla=4;
    
    var idDiv="divMain";
    document.getElementById(idDiv).innerHTML='<div id="GifProcess">cargando...<br><img   src="../../images/loading.gif" alt="Cargando" height="100" width="100"></div>';
    
    var form_data = new FormData();
        form_data.append('Accion', 5);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        form_data.append('idClientUser', idClientUser);
        form_data.append('idPantalla', idPantalla);
           
       $.ajax({// se arma un objecto por medio de ajax  
        url: 'Consultas/main.draw.php',// se indica donde llegara la informacion del objecto
        
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post', // se especifica que metodo de envio se utilizara normalmente y por seguridad se utiliza el post
        success: function(data){            
            document.getElementById(idDiv).innerHTML=data; //La respuesta del servidor la dibujo en el div DivTablasBaseDatos                      
            initForm();
            //AutocomplementarDatosCliente();
        },
        error: function (xhr, ajaxOptions, thrownError) {// si hay error se ejecuta la funcion
            document.getElementById(idDiv).innerHTML="hay un problema!";
            alert(xhr.status);
            alert(thrownError);
          }
      });
    
}

function EditarCampoItems(Tab,idLocalEdit,TextBox,Field,idEdit){
    var FieldValue=document.getElementById(TextBox).value;
    if(Field=="Cantidad" && FieldValue<=0){
        document.getElementById(TextBox).value=1;
        return;
    }
    var form_data = new FormData();
        form_data.append('Accion', '3'); 
        form_data.append('Tab', Tab);
        form_data.append('idLocalEdit', idLocalEdit);
        form_data.append('Field', Field);
        form_data.append('idEdit', idEdit);
        form_data.append('FieldValue', FieldValue);
                
        $.ajax({
        url: './procesadores/main.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            
            var respuestas = data.split(';'); //Armamos un vector separando los punto y coma de la cadena de texto
            if(respuestas[0]=="OK"){        
                //VerCarrito();
                ActualizarTotalItemsCarro(idClientUser);
                alertify.success(respuestas[1],1000);
            }else if(respuestas[0]=="E1"){  
                alertify.error(respuestas[1]);
                
            }else{
                alertify.alert(data);                
            }
                    
        },
        error: function (xhr, ajaxOptions, thrownError) {
            
            alert(xhr.status);
            alert(thrownError);
          }
      });
    
}


function ActualiceSpTotalItem(idItem){
    var idValorUnitario="ValorUnitario_"+idItem;
    var idCantidad="Cantidad_"+idItem;
    var spTotalItem="spTotalItem_"+idItem;
    var spCantidadItem="spCantidadItem_"+idItem;
    var ValorUnitario=document.getElementById(idValorUnitario).value;
    var Cantidad=document.getElementById(idCantidad).value;
    var Total=parseFloat(ValorUnitario*Cantidad);
    
    document.getElementById(spTotalItem).innerHTML=number_format(Total);
    document.getElementById(spCantidadItem).innerHTML=number_format(Cantidad);
}

function SumaRestaCantidad(Operacion,idCaja,idLocal,idItem){
    var Cantidad=document.getElementById(idCaja).value;
    if(Operacion==1){
        Cantidad=parseInt(Cantidad)+1;
    }else{
        Cantidad=parseInt(Cantidad)-1;
    }
    document.getElementById(idCaja).value=Cantidad;
    EditarCampoItems(1,idLocal,idCaja,`Cantidad`,idItem);
    ActualiceSpTotalItem(idItem);
}

function EliminarItemPedido(idLocalEdit,idItem,idCardItem){
    
    var form_data = new FormData();
        form_data.append('Accion', '4'); 
        form_data.append('idLocalEdit', idLocalEdit);
        form_data.append('idItem', idItem);
             
        $.ajax({
        url: './procesadores/main.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            
            var respuestas = data.split(';'); //Armamos un vector separando los punto y coma de la cadena de texto
            if(respuestas[0]=="OK"){        
                //VerCarrito();
                ActualizarTotalItemsCarro(idClientUser);
                $("#"+idCardItem).remove();
                alertify.error(respuestas[1],1000);
            }else if(respuestas[0]=="E1"){  
                alertify.error(respuestas[1]);
                
            }else{
                alertify.alert(data);                
            }
                    
        },
        error: function (xhr, ajaxOptions, thrownError) {
            
            alert(xhr.status);
            alert(thrownError);
          }
      });
}


function ConfimarSolicitarPedidos(idUserClient){
    
    alertify.confirm('Seguro que desea Realizar el pedido? ',
        function (e) {
            if (e) {
                grecaptcha.execute('6LdoC-gUAAAAADi7iGr_b8WtxMijj24V8v-dAtB-', {action: 'homepage'}).then(function(token) {
                     CrearPedido(idUserClient,token);
                });
                
            }else{
                alertify.error("Se canceló el proceso");
                return;
            }
        });

}


function CrearPedido(idUserClient,token){
    
    var NombreCliente=document.getElementById('NombreCliente').value;
    var DireccionCliente=document.getElementById('DireccionCliente').value;
    var Telefono=document.getElementById('Telefono').value;
    var ObservacionesPedido=document.getElementById('ObservacionesPedido').value;
    
    
    var idDiv="divMain";
    document.getElementById(idDiv).innerHTML='<div id="GifProcess">Enviando pedidos a los locales...<br><img   src="../../images/loading.gif" alt="Cargando" height="100" width="100"></div>';
    
    
    var form_data = new FormData();
        form_data.append('Accion', '5'); 
        form_data.append('NombreCliente', NombreCliente);
        form_data.append('DireccionCliente', DireccionCliente);
        form_data.append('Telefono', Telefono);
        form_data.append('ObservacionesPedido', ObservacionesPedido);
        form_data.append('idUserClient', idUserClient);
        form_data.append('token', token);
        form_data.append('action', 'homepage');
                        
        $.ajax({
        url: './procesadores/main.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            
            var respuestas = data.split(';'); //Armamos un vector separando los punto y coma de la cadena de texto
            if(respuestas[0]=="OK"){ 
                alertify.alert(respuestas[1]);
                VerCarrito();
                ActualizarTotalItemsCarro(idClientUser);
            }else if(respuestas[0]=="E1"){  
                alertify.error(respuestas[1]);
                MarqueErrorElemento(respuestas[2]);
            }else{
                alertify.alert(data);                
            }
                    
        },
        error: function (xhr, ajaxOptions, thrownError) {
            
            alert(xhr.status);
            alert(thrownError);
          }
      });
    
}

function ConfimarDescartarPedidos(idUserClient){
    
    alertify.confirm('Seguro que desea Descartar este pedido? ',
        function (e) {
            if (e) {
                DescartarPedidos(idUserClient);
            }else{
                alertify.error("Se canceló el proceso");
                return;
            }
        });

}

function DescartarPedidos(idUserClient){
        
    var form_data = new FormData();
        form_data.append('Accion', '6'); 
        
        form_data.append('idUserClient', idUserClient);
                        
        $.ajax({
        url: './procesadores/main.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            
            var respuestas = data.split(';'); //Armamos un vector separando los punto y coma de la cadena de texto
            if(respuestas[0]=="OK"){ 
                alertify.alert(respuestas[1]);
                VerCarrito();
                ActualizarTotalItemsCarro(idClientUser);
            }else if(respuestas[0]=="E1"){  
                alertify.error(respuestas[1]);
                MarqueErrorElemento(respuestas[2]);
            }else{
                alertify.alert(data);                
            }
                    
        },
        error: function (xhr, ajaxOptions, thrownError) {
            
            alert(xhr.status);
            alert(thrownError);
          }
      });
}


function BuscarLocal(){
    idPantalla=2;
    var Busqueda=document.getElementById('BusquedaLocal').value;
    var idDiv="divMain";
    document.getElementById(idDiv).innerHTML='<div id="GifProcess">cargando...<br><img   src="../../images/loading.gif" alt="Cargando" height="100" width="100"></div>';
    
    var form_data = new FormData();
        form_data.append('Accion', 6);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        form_data.append('Busqueda', Busqueda);
                
       $.ajax({// se arma un objecto por medio de ajax  
        url: 'Consultas/main.draw.php',// se indica donde llegara la informacion del objecto
        
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post', // se especifica que metodo de envio se utilizara normalmente y por seguridad se utiliza el post
        success: function(data){            
            document.getElementById(idDiv).innerHTML=data; //La respuesta del servidor la dibujo en el div DivTablasBaseDatos                      
             },
        error: function (xhr, ajaxOptions, thrownError) {// si hay error se ejecuta la funcion
            document.getElementById(idDiv).innerHTML="hay un problema!";
            alert(xhr.status);
            alert(thrownError);
          }
      });
}


function MostrarGaleriaProducto(idLocal,idProducto){
    
    AbreModal('modalMain');
    var idDiv="DivModal";
    document.getElementById(idDiv).innerHTML='<div id="GifProcess">cargando...<br><img   src="../../images/loading.gif" alt="Cargando" height="100" width="100"></div>';
    
    var form_data = new FormData();
        form_data.append('Accion', 8);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        form_data.append('idProducto', idProducto);
        form_data.append('idLocal', idLocal);
                
       $.ajax({// se arma un objecto por medio de ajax  
        url: 'Consultas/main.draw.php',// se indica donde llegara la informacion del objecto
        
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post', // se especifica que metodo de envio se utilizara normalmente y por seguridad se utiliza el post
        success: function(data){            
            document.getElementById(idDiv).innerHTML=data; //La respuesta del servidor la dibujo en el div DivTablasBaseDatos                      
             },
        error: function (xhr, ajaxOptions, thrownError) {// si hay error se ejecuta la funcion
            document.getElementById(idDiv).innerHTML="hay un problema!";
            alert(xhr.status);
            alert(thrownError);
          }
      });
}


function MostrarLinksEnlaces(){
    
    if($("#aLinkProducto").length){
        $("#aLinkLocal").click();
        $("#aLinkProducto").click();
        return;
    }
    
    if($("#aLinkLocal").length){        
        $("#aLinkLocal").click();
    }
    
}

function CopiarLinkLocal(idElemento){
    idElemento="#"+idElemento;
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(idElemento).text()).select();
    document.execCommand("copy");
    alertify.success("Link Copiado: "+$(idElemento).text());
    $temp.remove();
}

function AutocomplementarDatosCliente(){
    
    if(!$("#NombreCliente").length){
        return;
    }
    
    var form_data = new FormData();
        form_data.append('Accion', '7'); 
        
        form_data.append('idUserClient', idClientUser);
                        
        $.ajax({
        url: './procesadores/main.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            
            var respuestas = data.split(';'); //Armamos un vector separando los punto y coma de la cadena de texto
            if(respuestas[0]=="OK"){ 
                $("#NombreCliente").click();
                $("#DireccionCliente").click();
                $("#Telefono").focus();
                //document.getElementById('NombreCliente').focus();
                //document.getElementById('DireccionCliente').focus();
                //document.getElementById('Telefono').focus();
                document.getElementById('NombreCliente').value=respuestas[1];
                document.getElementById('DireccionCliente').value=respuestas[2];
                document.getElementById('Telefono').value=respuestas[3];
                
                
               
            }else{
                console.log(respuestas);
            }              
        },
        error: function (xhr, ajaxOptions, thrownError) {
            
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

ListarCategoria();
MostrarLinksEnlaces();
ActualizarTotalItemsCarro(idClientUser);


