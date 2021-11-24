<?php

include "Entidades/Pizza.php";

$sabor = $_POST['sabor'];
$precio = $_POST['precio'];
$tipo = $_POST['tipo'];
$cantidad = $_POST['cantidad'];
$foto = $_FILES['foto'];


if(isset($sabor) && isset($precio) && isset($tipo) && isset($cantidad) && isset($foto) )
{

    //Guardo la foto
    $tipoArchivo = pathinfo($_FILES["foto"]["name"],PATHINFO_EXTENSION);
    $destino = "ImagenesDePizzas/".$tipo.'-'.$sabor.'.'.$tipoArchivo;
    move_uploaded_file($_FILES["foto"]["tmp_name"],$destino);

    //Genero Id
    $id=uniqid("ID");

    // Valido 

    if(Pizza::ValidarPizza(new Pizza($id,$sabor,$precio,$tipo,$cantidad)))
    {
        echo "Pizza Ingresada";
    } else {
        echo "Pizza Actualizada";
    }
} else {
    echo "No se pudo guardar, falta completar los campos";
}

?>