<?php
require_once 'Ejercito.php';

abstract class CivilizacionAbstract {
	protected $nombre;
	protected $ejercitos		= array();

	protected $cantPiqueros		= 0;
	protected $cantArqueros		= 0;
	protected $cantCaballeros	= 0;

    final public function __construct() {}

	final public function __get($private_var=null){
		if(isset($this->{$private_var})){
			return $this->{$private_var};
		}
		throw new Exception("La propiedad {$private_var} no existe.", 1);
	}

/**
 * Crea un nuevo ejercito y lo agrega a los disponibles.
 * @param integer $count - Cantidad de ejercitos a crear
 * @return void
 */
	final public function createEjercito($count=1): void {
		if(!is_int($count)){
			throw new Exception("La cantidad de ejercitos debe ser valor numerico", 1);
		}
		while ($count != 0) {
			$army				= new Ejercito($this);
			$army->setNombre("ejercito {$this->nombre} ".count($this->ejercitos));
			$this->ejercitos[]	= $army;
			$count--;
		}
	}

/**
 * Obtiene un ejercito random.
 * @return Ejercito
 */
	final public function getEjercito(): Ejercito {
		$random	= rand(0, count($this->ejercitos)-1);
		return $this->ejercitos[$random];
	}
}