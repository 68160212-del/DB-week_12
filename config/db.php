<?php
// For local development only. Use environment variables on a shared server.
$host = getenv('DB_HOST') ?: 'localhost';
$user = getenv('DB_USER') ?: 's68160212';
$pass = getenv('DB_PASS') ?: 'aySkYpnc';
$dbname = getenv('DB_NAME') ?: '68160212';
$conn = mysqli_connect($host, $user, $pass, $dbname);
if (!$conn) { error_log(mysqli_connect_error()); http_response_code(500); exit('Database unavailable'); }
mysqli_set_charset($conn, 'utf8mb4');
