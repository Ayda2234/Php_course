<?php

class User extends DatabaseObject
{
    static protected $table_name = "users";
    static protected $db_columns = [
        'id',
        'name',
        'username',
        'password',
    ];

    public $id;
    public $name;
    public $username;
    public $password;
    public $confirm_password;

    /**
     * Class constructor.
     */
    public function __construct(array $args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value ?? '';
            }
        }
    }

    protected function set_hashed_password()
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function validate(): array
    {
        $this->errors = [];

        if (!$this->name) {
            $this->errors[] = "Name should not be empty";
        }
        if (!$this->username) {
            $this->errors[] = "Username should not be empty";
        }
        if (!$this->password) {
            $this->errors[] = "Password should not be empty";
        }
        if (!$this->confirm_password) {
            $this->errors[] = "Confirm password should not be empty";
        }
        if ($this->password != $this->confirm_password) {
            $this->errors[] = "Password should be the same as Confirm password";
        }

        if (!$this->has_unique_username($this->username)) {
            $this->errors[] = "This username has already been taken";
        }

        return $this->errors;
    }

    protected function create(): bool
    {
        $this->set_hashed_password();
        return parent::create();
    }

    protected function update(): bool
    {
        $this->set_hashed_password();
        return parent::update();
    }

    static public function find_by_username($username)
    {
        $sql = "SELECT * from " . self::$table_name . " WHERE username = '" . self::$database->escape_string($username) . "'";
        $result = self::find_by_sql($sql);

        if (!$result) {
            return false;
        }

        return array_shift($result);
    }

    protected function has_unique_username($username)
    {
        return !$this->find_by_username($username);
    }
}
