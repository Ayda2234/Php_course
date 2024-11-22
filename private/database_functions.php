<?php

function db_connect()
{
    try {
        return new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo "Error connecting to the database";
        die;
    }
}

function db_disconnect($connection)
{
    if (isset($connection)) {
        $connection->close();
    }
}
