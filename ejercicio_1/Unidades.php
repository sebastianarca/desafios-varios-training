<?php
require_once 'UnidadAbstract.php';

class UnidadPiquero extends UnidadAbstract {
    protected function setNombre(): void{
        $this->nombre   = 'Piquero';
    }
    protected function setPuntos(): void {
        $this->puntos   =   5;
    }
    public function entrenar(): void{
        $this->puntos   = $this->puntos + 3;
    }
    public function getCostoEntrenar(): int {
        return 10;
    }
    public function convertir(): UnidadAbstract{
        return new UnidadArquero();
    }
    public function getCostoConvertir(): int{
        return 30;
    }
}

class UnidadArquero extends UnidadAbstract {
    protected function setNombre(): void{
        $this->nombre   = 'Arquero';
    }
    protected function setPuntos(): void {
        $this->puntos     = 10;
    }
    public function entrenar(): void{
        $this->puntos   = $this->puntos + 7;
    }
    public function getCostoEntrenar(): int {
        return 20;
    }
    public function convertir(): UnidadAbstract{
        return new UnidadCaballero();
    }
    public function getCostoConvertir(): int{
        return 40;
    }
}

class UnidadCaballero extends UnidadAbstract {
    protected function setNombre(): void{
        $this->nombre   = 'Caballero';
    }
    protected function setPuntos(): void {
        $this->puntos     = 20;
    }
    public function entrenar(): void{
        $this->puntos   = $this->puntos + 10;
    }
    public function getCostoEntrenar(): int {
        return 30;
    }
    public function convertir(): UnidadAbstract{
        return $this;
    }
    public function getCostoConvertir(): int{
        return 0;
    }
}