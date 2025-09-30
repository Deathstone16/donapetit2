<?php
declare(strict_types=1);

require_once __DIR__ . '/../model/Producto.php';

/**
 * Controlador que maneja las operaciones CRUD basicas de productos.
 */
class ProductoController
{
    private Producto $productoModel;

    public function __construct()
    {
        $this->productoModel = new Producto();
    }

    /**
     * Lista los productos con una paginacion simple.
     */
    public function index(): void
    {
        $page = max(1, (int)($_GET['page'] ?? 1));
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $productos = Producto::all($limit, $offset);

        require __DIR__ . '/../view/products/index.php';
    }

    /**
     * Muestra el formulario de creacion.
     */
    public function create(): void
    {
        require __DIR__ . '/../view/products/product_load.php';
    }

    /**
     * Procesa el formulario y guarda un nuevo producto.
     */
    public function store(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            header('Location: index.php?controller=Producto&action=create');
            exit;
        }

        $nombre = trim($_POST['nombre'] ?? '');
        $unidad = trim($_POST['unidad'] ?? '');

        if ($nombre === '' || $unidad === '') {
            $_SESSION['error'] = 'Todos los campos son obligatorios.';
            header('Location: index.php?controller=Producto&action=create');
            exit;
        }

        try {
            $id = $this->productoModel->crear($nombre, $unidad);
            $_SESSION['success'] = 'Producto creado con exito (ID: ' . $id . ').';
        } catch (\Throwable $exception) {
            $_SESSION['error'] = 'No se pudo crear el producto. Intenta mas tarde.';
        }

        header('Location: index.php?controller=Producto&action=index');
        exit;
    }

    /**
     * Muestra un producto en detalle.
     */
    public function show(): void
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?controller=Producto&action=index');
            exit;
        }

        $producto = $this->productoModel->encontrarPorId($id);
        if (!$producto) {
            $_SESSION['error'] = 'Producto no encontrado.';
            header('Location: index.php?controller=Producto&action=index');
            exit;
        }

        $view = __DIR__ . '/../view/products/show.php';
        if (!file_exists($view)) {
            $_SESSION['error'] = 'Vista no disponible.';
            header('Location: index.php?controller=Producto&action=index');
            exit;
        }

        require $view;
    }

    /**
     * Muestra el formulario de edicion.
     */
    public function edit(): void
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?controller=Producto&action=index');
            exit;
        }

        $producto = $this->productoModel->encontrarPorId($id);
        if (!$producto) {
            $_SESSION['error'] = 'Producto no encontrado.';
            header('Location: index.php?controller=Producto&action=index');
            exit;
        }

        $view = __DIR__ . '/../view/products/edit.php';
        if (!file_exists($view)) {
            $_SESSION['error'] = 'Vista no disponible.';
            header('Location: index.php?controller=Producto&action=index');
            exit;
        }

        require $view;
    }

    /**
     * Procesa el formulario de edicion.
     */
    public function update(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            header('Location: index.php?controller=Producto&action=index');
            exit;
        }

        $id = $_POST['id'] ?? null;
        $nombre = trim($_POST['nombre'] ?? '');
        $unidad = trim($_POST['unidad'] ?? '');

        if (!$id || $nombre === '' || $unidad === '') {
            $_SESSION['error'] = 'Datos invalidos.';
            header('Location: index.php?controller=Producto&action=edit&id=' . urlencode((string)$id));
            exit;
        }

        $updated = $this->productoModel->actualizarProducto($id, $nombre, $unidad);

        $_SESSION['success'] = $updated ? 'Producto actualizado.' : 'No se pudo actualizar.';
        header('Location: index.php?controller=Producto&action=index');
        exit;
    }

    /**
     * Elimina un producto.
     */
    public function destroy(): void
    {
        $id = $_GET['id'] ?? null;
        if ($id && $this->productoModel->eliminarPorId($id)) {
            $_SESSION['success'] = 'Producto eliminado.';
        } else {
            $_SESSION['error'] = 'No se pudo eliminar el producto.';
        }

        header('Location: index.php?controller=Producto&action=index');
        exit;
    }
}