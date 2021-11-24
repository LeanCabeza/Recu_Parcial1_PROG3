<?php

/*
    7- (2 pts.)DevolverPizza.php Guardar en el archivo (devoluciones.json y cupones.json):
    a-Se ingresa el número de pedido y la causa de la devolución. 
    El número de pedido debe existir, se ingresa una foto del cliente enojado,
    esto debe generar un cupón de descuento con el 10% de descuento para la próxima
    compra.
*/

include_once "Entidades/Venta.php";

$numeroPedido = $_POST['numeroPedido'];
$causaDevolucion = $_POST['causaDevolucion'];


if (Venta::ExisteVentaId($numeroPedido))
    {   
        //Guardo la foto
        $tipoArchivo = pathinfo($_FILES["foto"]["name"],PATHINFO_EXTENSION);
        $destino = "ImagenesDeDevoluciones/".$numeroPedido."-".date("Y-m-d").'.'.$tipoArchivo;
        move_uploaded_file($_FILES["foto"]["tmp_name"],$destino);

        Venta::DevolverPizza($numeroPedido,$causaDevolucion,$destino);
    }else{
        print "No existe ese nro de Pedido";
    }	

