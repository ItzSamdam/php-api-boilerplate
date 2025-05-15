/**
* models/Product.php - Product model
*/


<?php

namespace Models;

use Config\Database;

class Product
{
    private $db;
    private $table = 'products';

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table}");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $now = date('Y-m-d H:i:s');

        $stmt = $this->db->prepare("
            INSERT INTO {$this->table} (name, description, price, created_at, updated_at)
            VALUES (:name, :description, :price, :created_at, :updated_at)
        ");

        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':created_at', $now);
        $stmt->bindParam(':updated_at', $now);

        $stmt->execute();

        $id = $this->db->lastInsertId();

        return $this->findById($id);
    }

    public function update($id, $data)
    {
        // First check if record exists
        $product = $this->findById($id);

        if (!$product) {
            return false;
        }

        $now = date('Y-m-d H:i:s');

        // Build update query dynamically based on provided data
        $fields = [];
        $params = [':id' => $id, ':updated_at' => $now];

        foreach ($data as $key => $value) {
            if (in_array($key, ['name', 'description', 'price'])) {
                $fields[] = "{$key} = :{$key}";
                $params[":{$key}"] = $value;
            }
        }

        if (empty($fields)) {
            return $product; // Nothing to update
        }

        $fields[] = "updated_at = :updated_at";
        $fieldsStr = implode(', ', $fields);

        $stmt = $this->db->prepare("UPDATE {$this->table} SET {$fieldsStr} WHERE id = :id");
        $stmt->execute($params);

        return $this->findById($id);
    }

    public function delete($id)
    {
        // First check if record exists
        $product = $this->findById($id);

        if (!$product) {
            return false;
        }

        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return true;
    }
}
