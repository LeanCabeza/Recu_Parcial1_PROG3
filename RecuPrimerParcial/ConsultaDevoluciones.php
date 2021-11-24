<?php

include "Entidades/Venta.php";
include "Entidades/Pizza.php";
include "Entidades/Devoluciones.php";

$Punto = $_GET['consulta'];

if (isset($Punto)){

    switch ($Punto) {
        case 'a': case 'A':
            print "LISTAR DEVOLUCIONES CON CUPONES";
            $arrayDevoluciones = Devoluciones::LeerDevoluciones();
            Devoluciones ::ImprimirDevoluciones($arrayDevoluciones);
            break;

            break;
        case 'b': case 'B':
            print "LISTADO DE CUPONES";
            $arrayCupones = Cupon::LeerCupones();
            Cupon ::ImprimirCupones($arrayCupones);
            break;
        case 'c': case 'C':
            $arrayDevolucion = Devoluciones::LeerDevoluciones();
            Devoluciones::ImprimirDevolucionesConCupones($arrayDevolucion);
            break;
        default:
            echo "ERROR, solo opciones de la 'A-C'.";
            break;
    }

}else{
    echo "Error,datos incompletos.";
}