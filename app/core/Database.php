<?php

namespace App\Core;

use App\Core\Connection;

class Database
{
    private $conn;
    private $stmt;
    private $sql = "";
    private $bindValues = [];
    private $rowCount = 0;

    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }

    public function reset(): void
    {
        $this->sql = "";
        $this->bindValues = [];
        $this->rowCount = 0;
    }

    public function debug()
    {
        echo pr([
            'sql'        => $this->sql,
            'bindValues' => $this->bindValues,
            'rowCount'   => $this->rowCount
        ]);

        return $this;
    }

    public function fetch(string $model): array
    {
        $this->stmt->setFetchMode(\PDO::FETCH_CLASS, $model);

        if ($this->rowCount > 0) {
            $result = $this->stmt->fetchAll();
        } else {
            $result = [];
        }

        return $result;
    }

    public function execute(): Database
    {
        $this->stmt = $this->conn->prepare($this->sql);

        if (!empty($this->bindValues)) {
            foreach ($this->bindValues as $field => $value) {
                $this->stmt->bindValue(":{$field}", $value);
            }
        }

        $this->stmt->execute();
        $this->rowCount = $this->stmt->rowCount();

        return $this;
    }

    public function select(array $fields): Database
    {
        $fields = implode(', ', $fields);
        $this->sql .= "SELECT {$fields}";

        return $this;
    }

    public function from(string $tableName): Database
    {
        $this->sql .= " FROM {$tableName}";

        return $this;
    }

    public function where(array $where): Database
    {
        $key = array_keys($where)[0];
        $value = array_values($where)[0];

        $this->sql .= " WHERE {$key} = :{$key}";
        $this->bindValues[$key] = $value;

        return $this;
    }

    public function orderBy(string $orderBy): Database
    {
        $this->sql .= " ORDER BY {$orderBy}";

        return $this;
    }

    public function insert($table)
    {
        $this->sql = "INSERT INTO {$table}";

        return $this;
    }

    public function update($table)
    {
        $this->sql = "UPDATE {$table}";

        return $this;
    }

    public function set($data)
    {
        $cols = array();

        foreach ($data as $key => $value) {
            if ($value !== NULL) {
                $this->bindValues[$key] = $value;
                $cols[] = "{$key} = :{$key}";
            }
        }

        $this->sql .= " SET ";
        $this->sql .= implode(', ', $cols);

        return $this;
    }

    public function rowCount()
    {
        return $this->rowCount;
    }
}
