/**
 * Controlador para cargar los egresos
 * JULIAN ALVARAN 2019-05-24
 * TECHNO SOLUCIONES SAS 
 * 
 */

/**
 * Limpia los divs de la compra despues de guardar
 * @returns {undefined}
 */
function LimpiarDivs(){
    document.getElementById('DivProcess').innerHTML='';
    
    //document.getElementById('DivTotalesCompra').innerHTML='';
}

function ConfirmarMigracion(){
    
    alertify.confirm('Está seguro que desea Ejecutar las migraciones?</strong>',
        function (e) {
            if (e) {

                alertify.success("Iniciando Migraciones");                    
                IniciarMigraciones();
            }else{
                alertify.error("Se canceló el proceso");

                return;
            }
        });
}

/**
 * Verifica Si ya fue cargado el archivo a subir
 * @returns {undefined}
 */
function IniciarMigraciones(){
    document.getElementById("DivProcess").innerHTML='<div id="GifProcess">Procesando...<br><img   src="../../images/loader.gif" alt="Cargando" height="100" width="100"></div>';
    
    document.getElementById('BtnSubir').disabled=true;
    document.getElementById('BtnSubir').value="Migrando...";
    
    var form_data = new FormData();
        form_data.append('Accion', 1);
        
        
        
        $.ajax({
        url: './procesadores/migrations.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
           var respuestas = data.split(';'); 
           if(respuestas[0]==="OK"){  //SI no existe 
                $('.progress-bar').css('width','20%').attr('aria-valuenow', 20);  
                document.getElementById('LyProgresoUP').innerHTML="20%";
                alertify.success(respuestas[1]);
                EjecutarMigraciones(1);
            }else if(respuestas[0]==="E1"){ //Si existe debe pedir o no actualizacion
                LimpiarDivs();
                
                document.getElementById('BtnSubir').disabled=false;
                document.getElementById('BtnSubir').value="Ejecutar";
                return;      
                
            }else{
                LimpiarDivs();
                document.getElementById('BtnSubir').disabled=false;
                document.getElementById('BtnSubir').value="Ejecutar";
                alertify.alert(data);
                
            }
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            LimpiarDivs();
            alert(xhr.status);
            alert(thrownError);
          }
      });
}

/**
 * Se ejecutan las migraciones
 * @returns {undefined}
 */
function EjecutarMigraciones(MigracionActual){
    
    
    
    
    
    
    var form_data = new FormData();
        form_data.append('Accion', 2);        
        
        form_data.append('MigracionActual', MigracionActual);
        
      
    $.ajax({
        //async:false,
        url: './procesadores/migrations.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            var respuestas = data.split(';'); 
           if(respuestas[0]==="OK"){   
               $('.progress-bar').css('width','100%').attr('aria-valuenow', 100);  
                document.getElementById('LyProgresoUP').innerHTML="100%";
                alertify.success(respuestas[1]);
                document.getElementById('BtnSubir').disabled=false;
                document.getElementById('BtnSubir').value="Ejecutar";
                LimpiarDivs();
                //GuardeEnTemporal();
            }else if(respuestas[0]==="E1"){
                LimpiarDivs();
                
                document.getElementById('DivMensajes').innerHTML=(respuestas[1]);
                document.getElementById('BtnSubir').disabled=false;
                document.getElementById('BtnSubir').value="Ejecutar";
                return;                
            }else{
                LimpiarDivs();
                
                document.getElementById('DivMensajes').innerHTML=data;
                document.getElementById('BtnSubir').disabled=false;
                document.getElementById('BtnSubir').value="Ejecutar";
            }
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            LimpiarDivs();
            document.getElementById('BtnSubir').disabled=false;
            document.getElementById('BtnSubir').value="Ejecutar";
            alert(xhr.status);
            alert(thrownError);
          }
      })
}

function ObtengaHora(){
    var f=new Date();
    var cad=f.getHours()+":"+f.getMinutes()+":"+f.getSeconds(); 
    return (cad)
}
