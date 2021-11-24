<?php

require_once "Entidades/Pizza.php";

$sabor = $_POST["sabor"];
$tipo = $_POST["tipo"];


if (isset($sabor) && isset($tipo))
{
    echo Pizza::VerificarExistenteST($sabor,$tipo);

}else{
    echo "Faltan datos";
}
