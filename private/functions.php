<?php


function dd($variable)
{
    var_dump($variable);
    die;
}

function is_post_request()
{
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function is_get_request()
{
    return $_SERVER['REQUEST_METHOD'] == 'GET';
}

function redirect_to($location)
{
    header("Location: " . $location);
    exit;
}

function url_for($script_path)
{
    // add the leading '/' if not present
    if ($script_path[0] != '/') {
        $script_path = "/" . $script_path;
    }
    return WWW_ROOT . $script_path;
}

function display_errors(array $errors)
{
    $message = '<div class="alert alert-danger">';
    $message .= '<ul>';
    foreach ($errors as $error) {
        $message .= '<li>' . $error . '</li>';
    }

    $message .= '</ul></div>';
    return $message;
}

function require_login()
{
    global $session;
    if (!$session->is_logged_in()) {
        return redirect_to(url_for('login.php'));
    }
}

function display_session_message()
{
    global $session;
    $message = $session->message();
    if (isset($message) && !empty($message)) {
        $session->clear_message();
        return '<div class="alert alert-danger">' . $message . '</div>';
    }
}
