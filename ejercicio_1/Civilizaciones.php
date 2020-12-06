<?php
require_once 'CivilizacionAbstract.php';

class CivilizacionChina extends CivilizacionAbstract {
	protected $nombre			= 'Chinos';
	protected $cantPiqueros		= 2;
	protected $cantArqueros		= 25;
	protected $cantCaballeros	= 2;
}

class CivilizacionInglesa extends CivilizacionAbstract {
	protected $nombre			= 'Ingleses';
	protected $cantPiqueros		= 10;
	protected $cantArqueros		= 10;
	protected $cantCaballeros	= 10;
}

class CivilizacionBizantina extends CivilizacionAbstract {	
	protected $nombre			= 'Bizantinos';
	protected $cantPiqueros		= 5;
	protected $cantArqueros		= 8;
	protected $cantCaballeros	= 15;
}