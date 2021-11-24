<?php

include_once "Cupon.php";

class Devoluciones
{
    public $numeroPedido;
    public $causaDevolucion;
    public $fotoCliente;
    public $cupon;

    public function __construct($numeroPedido,$causaDevolucion,$fotoCliente,$cupon)
    {
        $this->numeroPedido = $numeroPedido;
        $this->causaDevolucion = $causaDevolucion;
        $this->fotoCliente = $fotoCliente;
        $this->cupon = $cupon;
    }


	public static function LeerDevoluciones()
     {
         $arrayDevoluciones = array();
         $archivo = fopen("JSON/Devoluciones.json", "r");
         if($archivo != false)
         {
             while(!feof($archivo))
             {
                 $aux = json_decode(fgets($archivo), true);
                 if($aux != null)
                 {
                     $devolucion = new Devoluciones($aux['numeroPedido'],$aux['causaDevolucion'],$aux['fotoCliente'],$aux['cupon']);
                     array_push($arrayDevoluciones, $devolucion);
                 }
             }
             fclose($archivo);
         }
         return $arrayDevoluciones;
     }


     public static function ImprimirDevoluciones($array){
		foreach($array as $v)
		{
			echo "<ul>";
			foreach($v as $item){
				echo "<li>$item</li>";}
			echo "</ul>";
		}
	}

    public static function ImprimirDevolucionesConCupones($array){
        echo "LISTADO DEVOLUCIONES CON SUS CUPONES";
		foreach($array as $v)
		{
			echo "<ul>";
                echo "<li>$v->numeroPedido</li>";
                echo "<li>$v->causaDevolucion</li>";
                echo "<li>$v->fotoCliente</li>";
                $objCupon = Cupon::obtenerPorId($v->cupon);
                echo "<li>$objCupon->id</li>";
                echo "<li>$objCupon->descuento</li>";
                echo "<li>$objCupon->estado</li>";
			echo "</ul>";
        }
	}
	

	
}