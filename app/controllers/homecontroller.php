<?php
declare(strict_types=1);

class HomeController
{
    public function index(): void
    {
        require __DIR__ . '/../view/home/index.php';
    }
}