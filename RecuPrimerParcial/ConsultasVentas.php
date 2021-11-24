<?php

include "Entidades/Venta.php";
include "Entidades/Pizza.php";

$Punto = $_GET['consulta'];

if (isset($Punto)){

    switch ($Punto) {
        case 'a': case 'A':
            echo Venta::ObtenerCantFecha("2021-10-18");
            break;
        case 'b': case 'B':
            $arrayVentas = Venta::ObtenerVentasEntreFechas('2019-01-01','2023-09-09');
            Venta ::ImprimirVentas($arrayVentas);
            break;
        case 'c': case 'C':
            $arrayAux= Venta::ObtenerVentasPorUsuario("VendedorRandom@gmail.com");
            Venta::ImprimirVentas($arrayAux);
            break;
        case 'd': case 'D':
            $aux= Venta::ObtenerVentasPorSabor("Napolitana");
            Venta::ImprimirVentas($aux);
            break;
        default:
            echo "ERROR, solo opciones de la 'A-D'.";
            break;
    }

}else{
    echo "Error,datos incompletos.";
}