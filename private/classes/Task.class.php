<?php

class Task extends DatabaseObject
{
    static protected $table_name = "tasks";
    static protected $db_columns = [
        'id',
        'name',
        'description',
        'user_id',
        'priority',
        'status',
        'due_date',
        'created_at'
    ];


    public $id;
    public $user_id;
    public $name;
    public $description;
    public $status = 'Pending';
    public $priority = 'Low';
    public $due_date;
    public $created_at;

    /**
     * Class constructor.
     */
    public function __construct($args = [])
    {
        foreach ($args as $property => $value) {
            if (property_exists($this, $property)) {
                $this->$property = $value;
            }
        }
    }

    public function validate(): array
    {
        $this->errors = [];
        if (empty($this->name)) {
            $this->errors[] = "Name should not be empty";
        }

        return $this->errors;
    }
}
