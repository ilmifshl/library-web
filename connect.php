<?php
$host = "localhost";        // PostgreSQL server host
$port = "5432";             // PostgreSQL server port
$dbname = "ERD";            // Name of your PostgreSQL database
$user = "postgres";         // PostgreSQL username
$password = "1305";         // PostgreSQL password

// Establish a connection to the PostgreSQL database
$db = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

// Check if the connection was successful
if (!$db) {
    die("Connection failed: " . pg_last_error());
}

// No need to close the database connection here, you can close it when you're done using it.
?>
