<?php
declare(strict_types=1);

require_once __DIR__ . '/controller.php';

/**
 * Controlador de autenticación: login y registro.
 *
 * Provee acciones para renderizar los formularios de acceso y registro
 * utilizando las vistas Tailwind existentes en app/view/auth.
 */
class AuthController extends Controller
{
    /**
     * Muestra el formulario de inicio de sesión.
     *
     * @return void
     */
    public function login(): void
    {
        $action = 'index.php?controller=Auth&action=authenticate';
        $registerUrl = 'index.php?controller=Auth&action=register';
        $forgotUrl = '#';

        $this->render('auth.login', compact('action', 'registerUrl', 'forgotUrl'));
    }

    /**
     * Muestra el formulario de registro de usuario.
     *
     * @return void
     */
    public function register(): void
    {
        $action = 'index.php?controller=Auth&action=store';
        $loginUrl = 'index.php?controller=Auth&action=login';

        $this->render('auth.register', compact('action', 'loginUrl'));
    }

    /**
     * Procesa el inicio de sesión (simulado/placeholder).
     * Implementación mínima: establece usuario en sesión y redirige.
     *
     * @return void
     */
    public function authenticate(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            $this->redirect('index.php?controller=Auth&action=login');
        }

        // Placeholder básico: en un proyecto real, validar credenciales y hash.
        $username = trim((string)($_POST['username'] ?? ''));
        $_SESSION['user'] = [
            'name' => $username !== '' ? $username : 'Usuario',
        ];

        $this->redirect('index.php?controller=Home&action=index');
    }

    /**
     * Procesa el registro (simulado/placeholder).
     * En un caso real, persistiría en la base y validaría datos.
     *
     * @return void
     */
    public function store(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            $this->redirect('index.php?controller=Auth&action=register');
        }

        $username = trim((string)($_POST['username'] ?? ''));
        $_SESSION['user'] = [
            'name' => $username !== '' ? $username : 'Usuario',
        ];

        $this->redirect('index.php?controller=Home&action=index');
    }

    /**
     * Cierra la sessi��n actual y redirige al login.
     */
    public function logout(): void
    {
        $_SESSION = [];
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }

        $this->redirect('index.php?controller=Auth&action=login');
    }
}
