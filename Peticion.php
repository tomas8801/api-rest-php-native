<?php 

class Peticion
{
    private $metodo;
    private $params;
    private $cuerpo;
    private $cabeceras;

    public function __construct($opciones = null)
    {
        if(!is_null($opciones) && is_array($opciones)){
            $this->metodo = $opciones['metodo'];
            $this->params = $opciones['params'];
            $this->cuerpo = $opciones['cuerpo'];
            $this->cabeceras = $opciones['cabeceras'];
        }
    }

    // getters y setters
    public function metodo($metodo = null)
    {
        if(!is_null($metodo))
            $this->metodo = $metodo;
        return $this->metodo;
    }

    public function params($params = null)
    {
        if(!is_null($params))
            $this->params = $params;
        return $this->params;
    }

    public function cuerpo($cuerpo = null)
    {
        if(!is_null($cuerpo))
            $this->cuerpo = $cuerpo;
        return $this->cuerpo;
    }

    public function cabeceras($cabeceras = null)
    {
        if(!is_null($cabeceras))
            $this->cabeceras = $cabeceras;
        return $this->cabeceras;
    }


    /**
     *  Esta funcion retornará toda la info de la peticion actual.
        La informacion la obtendremos a traves la variable global $_SERVER (Información del entorno del servidor y de ejecución)
        $_SERVER es un array que contiene información, tales como cabeceras, rutas y ubicaciones de script. 

        1- $_SERVER['REQUEST_METHOD'] -> Nos permite obtener el método por que el cual se esta solicitando la pagina y asi emitir una
        respuesta distinta de acuerdo al método.
        2- $_SERVER['QUERY_STRING'] -> Nos permite acceder a los parametros que se envian por la url.
        3- php://input -> Es un flujo de sólo lectura que permite leer datos del cuerpo solicitado. 
           file_get_contents() -> Transmite un fichero completo a un string.
        4- apache_request_headers() -> Obtiene todas las cabeceras (headers) de petición HTTP de la llamada actual.
     */
    public static function actual()
    {
        return new Peticion(array(
            'metodo' => $_SERVER['REQUEST_METHOD'],
            'params' => $_SERVER['QUERY_STRING'],
            'cuerpo' => file_get_contents('php://input'),
            'cabeceras' => apache_request_headers()
        ));
    }
}