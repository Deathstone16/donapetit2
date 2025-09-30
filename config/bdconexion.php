<?php
declare(strict_types=1);

$host = 'localhost';
$dbName = 'donapetit';
$username = 'usuario';
$password = 'contrasena';

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