<?php
/**
 * Esta clase se encargara de emitir una respuesta sobre la peticion actual.
 */

class Respuesta
{
    public function __construct()
    {

    }

    private function respuesta($cuerpo, $cabeceras = array()) 
    {
        foreach($cabeceras as $nombre => $valor) {
            # header() es usado para enviar cabeceras HTTP sin formato. 
            header($nombre.': '.$valor);
        }
        echo $cuerpo;
    
        return array(
            'cuerpo' => $cuerpo,
            'cabeceras' => $cabeceras
        );
    }

    public function json($data)
    {
        $this->respuesta(
            json_encode($data),
         array(
             'Content-type' => 'application/json'
             )
         );
    }

    public function txt($data)
    {
        $this->respuesta(
            $data,
            array(
             'Content-type' => 'text/plain'
             )
         );
    }

    public function html($data)
    {
        $this->respuesta(
            $data,
            array(
             'Content-type' => 'text/html'
             )
         );
    }

    public function send($data, $headers = array())
    {
        $this->respuesta(
            $data,
            $headers
         );
    }
}