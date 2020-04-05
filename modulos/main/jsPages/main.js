/**
 * Controlador para la pagina principal
 * JULIAN ANDRES ALVARAN
 * 2020-04-04
 */

function getIdClientUser(){
    var idClientUser = Cookies.get('idClientUser');    
    if(idClientUser==undefined){        
        idClientUser=uuid.v4();
        Cookies.set('idClientUser',idClientUser,{expires: 9999});
    }
    console.log(idClientUser);
    return(idClientUser);
    
}

function setTextareaHeight(textareas) {
    console.log("Redimensionando text areas");
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
    var idDiv="divMain";
    document.getElementById(idDiv).innerHTML='<div id="GifProcess">cargando...<br><img   src="../../images/loading.gif" alt="Cargando" height="100" width="100"></div>';
    
    var form_data = new FormData();
        form_data.append('Accion', 1);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
                
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
    var idDiv="divMain";
    document.getElementById(idDiv).innerHTML='<div id="GifProcess">cargando...<br><img   src="../../images/loading.gif" alt="Cargando" height="100" width="100"></div>';
    
    var form_data = new FormData();
        form_data.append('Accion', 2);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        form_data.append('Categoria', Categoria);
                
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
    var idDiv="divMain";
    document.getElementById(idDiv).innerHTML='<div id="GifProcess">cargando...<br><img   src="../../images/loading.gif" alt="Cargando" height="100" width="100"></div>';
    
    var form_data = new FormData();
        form_data.append('Accion', 3);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
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
    
    var form_data = new FormData();
        form_data.append('Accion', 4);// pasamos la accion y el numero de accion para el dibujante sepa que caso tomar
        form_data.append('idLocal', idLocal);
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
                
                document.getElementById('spItemsCar').innerHTML=respuestas[1];
                document.getElementById('spTotalCar').innerHTML=respuestas[3];
                
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
    AbreModal('modalMain');
}
ListarCategoria();
var idClientUser=getIdClientUser();

ActualizarTotalItemsCarro(idClientUser);

