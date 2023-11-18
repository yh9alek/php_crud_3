<?php

namespace app;
class Router
{
    public array $getRoutes = [];
    public array $postRoutes = [];

    public function get($url, $fn) {
        $this->getRoutes[$url] = $fn;
    }

    public function post($url, $fn) {
        $this->postRoutes[$url] = $fn;
    }

    public function resolve() {
        $currentURL = $_SERVER['PATH_INFO'] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];

        if($method === 'GET'){
            $fn = $this->getRoutes[$currentURL] ?? null;
        }
        else {
            $fn = $this->postRoutes[$currentURL] ?? null;
        }
        if($fn) {
            if(is_array($fn) && is_object($fn[0])) call_user_func($fn);
            else {
                $obj = new $fn[0]();
                call_user_func([$obj, $fn[1]]);
            }
        }
        else {
            echo "Page not found";
        }
    }
}