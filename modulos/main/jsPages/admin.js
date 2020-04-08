/**
 * Controlador para la el administrador
 * JULIAN ANDRES ALVARAN
 * 2020-04-04
 */

var idMenuAdmin=1;

function VerMenuSegunID(){
    if(idMenuAdmin==1){
        adminClasificacion();
    }
    if(idMenuAdmin==2){
        adminProductos();
    }
    if(idMenuAdmin==3){
        adminPedidos();
    }
}
function pageMinusAdmin(){
    if(Page>1){
        Page=parseInt(Page)-1;
    }
    VerMenuSegunID();
}

function pageAddAdmin(){
    Page=parseInt(Page)+1;
    VerMenuSegunID();
}


function FormularioIniciarSesion(){
    
    var idDiv="divMain";
    document.getElementById(idDiv).innerHTML='<div id="GifProcess">cargando...<br><img   src="../../images/loading.gif" alt="Cargando" height="100" width="100"></div>';
    
    var form_data = new FormData();
        form_data.append('Accion', 1);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        form_data.append('Token_user', idClientUser);
        
       $.ajax({// se arma un objecto por medio de ajax  
        url: 'Consultas/admin.draw.php',// se indica donde llegara la informacion del objecto
        
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post', // se especifica que metodo de envio se utilizara normalmente y por seguridad se utiliza el post
        success: function(data){   
            
            if(data=='OK'){
                VerAdministradorDomi();
            }else{
                document.getElementById(idDiv).innerHTML=data; //La respuesta del servidor la dibujo en el div DivTablasBaseDatos                      
                initForm();
            }    
        },
        error: function (xhr, ajaxOptions, thrownError) {// si hay error se ejecuta la funcion
            document.getElementById(idDiv).innerHTML="hay un problema!";
            alert(xhr.status);
            alert(thrownError);
          }
      });
}


