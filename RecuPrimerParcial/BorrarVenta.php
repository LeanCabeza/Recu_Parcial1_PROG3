<?php

/*
    6- (1 pts.) borrarVenta.php(por DELETE), debe recibir un número de pedido,se borra la venta y la foto se mueve a
    la carpeta /BACKUPVENTAS.
*/
include_once "Entidades/Venta.php";



if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"),$put_vars);
    $nroPedido = $put_vars["nroPedido"];

    if(Venta::DeleteVenta($nroPedido) != false)
    {
        $rutaFoto = Venta::TraerRutaFoto($nroPedido);
        echo Venta::MoverFoto($rutaFoto);
        echo "<br>Se ha borrado la venta <br>";   
    }else{
        echo "<br>Numero de pedido inexistente.<br>";  
    }
} else {

    echo "El metodo debe ser DELETE";
}