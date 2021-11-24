<?php

require_once "Entidades/Pizza.php";
require_once "Entidades/Venta.php";

$mail = $_POST["mail"];
$sabor= $_POST["sabor"];
$tipo= $_POST["tipo"];
$cantidad= $_POST["cantidad"];


if (isset($mail) &&isset($sabor) &&isset($tipo) && isset($cantidad))
{
    // PRIMERO VALIDAR SI EXISTE ESE TIPO Y SABOR DE PIZZA Y ADEMAS SI TENGO STOCK , AHI PROCESO LA COMPRA.

    if(Pizza::HayStock($sabor,$tipo,$cantidad) == TRUE)
    {
        //Guardo la foto
        $tipoArchivo = pathinfo($_FILES["foto"]["name"],PATHINFO_EXTENSION);
        $auxMail = explode("@", $mail);

        $destino = "ImagenesDeLaVenta/".$tipo.'-'.$sabor.'-'.$auxMail[0]."-".date("Y-m-d").'.'.$tipoArchivo;
        $destinoBDD = $tipo.'-'.$sabor.'-'.$auxMail[0]."-".date("Y-m-d").'.'.$tipoArchivo;
        move_uploaded_file($_FILES["foto"]["tmp_name"],$destino);

        
        //Guardo la pizza en la BDD

            $nroPedido = uniqid("Pedido");
            $unaVenta = new Venta();
            $unaVenta->mailUsuario= $mail;
            $unaVenta->numeroPedido= $nroPedido;
            $unaVenta->fecha= date("Y-m-d");
            $unaVenta->sabor = $sabor ;
            $unaVenta->tipo = $tipo ;
            $unaVenta->cantidad = $cantidad ;
            $unaVenta->foto = $destinoBDD ;
            $unaVenta->precio = 100;
            $UltimoId = $unaVenta->AltaVentaParametros();
            print("Dado de alta con exito<br>".$UltimoId); 
            
            //Actualizo el stock ( Disminuyendo de Pizza.json)
            if (Pizza::ActualizarStock($sabor,$tipo,$cantidad,'-')){
                print ("Stock Actualizado");
            }else{
                print("Problema al actualizar Stock");
            }

    }else{
     print("No se puede procesar la venta.") ;
    }
                   
}else{
    print ("Faltan datos");
}
