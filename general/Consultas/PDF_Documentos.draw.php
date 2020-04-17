<?php 

if(isset($_REQUEST["idDocumento"]) or isset($_REQUEST["idPedido"])){
    $myPage="PDF_Documentos.draw.php";
    include_once("../../modelo/php_conexion.php");
    include_once("../clases/ClasesPDFDocumentos.class.php");
    
    $obCon = new conexion(1);
    //$obPrint=new PrintPos($idUser);
    $obDoc = new Documento(DB);
    
    if(isset($_REQUEST["idPedido"])){
        $idDocumento=1;
    }else{
        $idDocumento=$obCon->normalizar($_REQUEST["idDocumento"]);
    }
    
    
    
    switch ($idDocumento){
          
        case 1: //PDF para un pedido
            if(isset($_REQUEST["idPedido"])){
                $idPedido=$obCon->normalizar($_REQUEST["idPedido"]);
            }else{
                $idPedido=$obCon->normalizar($_REQUEST["ID"]);
            }
            
            $obDoc->PedidoDomiPDF($idPedido,"");            
        break;//Fin caso 1
    }
}else{
    print("No se recibió parametro de documento");
}

?>