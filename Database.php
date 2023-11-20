<?php

namespace app;
use \app\models\Product;
class Database
{
    public \PDO $pdo;
    public static Database $db;
    public function __construct() {
        $this->pdo = new \PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root', '');
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        self::$db = $this;
    }

    public function getProductById($id) {
        $statement = $this->pdo->prepare('SELECT * FROM products WHERE id = :id');
        $statement->bindValue(':id', $id);
        $statement->execute();
        return $statement->fetch(\PDO::FETCH_ASSOC);
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

    public function createProduct(Product $product) {
        $statment = $this->pdo->prepare("INSERT INTO products (title, description, image, price, create_date)
        VALUES (:title, :description, :image, :price, :date);");
        $statment->bindValue(':title', $product->title);
        $statment->bindValue(':description', $product->description);
        $statment->bindValue(':image', $product->imagePath);
        $statment->bindValue(':price', $product->price);
        $statment->bindValue(':date', date('Y-m-d H:i:s'));
        $statment->execute();
    }

    public function updateProduct(Product $product) {
        $statment = $this->pdo->prepare("UPDATE products SET title = :title, description = :description, 
        image = :image, price = :price WHERE id = :id;");
        $statment->bindParam(':title', $product->title);
        $statment->bindParam(':description', $product->description);
        $statment->bindParam(':image', $product->imagePath);
        $statment->bindParam(':price', $product->price);
        $statment->bindParam(':id', $product->id);
        $statment->execute();
    }

    public function deleteProduct($id) {
        $statment = $this->pdo->prepare("DELETE FROM products WHERE id = :id");
        $statment->bindValue(':id', $id);
        $statment->execute();
    }
}