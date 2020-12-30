<?php 
require_once 'Respuesta.php';
require_once 'Peticion.php';
require_once 'Routing.php';
# Lo primero que tenemos que hacer es aprender a manejar las solitudes y las respuestas
# En el index vamos a recibir todas las peticiones

$routing = new Routing();
$routing->get('caca', function($req, $res){

            $res->json(array('productos' => 'listadeproductos'));

});

$routing->post('productos', function($req, $res){
    

        $res->json(array('productos' => 'nuevoProductoAGuardar'));


});

$routing->resolve();

// function peticion() {

//     return array(
//         'metodo' => $_SERVER['REQUEST_METHOD'],
//         'params' => $_SERVER['QUERY_STRING'],
//         'cuerpo' => file_get_contents('php://input'),
//         'cabeceras' => apache_request_headers()
//     );
// }


// $respuesta = new Respuesta();
// $respuesta->json(
//     array('hola'=>'zorra')
// );

// $peticion = new Peticion;
// $peticion->metodo('metodin');
// echo $peticion->metodo();

// if(Peticion::actual()->metodo() == 'GET') {
//     $res = new Respuesta();
//     $res->json(array('metodo' => 'GET'));
// }