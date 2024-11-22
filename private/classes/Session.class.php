<?php

class Session
{
    private $user_id;

    /**
     * Class constructor.
     */
    public function __construct()
    {
        session_start();
        $this->check_stored_login();
    }

    public function login($user)
    {
        if ($user) {
            session_regenerate_id();
            $_SESSION['user_id'] = $user->id;
            $this->user_id = $user->id;
        }
        return true;
    }

    public function is_logged_in()
    {
        return isset($this->user_id);
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($this->user_id);

        return true;
    }

    private function check_stored_login()
    {
        if (isset($_SESSION['user_id'])) {
            $this->user_id = $_SESSION['user_id'];
        }
    }

    public function message(string $msg = "")
    {
        if ($msg) {
            $_SESSION['message'] = $msg;
            return true;
        } else {
            return $_SESSION['message'] ?? '';
        }
    }

    public function clear_message()
    {
        unset($_SESSION['message']);
    }
}
