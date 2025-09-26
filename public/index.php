<?php
session_start();

require __DIR__.'../app/model/Model.php';
require __DIR__.'/../app/config/bdconexion.php';

$db  = new Database();
$pdo = $db->getConnection();

// Inyecta la conexión para todos los modelos que extienden Model
Model::setConnection($pdo);

// ...router/controlador
