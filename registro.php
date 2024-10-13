<?php
class Registro {
    private $vehiculo;
    private $cliente;
    private $horaIngreso;
    private $horaSalida;
    private $piso;
    private $espacio;

    public function __construct($vehiculo, $cliente, $piso, $espacio) {
        $this->vehiculo = $vehiculo;
        $this->cliente = $cliente;
        $this->horaIngreso = new DateTime();
        $this->piso = $piso;
        $this->espacio = $espacio;
    }

    public function setHoraSalida() {
        $this->horaSalida = new DateTime();
    }

   
    public function calcularValorPagarManual($horas, $minutos) {
       
        $totalHoras = $horas + ($minutos / 60);
        
        return $totalHoras * 2;
    }

    public function calcularValorPagar() {
        $diferencia = $this->horaSalida->diff($this->horaIngreso);
        $horas = $diferencia->h + ($diferencia->days * 24);
        return $horas * 2; 
    }

    public function getInfo() {
        return [
            'placa' => $this->vehiculo->getPlaca(),
            'marca' => $this->vehiculo->getMarca(),
            'color' => $this->vehiculo->getColor(),
            'tipo' => $this->vehiculo->getTipo(),
            'nombre' => $this->cliente->getNombre(),
            'documento' => $this->cliente->getDocumento(),
            'horaIngreso' => $this->horaIngreso->format('Y-m-d H:i:s'),
            'horaSalida' => $this->horaSalida ? $this->horaSalida->format('Y-m-d H:i:s') : 'No ha salido',
            'piso' => $this->piso,
            'espacio' => $this->espacio,
            'valorPagar' => $this->horaSalida ? $this->calcularValorPagar() : 'N/A'
        ];
    }
}
