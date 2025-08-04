<?php

class FotoServicio {
    /** @var int */
    private $id_foto;
    /** @var int */
    private $id_servicio;
    /** @var string */
    private $ruta_foto;
    /** @var string|null */
    private $descripcion;

    // Getters y Setters

    public function getIdFoto() { return $this->id_foto; }
    public function setIdFoto($id) { $this->id_foto = $id; }
    
    public function getIdServicio() { return $this->id_servicio; }
    public function setIdServicio($id) { $this->id_servicio = $id; }
    
    public function getRutaFoto() { return $this->ruta_foto; }
    public function setRutaFoto($ruta) { $this->ruta_foto = $ruta; }
    
    public function getDescripcion() { return $this->descripcion; }
    public function setDescripcion($desc) { $this->descripcion = $desc; }
}