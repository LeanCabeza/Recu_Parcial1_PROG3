<?php
include "entidades/Venta.php";


    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        parse_str(file_get_contents("php://input"),$put_vars);

        if (Venta::UpdateVenta($put_vars['numeroPedido'],$put_vars['mail'],$put_vars['sabor'],$put_vars['tipo'],$put_vars['cantidad'])==TRUE){
            print("Venta Actualizada <br>");
       }else{
           print("Faltan ingresar Datos o no existe ese nro Pedido.<br>");
       }
    } else {
        echo "El metodo debe ser PUT.";
    }
    
   