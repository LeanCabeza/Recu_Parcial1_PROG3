<?php

class Pizza
{
    public $id;
    public $sabor;
    public $precio;
    public $tipo;
    public $cantidad;

    public function __construct($id,$sabor,$precio,$tipo,$cantidad)
    {
        $this->id = $id;
        $this->sabor = $sabor;
        $this->precio = $precio;
        $this->tipo = $tipo;
        $this->cantidad = $cantidad;
    }

    // Funcion que guarda productos en un json, $prod = OBJETO, $modo: a ( agrega al final) , w (Borra y escribe de nuevo)

    public static function GuardarPizza($prod , $modo)
    {
        $archivo = fopen("JSON/Pizza.json", $modo);
        $retorno = false;
        if($archivo != false)
        {
            $store = fwrite($archivo, json_encode(get_object_vars($prod)) . "\n");
            if($store != false){$retorno = true;}
            fclose($archivo);
        }
        return $retorno;
    }



    public static function GuardarArrayPizzasJson($array){
        $nombreArchivo = 'JSON/Pizza.json';
        $archivo = fopen($nombreArchivo, 'w');
        foreach ($array as $p) {
            $registro = json_encode($p);
            fwrite($archivo, $registro.PHP_EOL);
        }
        $exito = fclose($archivo);
        return $exito;
    }


     public static function LeerPizzas()
     {
         $arrayPizzas = array();
         $archivo = fopen("JSON/Pizza.json", "r");
         if($archivo != false)
         {
             while(!feof($archivo))
             {
                 $aux = json_decode(fgets($archivo), true);
                 if($aux != null)
                 {
                     $prod = new Pizza($aux['id'],$aux['sabor'],$aux['precio'],$aux['tipo'],$aux['cantidad'],$aux['precio']);
                     array_push($arrayPizzas, $prod);
                 }
             }
             fclose($archivo);
         }
         return $arrayPizzas;
     }

     //

     public static function VerificarExistente(Pizza $pizza){
        $existe = false;
        $array = Pizza::LeerPizzas();
        foreach ($array as $p) {
            if ($pizza->sabor == $p->sabor && $pizza->tipo == $p->tipo)
            {
                $existe = true ;
                break;
            }
        }
        return $existe; 
    }
 
     // Funcion que valida si un $producto = OBJETO, pertenece al json con productos.
 
     public static function ValidarPizza($producto)
     {
         $array = self::LeerPizzas();
         $retorno = true;
         $flag = true;
 
         foreach ($array as $prod) {
             if($prod->EqualsSaborYtipo($producto))
             {
                 $prod->cantidad += $producto->cantidad;
                 $retorno = false;
                 break;
             }
         }
 
         if(!$retorno)
         {
             foreach ($array as $prod) {
                 if(!$flag)
                 {
                     // ( a )Escritura únicamente, manteniendo el contenido actual y añadiendo los datos al final del archivo.
                     self::GuardarPizza($prod, 'a');
                 } else {
                     // ( w ) Escritura únicamente, reemplazando el contenido actual del archivo o bien creándolo si es inexistente.
                     self::GuardarPizza($prod, 'w');
                     $flag = false;
                 }
             }
             // ( a )Escritura únicamente, manteniendo el contenido actual y añadiendo los datos al final del archivo.
         } else {self::GuardarPizza($producto, 'a');}
         return $retorno;
     }

    // Cambio el criterio del equals, para que quede ok

    public function EqualsSaborYtipo($prod)
    {
         if ($this->tipo == $prod->tipo && $this->sabor == $prod->sabor) {
             return true;
         }else{
             return false;
         }
    }

    public static function VerificarExistenteST($sabor,$tipo){
        $msje = "";
        $existeSabor = false;
        $existeTipo = false;

        $array = Pizza::LeerPizzas();
        foreach ($array as $p) {
            if ($p->sabor == $sabor)
            {
                $existeSabor = true ;
            }
            if ($p->tipo == $tipo){
                $existeTipo = true ;
            }
        }
        if($existeSabor == true && $existeTipo == true)
        {
            $msje = "Si Hay.";
        }else if ($existeSabor == true && $existeTipo == false){
            $msje = "No hay de ese TIPO";
        }else if ($existeSabor == false && $existeTipo == true){
            $msje = "No hay de ese SABOR.";
        }else{
            $msje = "No hay.";
        }
        return $msje; 
    }

    public static function HayStock($sabor,$tipo,$cantidad){
        $array = Pizza::LeerPizzas();
        $retorno = false ;
        foreach ($array as $p) {
            if($p->sabor == $sabor && $p->tipo == $tipo && $p->cantidad >= $cantidad ){
                $retorno = true ;
                break;
            }
        }
        return $retorno;
    }

    public static function ActualizarStock($sabor,$tipo,$stock,$operacion){
        $array = Pizza::LeerPizzas();
        $retorno = false ;
        if ($operacion == '+'){
            foreach ($array as $p) {
                if($p->sabor == $sabor && $p->tipo == $tipo ){
                    $p->cantidad = $p->cantidad + $stock;
                    $retorno = true ;
                    break;
                }
            }
            return Pizza::GuardarArrayPizzasJson($array);
        }else if ($operacion == '-'){
            foreach ($array as $p) {
                if($p->sabor == $sabor && $p->tipo == $tipo ){
                    $p->cantidad = $p->cantidad - $stock;
                    $returno = true ;
                    break;
                }
            }
            return Pizza::GuardarArrayPizzasJson($array);
        }else{
            return $retorno;
        }
        
    }

    



}