<?php
require_once 'CivilizacionAbstract.php';

class Ejercito {
	private $batallas		= 0;
	protected $nombre;
	protected $unidades		= array();
	protected $civilizacion	= null;
	protected $oro			= 1000;

    final public function __construct(CivilizacionAbstract $civilizacion=null) {
		$this->civilizacion			= $civilizacion;
		$this->createEjercito();
	}

	final public function __get($private_var=null){
		if(isset($this->{$private_var})){
			return $this->{$private_var};
		}
		throw new Exception("La propiedad {$private_var} no existe.", 1);
	}
/**
 * Crear un ejercito con los parametros de cada civilizacion.
 * @return void
 */
	private function createEjercito(){
		$this->unidades	= array_merge($this->unidades, UnidadPiquero::createMultiples($this->civilizacion->cantPiqueros));
		$this->unidades	= array_merge($this->unidades, UnidadArquero::createMultiples($this->civilizacion->cantArqueros));
		$this->unidades	= array_merge($this->unidades, UnidadCaballero::createMultiples($this->civilizacion->cantCaballeros));
	}

/**
 * Cuenta la cantidad de unidades de un tipo determinado, que tiene el ejercito.
 * @param string $tipo_unidad
 * @return integer
 */
	private function countTipoUnidad($tipo_unidad=null): int {
		$aux	= 0;
		foreach ($this->unidades as $val) {
			if($val instanceof $tipo_unidad){
				$aux++;
			}
		}
		return $aux;
	}

/**
 * Obtener la civilizacion a la cual pertenece el ejercito
 * @return CivilizacionAbstract
 */
	public function getCivilizacion(): CivilizacionAbstract {
		return $this->civilizacion;
	}

/**
 * Especifica un nombre al ejercito creado.
 * @param string $texto
 * @return void
 */
	public function setNombre($texto=null): void {
		$this->nombre	= $texto;
	}
/**
 * Agrega un monto determinado de oro a la cantidad total.
 * @param Int $monto
 * @return void
 */
	public function sumOro(Int $monto= null): void {
		$this->oro	= $this->oro + $monto;
	}

/**
 * Quita un monto determinado de la cantidad de oro total.
 * @param Int $monto
 * @return void
 */
	public function substractOro(Int $monto= null): void {
		$this->oro	= $this->oro - $monto;
	}

/**
 * Obtiene la cantidad de Oro disponible.
 * @return integer
 */
	public function getOro(): int {
		return $this->oro;
	}

/**
 * Obtiene el ID de la unidad con mayor puntaje
 * @return integer
 */
	public function getIdUnidadMayorPuntaje(): int{
		$id	= 0;
		$aux= 0;
		foreach ($this->unidades as $i => $v) {
			if($v->puntos > $aux){
				$id	= $i;
			}
		}
		return $id;
	}

/**
 * Obtiene el ID random de una unidad.
 * @return integer
 */
	public function getIdUnidadrandom(): int{
		return rand(0, (count($this->unidades)-1));
	}

/**
 * Obtiene el puntaje total del ejercito.
 * Significa que suma el puntaje de cada unidad viva.
 * @return integer
 */
	public function getPuntos(): int{
		$puntos_total	= 0;
		foreach ($this->unidades as $val) {
			$puntos_total	= (int)$puntos_total + (int)$val->getPuntos();
		}
		return $puntos_total;
	}

/**
 * Dado que hay una logica unica que sucede al perder la batalla.
 * El ejercito pierde 2 unidades con el mayor puntaje.
 * @return void
 */
	public function perderBatalla(): void{
		$id_mayor_puntaje	= $this->getIdUnidadMayorPuntaje();
		echo "\n El ejercito {$this->nombre} pierde unidad {$this->unidades[$id_mayor_puntaje]->nombre} \n";
		unset($this->unidades[$id_mayor_puntaje]);
		
		$id_mayor_puntaje	= $this->getIdUnidadMayorPuntaje();
		echo "\n El ejercito {$this->nombre} pierde unidad {$this->unidades[$id_mayor_puntaje]->nombre} \n";
		unset($this->unidades[$id_mayor_puntaje]);

		$this->batallas++;
	}

/**
 * Dado que hay una logica unica que sucede al ganar la batalla.
 * La civilizacion gana 100 de oro.
 * @return void
 */
	public function ganarBatalla(): void {
		$this->sumOro(100);
		echo "\n El ejercito {$this->nombre} gana la batalla\n";
		$this->batallas++;
	}

/**
 * Dado que hay una logica unica que sucede al empatar la batalla.
 * Cada ejercito pierde una unidad aleatoria.
 * @return void
 */
	public function empatarBatalla(): void {
		$id_random	= $this->getIdUnidadrandom();
		echo "\n El ejercito {$this->nombre} pierde unidad {$this->unidades[$id_random]->nombre} \n";
		unset($this->unidades[$id_random]);
		$this->batallas++;
	}

/**
 * Entrenar una cantidad N de unidades de un tipo disponible.
 * Primero verifica si la cantidad de unidades que quiere entrenar estan disponibles, caso contrario entrena el total.
 * Si el costo de entrenar a una unidad es mayor que el oro disponible en la civilizacion, entonces cancela la accion.
 * Si todo bien, entrena la unidad y resta el costo al total de oro disponible en la  civilizacion.
 * 
 * @param string $tipo_unidad - Nombre de la clase
 * @param integer $count - Cantidad de unidades a entrenar
 * @return void
 */
	public function entrenar($tipo_unidad=null, $count=1): void{
		if(!is_int($count)){
			throw new Exception("La cantidad de ejercitos debe ser valor numerico", 1);
		}
		$maxima_cant_tipo_unidad	= $this->countTipoUnidad($tipo_unidad);
		if($count > $maxima_cant_tipo_unidad){
			$count	= $maxima_cant_tipo_unidad;
		}

		while ($count != 0) {
			$id_random	= $this->getIdUnidadrandom();
			if($this->unidades[$id_random] instanceof $tipo_unidad && $this->getOro() < $this->unidades[$id_random]->getCostoEntrenar() ){
				return;
			}
			if($this->unidades[$id_random] instanceof $tipo_unidad){
				$this->unidades[$id_random]->entrenar();
				$this->substractOro($this->unidades[$id_random]->getCostoEntrenar());
				echo "\n El ejercito {$this->nombre} entreno una unidad {$this->unidades[$id_random]->nombre} \n";
				$count--;
			}
		}
	}

/**
 * Entrenar una cantidad N de unidades de un tipo disponible.
 * Primero verifica si la cantidad de unidades que quiere entrenar estan disponibles, caso contrario entrena el total.
 * Si el costo de entrenar a una unidad es mayor que el oro disponible en la civilizacion, entonces cancela la accion.
 * Si todo bien, entrena la unidad y resta el costo al total de oro disponible en la  civilizacion.
 * 
 * @param string $tipo_unidad - Nombre de la clase
 * @param integer $count - Cantidad de unidades a convertir
 * @return void
 */
	public function convertir($tipo_unidad=null, $count=1): void{
		if(!is_int($count)){
			throw new Exception("La cantidad de ejercitos debe ser valor numerico", 1);
		}
		$maxima_cant_tipo_unidad	= $this->countTipoUnidad($tipo_unidad);
		if($count > $maxima_cant_tipo_unidad){
			$count	= $maxima_cant_tipo_unidad;
		}

		while ($count != 0) {
			$id_random	= $this->getIdUnidadrandom();
			if($this->unidades[$id_random] instanceof $tipo_unidad && $this->getOro() < $this->unidades[$id_random]->getCostoConvertir() ){
				return;
			}
			if($this->unidades[$id_random] instanceof $tipo_unidad){
				$this->substractOro($this->unidades[$id_random]->getCostoConvertir());
				$old_name					= $this->unidades[$id_random]->nombre;
				$this->unidades[$id_random]	= $this->unidades[$id_random]->convertir();
				echo "\n El ejercito {$this->nombre} convirtió una unidad {$old_name} en {$this->unidades[$id_random]->nombre} \n";
				$count--;
			}
		}
	}
}