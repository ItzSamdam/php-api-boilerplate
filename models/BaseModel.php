<?php

require_once __DIR__ . '/../config/Database.php';

abstract class BaseModel
{
    protected $db;
    protected $table;
    protected $fillable = [];

    // Query builder state
    protected $query = [
        'select' => '*',
        'where' => [],
        'order' => '',
        'limit' => '',
        // You can add more query components like 'join', 'groupBy', etc. as needed
    ];

    public function __construct()
    {
        $this->db = \Database::getInstance()->getConnection();
    }

    // --- Static entry point ---
    public static function query()
    {
        return new static();
    }

    // --- Query Builder Methods ---
    public function select($columns = '*')
    {
        $this->query['select'] = is_array($columns) ? implode(',', $columns) : $columns;
        return $this;
    }

    public function where($column, $operator, $value)
    {
        $this->query['where'][] = [$column, $operator, $value];
        return $this;
    }

    public function orderBy($column, $direction = 'ASC')
    {
        $this->query['order'] = "ORDER BY {$column} {$direction}";
        return $this;
    }

    public function limit($count)
    {
        $this->query['limit'] = "LIMIT {$count}";
        return $this;
    }

    public function get()
    {
        $sql = "SELECT {$this->query['select']} FROM {$this->table}";
        $params = [];

        if (!empty($this->query['where'])) {
            $conditions = [];
            foreach ($this->query['where'] as $i => [$col, $op, $val]) {
                $param = ":w{$i}";
                $conditions[] = "{$col} {$op} {$param}";
                $params[$param] = $val;
            }
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }

        if ($this->query['order']) {
            $sql .= " " . $this->query['order'];
        }

        if ($this->query['limit']) {
            $sql .= " " . $this->query['limit'];
        }

        $stmt = $this->db->prepare($sql);
        foreach ($params as $param => $val) {
            $stmt->bindValue($param, $val);
        }
        $stmt->execute();

        $this->resetQuery();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function first()
    {
        $this->limit(1);
        $results = $this->get();
        return $results[0] ?? null;
    }

    protected function resetQuery()
    {
        $this->query = [
            'select' => '*',
            'where' => [],
            'order' => '',
            'limit' => '',
        ];
    }

    // --- CRUD ---
    public function find($id)
    {
        return $this->where('id', '=', $id)->first();
    }

    public function create($data)
    {
        $now = date('Y-m-d H:i:s');
        $columns = array_intersect(array_keys($data), $this->fillable);
        $columns[] = 'created_at';
        $columns[] = 'updated_at';

        $placeholders = array_map(fn($col) => ":{$col}", $columns);

        $stmt = $this->db->prepare("
            INSERT INTO {$this->table} (" . implode(',', $columns) . ")
            VALUES (" . implode(',', $placeholders) . ")
        ");

        foreach ($columns as $col) {
            $value = $data[$col] ?? $now;
            $stmt->bindValue(":{$col}", $value);
        }

        $stmt->execute();
        return $this->find($this->db->lastInsertId());
    }

    public function update($id, $data)
    {
        $now = date('Y-m-d H:i:s');
        $fields = [];
        $params = [':id' => $id];

        foreach ($data as $key => $value) {
            if (in_array($key, $this->fillable)) {
                $fields[] = "{$key} = :{$key}";
                $params[":{$key}"] = $value;
            }
        }

        $fields[] = "updated_at = :updated_at";
        $params[":updated_at"] = $now;

        $stmt = $this->db->prepare("UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id = :id");
        $stmt->execute($params);

        return $this->find($id);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // --- Relationship Helpers ---
    protected function hasMany($relatedClass, $foreignKey, $localKey = 'id')
    {
        $related = new $relatedClass();
        return $related->where($foreignKey, '=', $this->{$localKey})->get();
    }

    protected function hasOne($relatedClass, $foreignKey, $localKey = 'id')
    {
        $related = new $relatedClass();
        return $related->where($foreignKey, '=', $this->{$localKey})->first();
    }

    protected function belongsTo($relatedClass, $foreignKey, $ownerKey = 'id')
    {
        $related = new $relatedClass();
        return $related->where($ownerKey, '=', $this->{$foreignKey})->first();
    }
}
