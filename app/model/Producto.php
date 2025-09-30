<?php
declare(strict_types=1);

require_once __DIR__ . '/model.php';

/**
 * Modelo Producto para administrar la tabla productos.
 */
class Producto extends Model
{
    /** @var string Nombre de la tabla asociada */
    protected string $table = 'productos';

    /** @var string Nombre de la clave primaria */
    protected string $pk = 'id_producto';

    /**
     * Crea un nuevo producto a partir de los datos recibidos.
     */
    public function create(array $data): string
    {
        return $this->insert($data);
    }

    /**
     * Atajo de dominio para crear un producto con nombre y unidad.
     */
    public function crear(string $nombre, string $unidad): string
    {
        return $this->create([
            'nom_producto' => $nombre,
            'unidad' => $unidad,
        ]);
    }

    /**
     * Actualiza un producto existente con los valores proporcionados.
     */
    public function actualizarProducto($id, string $nombre, string $unidad): bool
    {
        return $this->update($id, [
            'nom_producto' => $nombre,
            'unidad' => $unidad,
        ]);
    }

    /**
     * Busca productos cuyo nombre coincida parcialmente con el parametro.
     */
    public function encontrarPorNombre(string $nombre): array
    {
        self::initDb();

        $stmt = self::$db->prepare(
            'SELECT * FROM ' . $this->table . ' WHERE nom_producto LIKE ?'
        );
        $stmt->execute(['%' . $nombre . '%']);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Devuelve un producto usando su identificador.
     */
    public function encontrarPorId($id)
    {
        return $this->find($id);
    }

    /**
     * Elimina un producto por su identificador.
     */
    public function eliminarPorId($id): bool
    {
        return $this->delete($id);
    }

    /**
     * Reexpone la lista de productos permitiendo paginacion.
     */
    public static function all(int $limit = 100, int $offset = 0): array
    {
        return parent::all($limit, $offset);
    }
}