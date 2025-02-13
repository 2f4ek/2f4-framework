<?php

namespace Framework2f4\Model;

use Framework2f4\Database\Database;
use PDO;

abstract class BaseModel
{
    protected static string $table;
    protected array $attributes = [];

    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    public function __get($name)
    {
        return $this->attributes[$name] ?? null;
    }

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public function __isset($name): bool
    {
        return isset($this->attributes[$name]);
    }

    public function save(): bool
    {
        $db = Database::getInstance();
        $columns = array_keys($this->attributes);
        if (isset($this->attributes['id'])) {
            $setClause = implode(', ', array_map(static fn($col) => "$col = :$col", $columns));
            $stmt = $db->prepare("UPDATE " . static::$table . " SET $setClause WHERE id = :id");
        } else {
            $placeholders = implode(', ', array_map(static fn($col) => ":$col", $columns));
            $stmt = $db->prepare("INSERT INTO " . static::$table . " (" . implode(', ', $columns) . ") VALUES ($placeholders)");
        }
        $result = $stmt->execute($this->attributes);

        if ($result && !isset($this->attributes['id'])) {
            $this->attributes['id'] = $db->lastInsertId();
        }

        return $result;
    }

    public function delete(): bool
    {
        if (!isset($this->attributes['id'])) {
            return false;
        }
        $db = Database::getInstance();
        return $db
            ->prepare("DELETE FROM " . static::$table . " WHERE id = :id")
            ->execute(['id' => $this->attributes['id']]);
    }

    public static function find(int $id): ?self
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM " . static::$table . " WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? new static($result) : null;
    }

    public static function where(string $column, mixed $value, array $relations = []): array
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM " . static::$table . " WHERE $column = :value");
        $stmt->execute(['value' => $value]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $models = array_map(static fn($attributes) => new static($attributes), $results);

        foreach ($models as $model) {
            foreach ($relations as $relation) {
                $model->$relation = $model->$relation();
            }
        }

        return $models;
    }

    public static function all(): array
    {
        $db = Database::getInstance();
        $stmt = $db->query("SELECT * FROM " . static::$table);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(static fn($attributes) => new static($attributes), $results);
    }

    public function belongsTo(string $related, string $foreignKey = null)
    {
        $foreignKey = $foreignKey ?: strtolower((new \ReflectionClass($related))->getShortName()) . '_id';
        return $related::find($this->$foreignKey);
    }

    public function hasMany(string $related, string $foreignKey = null): array
    {
        $foreignKey = $foreignKey ?: strtolower((new \ReflectionClass($this))->getShortName()) . '_id';
        return $related::where($foreignKey, $this->id);
    }

    public function hasOne(string $related, string $foreignKey = null): ?self
    {
        $foreignKey = $foreignKey ?: strtolower((new \ReflectionClass($this))->getShortName()) . '_id';
        $results = $related::where($foreignKey, $this->id);
        return $results[0] ?? null;
    }
}