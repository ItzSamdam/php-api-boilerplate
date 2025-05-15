/**
* models/User.php - User model
*/
<?php

namespace Api\Models;

use Api\Config\Database;

class User
{
    private $db;
    private $table = 'users';

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findAll()
    {
        $stmt = $this->db->prepare("SELECT id, name, email, created_at, updated_at FROM {$this->table}");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT id, name, email, created_at, updated_at FROM {$this->table} WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $now = date('Y-m-d H:i:s');

        $stmt = $this->db->prepare("
            INSERT INTO {$this->table} (name, email, password, created_at, updated_at)
            VALUES (:name, :email, :password, :created_at, :updated_at)
        ");

        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->bindParam(':created_at', $now);
        $stmt->bindParam(':updated_at', $now);

        $stmt->execute();

        $id = $this->db->lastInsertId();

        return $this->findById($id);
    }

    public function update($id, $data)
    {
        // First check if record exists
        $user = $this->findById($id);

        if (!$user) {
            return false;
        }

        $now = date('Y-m-d H:i:s');

        // Build update query dynamically based on provided data
        $fields = [];
        $params = [':id' => $id, ':updated_at' => $now];

        foreach ($data as $key => $value) {
            if (in_array($key, ['name', 'email', 'password'])) {
                $fields[] = "{$key} = :{$key}";
                $params[":{$key}"] = $value;
            }
        }

        if (empty($fields)) {
            return $user; // Nothing to update
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
        $user = $this->findById($id);

        if (!$user) {
            return false;
        }

        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return true;
    }
}
