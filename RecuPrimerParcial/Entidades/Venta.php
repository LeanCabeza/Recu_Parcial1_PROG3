<?php
include_once "AccesoDatos.php";
include_once "Cupon.php";
class Venta
{
    public function __construct() {

	}

    public function AltaVentaParametros()
	{
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 

				$consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO ventas(mailUsuario,numeroPedido,fecha,sabor,tipo,cantidad,foto,estado,precio)
																values(:mailUsuario,:numeroPedido,:fecha,:sabor,:tipo,:cantidad,:foto,'ACTIVO',:precio)");
				$consulta->bindValue(':mailUsuario',$this->mailUsuario, PDO::PARAM_STR);
				$consulta->bindValue(':numeroPedido', $this->numeroPedido, PDO::PARAM_INT);
				$consulta->bindValue(':fecha', $this->fecha, PDO::PARAM_STR);
				$consulta->bindValue(':sabor', $this->sabor, PDO::PARAM_STR);
				$consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
				$consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_INT);
				$consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR);
				$consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
				$consulta->execute();		
				return $objetoAccesoDato->RetornarUltimoIdInsertado();
				
	}

	public static function TraerTodasVentas()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select * from ventas");
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_CLASS,"Venta");		
	}

	public static function ImprimirVentas($array){
		foreach($array as $v)
		{
			echo "<ul>";
			foreach($v as $item){
				echo "<li>$item</li>";}
			echo "</ul>";
		}
	}

	public static function ExisteVentaId($numeroPedido){
		$array = Venta::TraerTodasVentas();
		$existe = false;
        foreach ($array as $p) {
            if ($p->numeroPedido == $numeroPedido)
            {
                $existe = true ;
                break;
            }
        }
        return $existe; 
	}

	/*
		a- la cantidad de pizzas vendidas por fecha, si no indica fecha son las de hoy
		b- el listado de ventas entre dos fechas ordenadopor sabor.
		c- el listado de ventas de un usuario ingresado
		d- el listado de ventas de un  sabor ingresado
	*/


	public static function CantidadVendidas(){
		$ArrayVentas = Venta::TraerTodasVentas();
			$cantidadVentas = 0 ; 
			 foreach ($ArrayVentas as $v){
				 $cantidadVentas = $cantidadVentas +  $v->cantidad; 
			 }
			return $cantidadVentas;
	}

	public static function ObtenerCantFecha($fecha = ""){
		if ($fecha == ""){
			echo Venta::CantidadVendidas();
		}else{
			$cantVendidas = 0 ;

			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM ventas
													WHERE ventas.fecha >= '$fecha' 
													ORDER BY sabor ASC");
			$consulta->execute();			
			$arrayVentas = $consulta->fetchAll(PDO::FETCH_CLASS,"venta");
			foreach ($arrayVentas as $v){
				$cantVendidas = $cantVendidas +  $v->cantidad; 
			}
		   return $cantVendidas;
		}	
	}

	public static function ObtenerVentasEntreFechas($fechaInicial,$fechaFinal){
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM ventas
													WHERE ventas.fecha >= '$fechaInicial' 
													AND ventas.fecha <= '$fechaFinal'
													ORDER BY sabor ASC");
		$consulta->execute();			
		return $consulta->fetchAll(PDO::FETCH_CLASS,"venta");	
	}

	public static function ObtenerVentasPorUsuario ($mail){

		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM VENTAS
														WHERE mailUsuario = :mail");
        $consulta->bindValue(':mail',$mail, PDO::PARAM_STR);		
		$consulta->execute();			
		return $consulta->fetchAll(PDO::FETCH_OBJ);	
	}

	public static function ObtenerVentasPorSabor ($sabor){

		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM VENTAS
														WHERE sabor = :sabor");
        $consulta->bindValue(':sabor',$sabor, PDO::PARAM_STR);		
		$consulta->execute();			
		return $consulta->fetchAll(PDO::FETCH_OBJ);	
	}

	// número de pedido, el email del usuario, el sabor,tipo y cantidad, si existe se modifica
	public static function UpdateVenta ($numeroPedido,$mail,$sabor,$tipo,$cantidad){
	
		if ($numeroPedido != NULL && $mail != NULL && $sabor != NULL && $tipo !=NULL && $cantidad !=NULL)
		{
			if (Venta::ExisteVentaId($numeroPedido))
			{
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta("UPDATE ventas
																set mailUsuario = '$mail',
																	sabor = '$sabor',
																	tipo = '$tipo',
																	cantidad = '$cantidad'
																WHERE numeroPedido = '$numeroPedido'");	
				$consulta->execute();			
				return true ;
			}else{
				return false;
			}
		}else{
			return false;
		}
		
	}


	public static function DeleteVenta ($numeroPedido){
	
			if (Venta::ExisteVentaId($numeroPedido))
			{
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta("UPDATE ventas
																SET estado = 'BAJA'
																WHERE numeroPedido = '$numeroPedido'");													
				$consulta->execute();
				return true ;
			}else{
				return false;
			}	
	}


	public static function MoverFoto($ruta){

		$fuente = "C:/xampp/htdocs/PrimerParcial/ImagenesDeLaVenta/";
		$destino = "C:/xampp/htdocs/PrimerParcial/BACKUPVENTAS/";
        $dir = opendir($fuente);
        $retorno = "No se pudo mover";

        if( readdir($dir) != false){

			print "FUENTE-RUTA ---> ".$fuente.$ruta;
				print "DESTINO-RUTA ---> ".$destino.$ruta; 

            if(copy($fuente.$ruta , $destino.$ruta))
			{
                unlink($fuente.$ruta);
                $retorno = "Se ha cambiado la imagen de directorio";
            } 
            
        }

        closedir($dir);

        return $retorno;
    }
	

	public static function TraerRutaFoto ($numeroPedido){
	
		if (Venta::ExisteVentaId($numeroPedido))
		{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("SELECT foto FROM VENTAS
															WHERE numeroPedido = :numeroPedido");
			$consulta->bindValue(':numeroPedido',$numeroPedido, PDO::PARAM_STR);		
			$consulta->execute();			
			$objetoRespuesta = $consulta->fetchAll(PDO::FETCH_CLASS,"Venta");	
			return $objetoRespuesta[0]->foto;

		}else{
			return false;
		}	
	}


	public static function DevolverPizza($numeroPedido,$causaDevolucion,$fotoCliente){
		// GENERAR DEVOLUCION 
		$devolucion = new stdClass();
		$devolucion->numeroPedido = $numeroPedido;
		$devolucion->causaDevolucion = $causaDevolucion;
		$devolucion->fotoCliente = $fotoCliente;
		$devolucion->cupon = Cupon::generarCupon(10);

		$json = json_encode($devolucion)."\r\n";

		//ESTA FUNCION CREA ARCHIVO JSON Y ESCRIBE EN EL
		$fp = fopen('JSON/Devoluciones.json','a');

		if(fwrite($fp,$json) != FALSE)
		{
			echo "Devolucion Guardada con exito";
			fclose($fp);
		}else{
			echo "No se pudo agregar,faltan datos";
			fclose($fp);
		}

	}

}

