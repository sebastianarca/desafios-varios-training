<?php
require_once 'Unidades.php';
require_once 'Ejercito.php';
require_once 'Civilizaciones.php';

$chinos     = new CivilizacionChina();
$ingleses   = new CivilizacionInglesa();
$bizantinos = new CivilizacionBizantina();


$chinos->createEjercito(3);
$ingleses->createEjercito(3);
$bizantinos->createEjercito(3);

$ejercito_chino     = $chinos->getEjercito();
$ejercito_chino2    = $chinos->getEjercito();
$ejercito_ingles    = $ingleses->getEjercito();
$ejercito_bizantino = $bizantinos->getEjercito();


$ejercito_chino2->convertir('UnidadPiquero', 100);
$ejercito_chino2->entrenar('UnidadArquero', 100);

$ejercito_chino->convertir('UnidadArquero', 100);
$ejercito_chino->entrenar('UnidadCaballero', 100);

/**
 * Realiza la comparacion de puntos para saber que ejercito gana.
 *
 * @param Ejercito $a
 * @param Ejercito $b
 * @return void
 */
function combatirEjercitos(Ejercito $a=null, Ejercito $b=null): void{
    static $numero_combate  = 1;

    echo "\n ---------------- Combate {$numero_combate} --------------- \n";
    switch (true) {
        case ($a->getPuntos() > $b->getPuntos()):
            $b->perderBatalla();
            $a->ganarBatalla();
            break;
        case ($a->getPuntos() < $b->getPuntos()):
            $a->perderBatalla();
            $b->ganarBatalla();
            break;
        case ($a->getPuntos() == $b->getPuntos()):
            $a->empatarBatalla();
            $b->empatarBatalla();
            break;
    }
    $numero_combate++;
}

echo "\n";
combatirEjercitos($ejercito_chino, $ejercito_ingles);
echo "\n";
combatirEjercitos($ejercito_chino, $ejercito_bizantino);
echo "\n";
combatirEjercitos($ejercito_chino, $ejercito_chino);
echo "\n";
combatirEjercitos($ejercito_chino, $ejercito_chino2);
echo "\n";
