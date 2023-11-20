<?php

namespace app;
class Database
{
    public \PDO $pdo;
    public function __construct() {
        $this->pdo = new \PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root', '');
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function getProducts($search = '') {
        if($search){
            $statment = $this->pdo->prepare('SELECT * FROM products WHERE title LIKE :title ORDER BY create_date DESC');
            $statment->bindValue(':title', "%$search%");
        } else {
            # Si esta vacía la busqueda, entonces seleccionamos todo
            $statment = $this->pdo->prepare('SELECT * FROM products ORDER BY create_date DESC');
        }
        $statment->execute();
        $products = $statment->fetchAll(\PDO::FETCH_ASSOC);
        return $products;
    }
}