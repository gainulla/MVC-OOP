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

    public function fetch(string $model): array
    {
        $this->stmt->setFetchMode(\PDO::FETCH_CLASS, $model);

        if ($this->rowCount == 1) {
            $result = [$this->stmt->fetch()];
        } elseif ($this->rowCount > 1) {
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
        $count = 0;

        foreach ($where as $key => $value) {
            if ($count == 0) {
                $this->sql .= " WHERE {$key} = :{$key}";
            } elseif ($count > 0) {
                $this->sql .= " AND {$key} = :{$key}";
            }
            $this->bindValues[$key] = $value;
            $count++;
        }

        return $this;
    }

    public function orderBy(string $orderBy): Database
    {
        $this->sql .= " ORDER BY {$orderBy}";

        return $this;
    }

    public function insert($table, $data)
    {
        $key = array_keys($data);
        $val = array_values($data);
        $columns = implode(', ', $key);
        $values = "'" . implode("', '", $val) . "'";

        $this->sql .= "INSERT INTO $table ({$columns}) VALUES ({$values})";
        $this->stmt = $this->conn->prepare($this->sql);
        $done = $this->stmt->execute();

        return $done;
    }
}
