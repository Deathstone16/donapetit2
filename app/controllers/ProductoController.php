<?php
declare(strict_types=1);

require_once __DIR__ . '/../model/Producto.php';
require_once __DIR__ . '/controller.php';

class ProductoController extends Controller
{
    private Producto $productoModel;

    public function __construct()
    {
        $this->productoModel = new Producto();
    }

    public function index(): void
    {
        $page = max(1, (int)($_GET['page'] ?? 1));
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $productos = Producto::all($limit, $offset);
        $this->render('products.index', compact('productos', 'page'));
    }

    public function create(): void
    {
        $this->render('products.product_load');
    }

    public function store(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            $this->redirect('index.php?controller=Producto&action=create');
        }

        $nombre = trim($_POST['nombre'] ?? '');
        $unidad = trim($_POST['unidad'] ?? '');
        $cantidad = $_POST['cantidad'] ?? null;
        $fechaVencimiento = trim($_POST['vencimiento'] ?? '');
        $comentarios = trim($_POST['comentarios'] ?? '');

        $errores = [];

        if ($nombre === '') {
            $errores[] = 'El nombre del producto es obligatorio.';
        }
        if ($unidad === '') {
            $errores[] = 'La unidad es obligatoria.';
        }

        if ($cantidad === '' || $cantidad === null) {
            $cantidad = null;
        } else {
            if (!ctype_digit((string)$cantidad) || (int)$cantidad <= 0) {
                $errores[] = 'La cantidad debe ser un entero positivo.';
            } else {
                $cantidad = (int)$cantidad;
            }
        }

        if ($fechaVencimiento === '') {
            $fechaVencimiento = null;
        } else {
            $fecha = \DateTime::createFromFormat('Y-m-d', $fechaVencimiento);
            if (!$fecha || $fecha->format('Y-m-d') !== $fechaVencimiento) {
                $errores[] = 'La fecha de vencimiento no tiene un formato valido (AAAA-MM-DD).';
            }
        }

        if ($comentarios === '') {
            $comentarios = null;
        }

        if (!empty($errores)) {
            $_SESSION['error'] = implode(' ', $errores);
            $this->redirect('index.php?controller=Producto&action=create');
        }

        try {
            $id = $this->productoModel->crear($nombre, $unidad, $cantidad, $fechaVencimiento, $comentarios);
            $_SESSION['success'] = 'Producto creado con exito (ID: ' . $id . ').';
        } catch (\Throwable $exception) {
            $_SESSION['error'] = 'No se pudo crear el producto. Intenta mas tarde.';
        }

        $this->redirect('index.php?controller=Producto&action=index');
    }

    public function show(): void
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $this->redirect('index.php?controller=Producto&action=index');
        }

        $producto = $this->productoModel->encontrarPorId($id);
        if (!$producto) {
            $_SESSION['error'] = 'Producto no encontrado.';
            $this->redirect('index.php?controller=Producto&action=index');
        }

        $this->render('products.show', compact('producto'));
    }

    public function edit(): void
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $this->redirect('index.php?controller=Producto&action=index');
        }

        $producto = $this->productoModel->encontrarPorId($id);
        if (!$producto) {
            $_SESSION['error'] = 'Producto no encontrado.';
            $this->redirect('index.php?controller=Producto&action=index');
        }

        $this->render('products.edit', compact('producto'));
    }

    public function update(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            $this->redirect('index.php?controller=Producto&action=index');
        }

        $id = $_POST['id'] ?? null;
        $nombre = trim($_POST['nombre'] ?? '');
        $unidad = trim($_POST['unidad'] ?? '');
        $cantidad = $_POST['cantidad'] ?? null;
        $fechaVencimiento = trim($_POST['vencimiento'] ?? '');
        $comentarios = trim($_POST['comentarios'] ?? '');
        $estado = isset($_POST['estado']) ? trim($_POST['estado']) : null;

        if (!$id) {
            $_SESSION['error'] = 'Identificador de producto invalido.';
            $this->redirect('index.php?controller=Producto&action=index');
        }

        $errores = [];

        if ($nombre === '') {
            $errores[] = 'El nombre del producto es obligatorio.';
        }
        if ($unidad === '') {
            $errores[] = 'La unidad es obligatoria.';
        }

        if ($cantidad === '' || $cantidad === null) {
            $cantidad = null;
        } else {
            if (!ctype_digit((string)$cantidad) || (int)$cantidad <= 0) {
                $errores[] = 'La cantidad debe ser un entero positivo.';
            } else {
                $cantidad = (int)$cantidad;
            }
        }

        if ($fechaVencimiento === '') {
            $fechaVencimiento = null;
        } else {
            $fecha = \DateTime::createFromFormat('Y-m-d', $fechaVencimiento);
            if (!$fecha || $fecha->format('Y-m-d') !== $fechaVencimiento) {
                $errores[] = 'La fecha de vencimiento no tiene un formato valido (AAAA-MM-DD).';
            }
        }

        if ($comentarios === '') {
            $comentarios = null;
        }

        if ($estado === '') {
            $estado = null;
        }

        if (!empty($errores)) {
            $_SESSION['error'] = implode(' ', $errores);
            $this->redirect('index.php?controller=Producto&action=edit&id=' . urlencode((string)$id));
        }

        $ok = $this->productoModel->actualizarProducto($id, $nombre, $unidad, $cantidad, $fechaVencimiento, $comentarios, $estado);

        $_SESSION['success'] = $ok ? 'Producto actualizado.' : 'No se pudo actualizar.';
        $this->redirect('index.php?controller=Producto&action=index');
    }

    public function destroy(): void
    {
        $id = $_GET['id'] ?? null;
        if ($id && $this->productoModel->eliminarPorId($id)) {
            $_SESSION['success'] = 'Producto eliminado.';
        } else {
            $_SESSION['error'] = 'No se pudo eliminar el producto.';
        }

        $this->redirect('index.php?controller=Producto&action=index');
    }
}