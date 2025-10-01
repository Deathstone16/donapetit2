<?php
declare(strict_types=1);

$host = getenv('DB_HOST') ?: '127.0.0.1';
$dbName = getenv('DB_NAME') ?: 'donappetit';
$username = getenv('DB_USER');
$password = getenv('DB_PASS');

if ($username === false) {
    $username = 'root';
}

if ($password === false) {
    $password = '';
}

$dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $host, $dbName);

try {
    return new \PDO(
        $dsn,
        $username,
        $password,
        [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        ]
    );
} catch (\PDOException $exception) {
    throw new \RuntimeException('Error de conexion: ' . $exception->getMessage(), 0, $exception);
}