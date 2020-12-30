<?php 

/*
DOS FORMAS DE ESTRUCTURAR LA CLASE ROUTING
1) Como un pub/sub (patron de diseño orientado a objetos) 
2) Definir los métodos de acceso  (GET, POST, etc.) como metodos NO PERTENECIENTES A LA CLASE.
    Con esta forma capturaremos los metodos mas dinamicamente.
*/
class Routing 
{
    private $rutas = array();
    private $metodosSoportados = array(
        'get',
        'post',
        'delete',
        'put',
        'patch'
    );

    public function __construct($metodos = null) {
        if(!is_null($metodos))
            $this->metodosSoportados = $metodos;
    }

    public function saludar()
    {
        echo 'Hola mundo';
    }

    public function rutas()
    {
        return $this->rutas;
    }
    /*
    El metodo magico __call es ejecutado cada vez que se llame a un metodo que no esta definido en clase.
    Recibe 2 parametros: el nombre del metodo que se esta llamando y los argumentos.
    En este caso el name representara el metodo http y los arguments, la ruta y la respuesta.
    */
    public function __call($name, $arguments)
    {
        foreach($this->metodosSoportados as $metodo) {
            if($metodo == $name) $existe = true;
        }

        if($existe) {
            $metodo = $name;
            $ruta = $arguments[0];
            $accion = $arguments[1];

            $peticion = new Peticion(array(
                'metodo' => $metodo,
                'params' => $ruta,
                'cuerpo' => Peticion::actual()->cuerpo(),
                'cabeceras' => Peticion::actual()->cabeceras(),
            ));

            // Registrar la ruta
            array_push($this->rutas,
                array(
                    'peticion' => $peticion,
                    'respuesta' => $accion
                )
            );
        } else {
            echo 'METODO NO SOPORTADO';
        }  
         
    }

    // Procesar dichas equivalencias (comparar rutas)
    public function resolve()
    {
        $encontrado = false;
        $ruta_a_procesar = array();
        foreach($this->rutas as $ruta) {
         if($ruta['peticion']->is(Peticion::actual())) {
            $encontrado = true;
            $ruta_a_procesar = $ruta;
         }

        }

        if($encontrado) {
            $peticion = $ruta_a_procesar['peticion']; // objeto
            $respuesta = $ruta_a_procesar['respuesta']; // funcion

            // Principio de authorization
            if(!isset($peticion->cabeceras()['Authorization'])) {
                echo 'No estas autorizado';
                die();
            }

            if(is_string($respuesta)) {
                // Se paso una accion de controlador
            } else if(is_callable($respuesta)){
                // Se paso un callback directamente
                $respuesta($peticion, new Respuesta());
            }

            // $res = new Respuesta();
            // $res->send($respuesta['cuerpo'], $respuesta['headers']);

        } else {
            http_response_code(404);
        }
    }
}