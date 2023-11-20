<?php

namespace app;
class Router
{
    public Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public array $getRoutes = [];
    public array $postRoutes = [];

    public function get($url, $fn) { # Dentro de $getRoutes[]: "ruta" => [ nombre_clase, método ]
        $this->getRoutes[$url] = $fn;#                          $url  => $fn
    }#  Dentro del array $getRoutes se crea un elemento que como clave = $url y valor = array(2);

    public function post($url, $fn) { # Dentro de $postRoutes[]: "ruta" => [ nombre_clase, método ]
        $this->postRoutes[$url] = $fn;#                           $url  => $fn
    }#  Dentro del array $postRoutes se crea un elemento que como clave = $url y valor = array(2);

    public function resolve() {
        # Este método invoca al método obtenido de los arrays del objeto Router
        $currentURL = $_SERVER['PATH_INFO'] ?? '/'; # Obtenemos el directorio o path en donde nos encontramos (URL)
        $method = $_SERVER['REQUEST_METHOD'];       # Obtenemos el método de solicitud (GET o POST)

        # Obtenemos el método a ejecutar dependiendo del tipo de solicitud
        if($method === 'GET'){
            $fn = $this->getRoutes[$currentURL] ?? null;
        }
        else {
            $fn = $this->postRoutes[$currentURL] ?? null;
        }
        # Si exíste este método definido, lo invocamos desde una instancia creada de la clase correspondiente
        if($fn) {
            if(is_array($fn) && is_object($fn[0])) call_user_func($fn);
            else {
                $obj = new $fn[0]();
                $new_fn = [$obj, $fn[1]];
                call_user_func($new_fn, $this); # Mandamos a llamar al método y como parámetro enviamos el objeto Router
            }
        }
        else {
            echo "Page not found";
        }
    }

    public function renderView($view, $params = []) {
        foreach ($params as $key => $value) {
            $$key = $value; # $key = 'products'     $$key = $products ($'products')
        }
        ob_start(); # Esta función hace que toda la salida generada despues de esta línea se almacene en un bufer
        include_once __DIR__."/views/$view.php";
        $content = ob_get_clean(); # Aquí obtenemos el bufer y lo limpiamos. $content es accesible desde cualquier
        include_once __DIR__."/views/_layout.php";                                                      # contexto.
    }
}