function ValidarLogin(){
        
    var user_domi=document.getElementById("user_domi").value;
    var pw_domi=document.getElementById("pw_domi").value;
    
    var form_data = new FormData();
        form_data.append('Accion', '1'); 
        form_data.append('user_domi', user_domi);
        form_data.append('pw_domi', pw_domi);
        form_data.append('Token_user', idClientUser);
                        
        $.ajax({
        url: './procesadores/admin.process.php',
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
                VerAdministradorDomi();
                
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

function TerminarSesion(){
    
    var form_data = new FormData();
        form_data.append('Accion', '2'); 
                                
        $.ajax({
        url: './procesadores/admin.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            
            var respuestas = data.split(';'); //Armamos un vector separando los punto y coma de la cadena de texto
            if(respuestas[0]=="OK"){ 
                alertify.success(respuestas[1]);
                ListarCategoria();
                
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

function VerAdministradorDomi(){
    Page=1;
    var idDiv="divMain";
    document.getElementById(idDiv).innerHTML='<div id="GifProcess">cargando...<br><img   src="../../images/loading.gif" alt="Cargando" height="100" width="100"></div>';
    
    var form_data = new FormData();
        form_data.append('Accion', 2);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        form_data.append('Token_user', idClientUser);
        
       $.ajax({// se arma un objecto por medio de ajax  
        url: 'Consultas/admin.draw.php',// se indica donde llegara la informacion del objecto
        
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post', // se especifica que metodo de envio se utilizara normalmente y por seguridad se utiliza el post
        success: function(data){   
            
            
            document.getElementById(idDiv).innerHTML=data; //La respuesta del servidor la dibujo en el div DivTablasBaseDatos                      
            initForm();
            
        },
        error: function (xhr, ajaxOptions, thrownError) {// si hay error se ejecuta la funcion
            document.getElementById(idDiv).innerHTML="hay un problema!";
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

function adminClasificacion(){
    idMenuAdmin=1;
    var idDiv="divAdmin";
    document.getElementById(idDiv).innerHTML='<div id="GifProcess">cargando...<br><img   src="../../images/loading.gif" alt="Cargando" height="100" width="100"></div>';
    var Busqueda=document.getElementById('BusquedaAdmin').value;
    var form_data = new FormData();
        form_data.append('Accion', 3);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        form_data.append('Token_user', idClientUser);
        form_data.append('Busqueda', Busqueda);
        form_data.append('Page', Page);
        
       $.ajax({// se arma un objecto por medio de ajax  
        url: 'Consultas/admin.draw.php',// se indica donde llegara la informacion del objecto
        
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post', // se especifica que metodo de envio se utilizara normalmente y por seguridad se utiliza el post
        success: function(data){   
            
            
            document.getElementById(idDiv).innerHTML=data; //La respuesta del servidor la dibujo en el div DivTablasBaseDatos                      
            initForm();
            
        },
        error: function (xhr, ajaxOptions, thrownError) {// si hay error se ejecuta la funcion
            document.getElementById(idDiv).innerHTML="hay un problema!";
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

function adminProductos(){
    idMenuAdmin=2;
    var idDiv="divAdmin";
    document.getElementById(idDiv).innerHTML='<div id="GifProcess">cargando...<br><img   src="../../images/loading.gif" alt="Cargando" height="100" width="100"></div>';
    var Busqueda=document.getElementById('BusquedaAdmin').value;
    var form_data = new FormData();
        form_data.append('Accion', 4);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        form_data.append('Token_user', idClientUser);
        form_data.append('Busqueda', Busqueda);
        form_data.append('Page', Page);
        
       $.ajax({// se arma un objecto por medio de ajax  
        url: 'Consultas/admin.draw.php',// se indica donde llegara la informacion del objecto
        
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post', // se especifica que metodo de envio se utilizara normalmente y por seguridad se utiliza el post
        success: function(data){   
            
            
            document.getElementById(idDiv).innerHTML=data; //La respuesta del servidor la dibujo en el div DivTablasBaseDatos                      
            initForm();
            
        },
        error: function (xhr, ajaxOptions, thrownError) {// si hay error se ejecuta la funcion
            document.getElementById(idDiv).innerHTML="hay un problema!";
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

function adminPedidos(){
    idMenuAdmin=3;
    var idDiv="divAdmin";
    document.getElementById(idDiv).innerHTML='<div id="GifProcess">cargando...<br><img   src="../../images/loading.gif" alt="Cargando" height="100" width="100"></div>';
    var Busqueda=document.getElementById('BusquedaAdmin').value;
    var form_data = new FormData();
        form_data.append('Accion', 5);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        form_data.append('Token_user', idClientUser);
        form_data.append('Busqueda', Busqueda);
        form_data.append('Page', Page);
        
       $.ajax({// se arma un objecto por medio de ajax  
        url: 'Consultas/admin.draw.php',// se indica donde llegara la informacion del objecto
        
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post', // se especifica que metodo de envio se utilizara normalmente y por seguridad se utiliza el post
        success: function(data){   
            
            
            document.getElementById(idDiv).innerHTML=data; //La respuesta del servidor la dibujo en el div DivTablasBaseDatos                      
            initForm();
            
        },
        error: function (xhr, ajaxOptions, thrownError) {// si hay error se ejecuta la funcion
            document.getElementById(idDiv).innerHTML="hay un problema!";
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

function CambiarEstadoPedido(idPedido){
    var idCmbEstado="cmbEstado_"+idPedido;
    var Estado=document.getElementById(idCmbEstado).value;
    var form_data = new FormData();
        form_data.append('Accion', '3'); 
        form_data.append('idPedido', idPedido); 
        form_data.append('Estado', Estado); 
                                
        $.ajax({
        url: './procesadores/admin.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            
            var respuestas = data.split(';'); //Armamos un vector separando los punto y coma de la cadena de texto
            if(respuestas[0]=="OK"){ 
                alertify.success(respuestas[1]);                
                var idSpanEstado="spEstado_"+idPedido;
                document.getElementById(idSpanEstado).innerHTML=respuestas[2];          
                
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

function FormularioAgregarEditar(idTabla,idItem=""){
    if(idTabla==1){
        var Accion=6;
    }
    if(idTabla==2){
        var Accion=7;
    }
    var idDiv="divAdmin";
    document.getElementById(idDiv).innerHTML='<div id="GifProcess">cargando...<br><img   src="../../images/loading.gif" alt="Cargando" height="100" width="100"></div>';
    
    var form_data = new FormData();
        form_data.append('Accion', Accion);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        form_data.append('Token_user', idClientUser);
        form_data.append('idTabla', idTabla);
        form_data.append('idItem', idItem);
        
       $.ajax({// se arma un objecto por medio de ajax  
        url: 'Consultas/admin.draw.php',// se indica donde llegara la informacion del objecto
        
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post', // se especifica que metodo de envio se utilizara normalmente y por seguridad se utiliza el post
        success: function(data){   
            
            
            document.getElementById(idDiv).innerHTML=data; //La respuesta del servidor la dibujo en el div DivTablasBaseDatos                      
            initForm();
            
        },
        error: function (xhr, ajaxOptions, thrownError) {// si hay error se ejecuta la funcion
            document.getElementById(idDiv).innerHTML="hay un problema!";
            alert(xhr.status);
            alert(thrownError);
          }
      });
}


function ConfirmaGuardarEditar(Tabla,idItem){
    alertify.confirm('Seguro que desea Guardar? ',
        function (e) {
            if (e) {
                if(Tabla==1){
                    GuardarEditarClasificacion(idItem);
                }
                if(Tabla==2){
                    GuardarEditarProducto(idItem);
                }
                
            }else{
                alertify.error("Se canceló el proceso");
                return;
            }
        });
}

function GuardarEditarClasificacion(idItem){
    
    var Estado=document.getElementById("Estado").value;
    var Clasificacion=document.getElementById("Clasificacion").value;
    var form_data = new FormData();
        form_data.append('Accion', '4'); 
        form_data.append('Token_user', idClientUser);
        form_data.append('idItem', idItem); 
        form_data.append('Estado', Estado); 
        form_data.append('Clasificacion', Clasificacion); 
                                
        $.ajax({
        url: './procesadores/admin.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            
            var respuestas = data.split(';'); //Armamos un vector separando los punto y coma de la cadena de texto
            if(respuestas[0]=="OK"){ 
                alertify.success(respuestas[1]);                
                VerMenuSegunID();                      
                
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

function GuardarEditarProducto(idItem){
    
    var Estado=document.getElementById("Estado").value;
    var idClasificacion=document.getElementById("idClasificacion").value;
    var Referencia=document.getElementById("Referencia").value;
    var Nombre=document.getElementById("Nombre").value;
    var PrecioVenta=document.getElementById("PrecioVenta").value;
    var DescripcionCorta=document.getElementById("DescripcionCorta").value;
    var DescripcionLarga=document.getElementById("DescripcionLarga").value;
    var Orden=document.getElementById("Orden").value;
    
    var form_data = new FormData();
        form_data.append('Accion', '5'); 
        form_data.append('Token_user', idClientUser);
        form_data.append('idItem', idItem); 
        form_data.append('Estado', Estado); 
        form_data.append('idClasificacion', idClasificacion); 
        form_data.append('Referencia', Referencia);
        form_data.append('Nombre', Nombre);
        form_data.append('PrecioVenta', PrecioVenta);
        form_data.append('DescripcionCorta', DescripcionCorta);
        form_data.append('DescripcionLarga', DescripcionLarga);
        form_data.append('Orden', Orden);
        form_data.append('ImagenProducto', $('#ImagenProducto').prop('files')[0]);
                                
        $.ajax({
        url: './procesadores/admin.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            
            var respuestas = data.split(';'); //Armamos un vector separando los punto y coma de la cadena de texto
            if(respuestas[0]=="OK"){ 
                alertify.success(respuestas[1]);                
                VerMenuSegunID();                      
                
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

