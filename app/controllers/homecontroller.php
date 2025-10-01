<?php
declare(strict_types=1);

// Incluye el controlador base para heredar funcionalidad común
require_once __DIR__ . '/controller.php';

// Define el controlador HomeController que maneja la página de inicio
class HomeController extends Controller
{
    // Acción principal que se ejecuta al acceder a la página de inicio
    public function index(): void
    {
        // Obtiene el nombre del usuario desde la sesión, o usa 'Usuario' por defecto si no está logueado
        $userName = $_SESSION['user']['name'] ?? 'Usuario';

        // Renderiza la vista 'home.index' y le pasa la variable $userName
        $this->render('home.index', compact('userName'));
    }
}