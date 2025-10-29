<?php
declare(strict_types=1);

require_once __DIR__ . '/../model/Estadistica.php';
require_once __DIR__ . '/controller.php';

class EstadisticaController extends Controller
{
    private Estadistica $estadisticaModel;

    public function __construct()
    {
        $this->estadisticaModel = new Estadistica();
    }

    /**
     * Muestra una lista de todas las estadísticas.
     */
    public function index(): void
    {
        $page = max(1, (int)($_GET['page'] ?? 1));
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $estadisticas = Estadistica::all($limit, $offset);
        $this->render('estadisticas.index', compact('estadisticas', 'page'));
    }

    /**
     * Muestra el formulario para crear una nueva estadística.
     */
    public function create(): void
    {
        // Aquí podrías cargar datos adicionales si el formulario los necesita,
        // como una lista de donaciones para un selector.
        $this->render('estadisticas.create');
    }

    /**
     * Almacena una nueva estadística en la base de datos.
     */
    public function store(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            $this->redirect('index.php?controller=Estadistica&action=create');
        }

        // Validar y sanitizar datos de entrada
        $idDonacion = filter_input(INPUT_POST, 'id_donacion', FILTER_VALIDATE_INT);
        $total = filter_input(INPUT_POST, 'total', FILTER_VALIDATE_INT);
        $mensual = filter_input(INPUT_POST, 'mensual', FILTER_VALIDATE_INT);
        $anual = filter_input(INPUT_POST, 'anual', FILTER_VALIDATE_INT);

        $errores = [];
        if ($idDonacion === false || $idDonacion <= 0) {
            $errores[] = 'El ID de donación es inválido.';
        }
        if ($total === false || $total < 0) {
            $errores[] = 'El total donado debe ser un número.';
        }
        if ($mensual === false || $mensual < 0) {
            $errores[] = 'La frecuencia mensual debe ser un número.';
        }
        if ($anual === false || $anual < 0) {
            $errores[] = 'La frecuencia anual debe ser un número.';
        }

        if (!empty($errores)) {
            $_SESSION['error'] = implode(' ', $errores);
            $this->redirect('index.php?controller=Estadistica&action=create');
            return;
        }

        try {
            $id = $this->estadisticaModel->crear($idDonacion, $total, $mensual, $anual);
            $_SESSION['success'] = 'Estadística creada con éxito (ID: ' . $id . ').';
        } catch (\Throwable $e) {
            $_SESSION['error'] = 'No se pudo crear la estadística. Intenta más tarde.';
        }

        $this->redirect('index.php?controller=Estadistica&action=index');
    }

    /**
     * Muestra una estadística específica.
     */
    public function show(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            $this->redirect('index.php?controller=Estadistica&action=index');
        }

        $estadistica = $this->estadisticaModel->find($id);
        if (!$estadistica) {
            $_SESSION['error'] = 'Estadística no encontrada.';
            $this->redirect('index.php?controller=Estadistica&action=index');
        }

        $this->render('estadisticas.show', compact('estadistica'));
    }

    /**
     * Muestra el formulario para editar una estadística.
     */
    public function edit(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            $this->redirect('index.php?controller=Estadistica&action=index');
        }

        $estadistica = $this->estadisticaModel->find($id);
        if (!$estadistica) {
            $_SESSION['error'] = 'Estadística no encontrada.';
            $this->redirect('index.php?controller=Estadistica&action=index');
        }

        $this->render('estadisticas.edit', compact('estadistica'));
    }

    /**
     * Actualiza una estadística existente en la base de datos.
     */
    public function update(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            $this->redirect('index.php?controller=Estadistica&action=index');
            return;
        }

        // Validar y sanitizar datos de entrada
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $idDonacion = filter_input(INPUT_POST, 'id_donacion', FILTER_VALIDATE_INT);
        $total = filter_input(INPUT_POST, 'total', FILTER_VALIDATE_INT);
        $mensual = filter_input(INPUT_POST, 'mensual', FILTER_VALIDATE_INT);
        $anual = filter_input(INPUT_POST, 'anual', FILTER_VALIDATE_INT);

        $errores = [];
        if ($id === false || $id <= 0) {
            $errores[] = 'El ID de estadística es inválido.';
        }
        if ($idDonacion === false || $idDonacion <= 0) {
            $errores[] = 'El ID de donación es inválido.';
        }
        if ($total === false || $total < 0) {
            $errores[] = 'El total donado debe ser un número.';
        }
        if ($mensual === false || $mensual < 0) {
            $errores[] = 'La frecuencia mensual debe ser un número.';
        }
        if ($anual === false || $anual < 0) {
            $errores[] = 'La frecuencia anual debe ser un número.';
        }

        if (!empty($errores)) {
            $_SESSION['error'] = implode(' ', $errores);
            // Redirigir de vuelta al formulario de edición con el ID
            $this->redirect('index.php?controller=Estadistica&action=edit&id=' . ($id ?: ''));
            return;
        }

        try {
            $this->estadisticaModel->actualizar($id, $idDonacion, $total, $mensual, $anual);
            $_SESSION['success'] = 'Estadística actualizada con éxito.';
        } catch (\Throwable $e) {
            $_SESSION['error'] = 'No se pudo actualizar la estadística. Intenta más tarde.';
        }

        $this->redirect('index.php?controller=Estadistica&action=index');
    }

    /**
     * Elimina una estadística.
     */
    public function destroy(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            $_SESSION['error'] = 'ID de estadística inválido.';
            $this->redirect('index.php?controller=Estadistica&action=index');
            return;
        }

        if ($this->estadisticaModel->eliminarEstadistica($id)) {
            $_SESSION['success'] = 'Estadística eliminada correctamente.';
        } else {
            $_SESSION['error'] = 'No se pudo eliminar la estadística.';
        }

        $this->redirect('index.php?controller=Estadistica&action=index');
    }
}