<?php
declare(strict_types=1);

require_once __DIR__ . '/controller.php';

class HomeController extends Controller
{
    public function index(): void
    {
        $userName = $_SESSION['user']['name'] ?? 'Usuario';
        $this->render('home.index', compact('userName'));
    }
}