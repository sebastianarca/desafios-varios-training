<?php
abstract class UnidadAbstract {
/**
 * Nombre de la unidad.
 * @var string
 */
    protected $nombre;
/**
 * Puntos de fuerza de una unidad.
 * @var integer
 */
    protected $puntos = 0;

/**
 * Setea los puntos de fuerza.
 * @return void
 */
    abstract protected function setPuntos(): void;
/**
 * Setea el nombre de la unidad.
 * @return void
 */
    abstract protected function setNombre(): void;
/**
 * Incrementa los puntos de fuerza.
 * @return void
 */
    abstract public function entrenar(): void;
/**
 * Especifica el costo en oro de entrenar.
 * @return integer
 */
    abstract public function getCostoEntrenar(): int;
/**
 * Devuelve una nueva instancia (o asi mismo de no aplicar), se convierte asi mismo en otro objeto.
 * @return UnidadAbstract
 */
    abstract public function convertir(): UnidadAbstract;
/**
 * Costo en oro para convertir una Unidad.
 * @return integer
 */
    abstract public function getCostoConvertir(): int;
    
    public function __construct(){
        $this->setPuntos();
        $this->setNombre();
    }

/**
 * Devuelve la cantidad de puntos de la unidad.
 * @return integer
 */
    public function getPuntos(): int{
        return $this->puntos;
    }

/**
 * Crea multiples instancias de si mismo y las devuelve en un array.
 * @param int $count - Cantidad de unidades a crear
 * @return array
 */
    final static public function createMultiples($count=null): array {
        if($count===null){
            return [];
        }
        $unidades   = [];
        while ($count != 0) {
            $unidades[] = new static();
            $count--;
        }
        return $unidades;
    }

/**
 * Magic method para acceder a propiedades protegidas.
 * @param string $private_var
 * @return mixed
 */
    final public function __get($private_var=null){
		if(isset($this->{$private_var})){
			return $this->{$private_var};
		}
		throw new Exception("La propiedad {$private_var} no existe.", 1);	
    }

/**
 * Devuelve el nombre de la clase que implementa esta abstraccion.
 * @return string
 */
    public function getClassName(): string {
        return (string)static::class;
    }
}