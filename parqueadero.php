<?php
require_once 'Registro.php';

class Parqueadero {
    private $espacios;
    private $registros;

    public function __construct() {
        $this->espacios = array_fill(1, 4, array_fill(1, 10, null));
        $this->registros = [];
    }

    public function ingresarVehiculo($vehiculo, $cliente) {
        for ($piso = 1; $piso <= 4; $piso++) {
            for ($espacio = 1; $espacio <= 10; $espacio++) {
                if ($this->espacios[$piso][$espacio] === null) {
                    $registro = new Registro($vehiculo, $cliente, $piso, $espacio);
                    $this->espacios[$piso][$espacio] = $registro;
                    $this->registros[$vehiculo->getPlaca()] = $registro;
                    return true;
                }
            }
        }
        return false;
    }

    public function salidaVehiculo($placa, $horas, $minutos) {
        if (isset($this->registros[$placa])) {
            $registro = $this->registros[$placa];
            $registro->setHoraSalida();
            
            $valorPagar = $registro->calcularValorPagarManual($horas, $minutos);
            $info = $registro->getInfo();
            $this->espacios[$info['piso']][$info['espacio']] = null;
            unset($this->registros[$placa]);

           
            $info['valorPagar'] = $valorPagar;

            return $info;
        }
        return null;
    }

    public function buscarVehiculo($placa) {
        return isset($this->registros[$placa]) ? $this->registros[$placa]->getInfo() : null;
    }

    public function getOcupacion() {
        $ocupacion = [];
        foreach ($this->espacios as $piso => $espacios) {
            foreach ($espacios as $espacio => $registro) {
                if ($registro !== null) {
                    $ocupacion[] = [
                        'piso' => $piso,
                        'espacio' => $espacio,
                        'placa' => $registro->getInfo()['placa'],
                        'tipo' => $registro->getInfo()['tipo']
                    ];
                }
            }
        }
        return $ocupacion;
    }
}
