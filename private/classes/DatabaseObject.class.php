<?php

declare(strict_types=1);
class DatabaseObject
{
    static protected $database;

    static protected $table_name = "";
    static protected $db_columns = [];

    public $errors = [];

    static public function set_database($database)
    {
        self::$database = $database;
    }

    static public function find_by_sql($sql)
    {
        $result =  self::$database->query($sql);
        if (!$result) {
            throw new Exception('Database query failed');
        }

        $data_array = [];
        while ($record = $result->fetch_assoc()) {
            $data_array[] = static::instantiate($record);
        }

        $result->free();
        return $data_array;
    }

    static public function find_by_id($id)
    {
        $sql = "SELECT * from " . static::$table_name . " WHERE id = " . self::$database->escape_string($id);
        $result = static::find_by_sql($sql);

        if (!$result) {
            return false;
        }

        return array_shift($result);
    }

    static public function find_all()
    {
        $sql = "SELECT * from " . static::$table_name;
        return static::find_by_sql($sql);
    }

    static public function instantiate($record)
    {
        $object = new static;

        foreach ($record as $property => $value) {
            if (property_exists($object, $property)) {
                $object->$property = $value;
            }
        }
        return $object;
    }

    protected function create(): bool
    {
        $attributes = $this->sanitized_attributes();

        $sql = "INSERT INTO " . static::$table_name . "(";
        $sql .= join(',', array_keys($attributes));
        $sql .= ") VALUES ('";
        $sql .= join("', '", array_values($attributes));
        $sql .= "')";

        $result = self::$database->query($sql);

        if ($result) {
            $this->id = self::$database->insert_id;
        }

        return $result;
    }

    protected function update(): bool
    {
        $attributes = $this->sanitized_attributes();
        $attribute_pairs = [];

        foreach ($attributes as $key => $value) {
            $attribute_pairs[] = "{$key} = '{$value}'";
        }
        $sql = "UPDATE " . static::$table_name . " SET ";
        $sql .= join(',', $attribute_pairs);
        $sql .= " WHERE id =" . $this->id;
        $sql .= " LIMIT 1";

        $result = self::$database->query($sql);

        return $result;
    }

    public function save(): bool
    {
        $this->validate();
        if (!empty($this->errors))  return false;

        if ($this->id) {
            return $this->update();
        }

        return $this->create();
    }

    public function attributes(): array
    {
        $attributes = [];
        foreach (static::$db_columns as $column) {
            if ($column == 'id' || !$this->$column) continue;
            $attributes[$column] = $this->$column;
        }

        if (property_exists($this, 'created_at')) {
            $attributes['created_at'] = date('Y-m-d H:i:s');
        }

        return $attributes;
    }

    public function sanitized_attributes(): array
    {
        $sanitized = [];

        foreach ($this->attributes() as $key => $value) {
            $sanitized[$key] = self::$database->escape_string($value);
        }

        return $sanitized;
    }

    public function merge_attributes(array $args = []): void
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }

    public function delete(): bool
    {
        $sql = "DELETE  from " . static::$table_name . " WHERE id = " . $this->id . " LIMIT 1";
        return self::$database->query($sql);
    }

    public function validate(): array
    {
        $this->errors = [];
        return $this->errors;
    }
}
