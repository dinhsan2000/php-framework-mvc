<?php

namespace Application\Database;

use PDO;
use ArrayAccess;

abstract class Model implements ArrayAccess
{
    private string $host;
    private string $user;
    private string $password;
    private string $database;
    protected PDO $pdo;
    protected mixed $sql;
    protected mixed $statement;
    private mixed $attributes;

    public function __construct($attributes = [])
    {
        $this->attributes = $attributes;
        $this->host = $_ENV['DB_HOST'];
        $this->user = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];
        $this->database = $_ENV['DB_DATABASE'];
        $this->connect();
    }

    private function connect(): void
    {
        try {
            $this->pdo = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->database, $this->user, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function setSqlQuery($sql): void
    {
        $this->sql = $sql;
    }

    /**
     * Execute the SQL query
     *
     * @param array $options
     * @return mixed
     */
    public function execute(array $options = []): mixed
    {
        $this->statement = $this->pdo->prepare($this->sql);
        if (!empty($options)) {
            foreach ($options as $index => $value) {
                $this->statement->bindValue($index + 1, $value);
            }
        }
        $this->statement->execute();
        return $this->statement;
    }

    /**
     * Get all records from the table
     *
     * @param array $columns
     * @return mixed
     */
    public function get(array $columns = ['*'])
    {
        $sql = "SELECT " . $this->implode($columns) . " FROM `$this->table`";
        $this->setSqlQuery($sql);
        return $this->execute()->fetchAll();
    }

    /**
     * Get the first record from the table
     *
     * @param int $id
     * @return mixed
     */
    public function first(int $id): mixed
    {
        $sql = "SELECT * FROM `$this->table` WHERE id = ?";
        $this->setSqlQuery($sql);
        return $this->execute([$id])->fetchObject();
    }

    /**
     * Create a new record in the table
     *
     * @param int $id
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data): mixed
    {
        // if $fillable is set and is an array then filter the data to only include fields in $fillable
        if (isset($this->fillable) && is_array($this->fillable)) {
            // Filter the data array to only include fields in $fillable
            $data = array_intersect_key($data, array_flip($this->fillable));
        }
        // Convert the data array to a string
        $columns = $this->implode(array_keys($data));
        $keyValues = $this->implode(array_fill(0, count($data), '?'));

        $sql = "INSERT INTO `$this->table` ($columns) VALUES ($keyValues)";

        try {
            $this->setSqlQuery($sql);
            $this->execute(array_values($data));
            return $this->pdo->lastInsertId();
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }

    /**
     * Update a record in the table
     *
     * @param int $id
     * @param array $data
     *
     * @return mixed
     */
    public function update(int $id, array $data): mixed
    {
        // if $fillable is set and is an array then filter the data to only include fields in $fillable
        if (isset($this->fillable) && is_array($this->fillable)) {
            // Filter the data array to only include fields in $fillable
            $data = array_intersect_key($data, array_flip($this->fillable));
        }
        // Convert the data array to a string
        $columns = $this->implode(array_keys($data));
        $values = $this->implode(array_values($data));

        $sql = "UPDATE `$this->table` SET $columns = $values WHERE id = ?";

        try {
            $this->setSqlQuery($sql);
            $this->execute([$id]);
            return true;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }

    /**
     * Delete a record from the table
     *
     * @param int $id
     *
     * @return mixed
     */
    public function delete(int $id): mixed
    {
        $sql = "DELETE FROM `$this->table` WHERE id = ?";

        try {
            $this->setSqlQuery($sql);
            $this->execute([$id]);
            return true;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }

    public function implode($options): string
    {
        return implode(',', $options);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->attributes[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->attributes[$offset] = $value;
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->attributes[$offset]);
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->attributes[$offset]);
    }

    public static function __callStatic($method, $parameters)
    {
        if (method_exists(static::class, $method)) {
            return call_user_func_array([new static(), $method], $parameters);
        } else {
            throw new \BadMethodCallException("Method [$method] does not exist.");
        }
    }
}