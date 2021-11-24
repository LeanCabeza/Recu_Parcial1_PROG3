<?php


class Cupon
{
    public $id;
    public $descuento;
    public $estado;

    public function __construct($id,$descuento,$estado)
    {
        $this->id = $id;
        $this->descuento = $descuento;
        $this->estado = $estado;
    }

    public static function generarCupon($descuento){
		// GENERACION CUPON
		$cupon = new Cupon(uniqid("Cupon"),$descuento,"DISPONIBLE");
		$jsonCupon = json_encode($cupon)."\r\n";
		$fpCupon = fopen('JSON/Cupon.json','a');

		if(fwrite($fpCupon,$jsonCupon) !=FALSE)
		{
			echo "<br>Cupon Guardado con exito";
			fclose($fpCupon);
			return $cupon->id;
		}else{
			echo "No se pudo agregar,faltan datos";
			fclose($fpCupon);
		}
 
	}


	public static function LeerCupones()
     {
         $arrayCupones = array();
         $archivo = fopen("JSON/Cupon.json", "r");
         if($archivo != false)
         {
             while(!feof($archivo))
             {
                 $aux = json_decode(fgets($archivo), true);
                 if($aux != null)
                 {
                     $cupon = new Cupon($aux['id'],$aux['descuento'],$aux['estado']);
                     array_push($arrayCupones, $cupon);
                 }
             }
             fclose($archivo);
         }
         return $arrayCupones;
     }

	public static function ExisteCupon($id){
        $array = Cupon::LeerCupones();
        $retorno = false ;
        foreach ($array as $c) {
            if($c->id == $id && $c->estado == "DISPONIBLE" ){
                $retorno = true ;
                break;
            }
        }
        return $retorno;
    }

    public static function obtenerPorcentajeDeDescuento($id){
        $array = Cupon::LeerCupones();
        $retorno = false ;
        foreach ($array as $c) {
            if($c->id == $id){
                $retorno = $c->descuento ;
                break;
            }
        }
        return $retorno;
    }


    public static function obtenerPorId($id){
        $array = Cupon::LeerCupones();
        $retorno = false ;
        
        foreach ($array as $c) {
            if($c->id == $id){
                $retorno = $c ;
                break;
            }
        }
        return $retorno;
    }


	public static function GuardarArrayCuponesJson($array){
        $nombreArchivo = 'JSON/Cupon.json';
        $archivo = fopen($nombreArchivo, 'w');
        foreach ($array as $p) {
            $registro = json_encode($p);
            fwrite($archivo, $registro.PHP_EOL);
        }
        return fclose($archivo);;
    }


	public static function MarcarComoUsado($id){
		$array = Cupon::LeerCupones();

        foreach ($array as $p) {
             if($p->id == $id){
                $p->estado = "USADO";
                print 'Cupon: '.$id.' marcado como usado.<br>';
                break;
                }
        }
        
        return Cupon::GuardarArrayCuponesJson($array);
	}

    public static function ImprimirCupones($array){
		foreach($array as $v)
		{
			echo "<ul>";
			foreach($v as $item){
				echo "<li>$item</li>";}
			echo "</ul>";
		}
	}




}