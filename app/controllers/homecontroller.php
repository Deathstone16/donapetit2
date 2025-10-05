<?php
declare(strict_types=1);

require_once __DIR__ . '/controller.php';

/**
 * Controlador responsable de la pagina inicial del panel.
 */
class HomeController extends Controller
{
    /**
     * Muestra la vista de bienvenida del sistema.
     *
     * @return void
     */
    public function index(): void
    {
        $userName = $_SESSION['user']['name'] ?? 'Usuario';

        $this->render('home.index', compact('userName'));
    }
}

