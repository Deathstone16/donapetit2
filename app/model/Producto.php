<?php
declare(strict_types=1);

require_once __DIR__ . '/model.php';

/**
 * Modelo Producto para administrar la tabla productos.
 */
class Producto extends Model
{
    protected string $table = 'productos';
    protected string $pk = 'id_producto';

    /**
     * Crea un nuevo producto con los campos soportados por el esquema actual.
     */
    public function crear(
        string $nombre,
        string $unidad,
        ?int $cantidad = null,
        ?string $fechaVencimiento = null,
        ?string $comentarios = null,
        ?string $estado = null
    ): string {
        $payload = [
            'nom_producto' => $nombre,
            'unidad' => $unidad,
        ];

        if ($cantidad !== null) {
            $payload['cantidad'] = $cantidad;
        }
        if ($fechaVencimiento !== null) {
            $payload['fecha_vencimiento'] = $fechaVencimiento;
        }
        if ($comentarios !== null) {
            $payload['comentarios'] = $comentarios;
        }
        $payload['estado'] = $estado ?? 'DISPONIBLE';

        return $this->insert($payload);
    }

    /**
     * Actualiza un producto existente con los valores proporcionados.
     */
    public function actualizarProducto(
        $id,
        string $nombre,
        string $unidad,
        ?int $cantidad = null,
        ?string $fechaVencimiento = null,
        ?string $comentarios = null,
        ?string $estado = null
    ): bool {
        $payload = [
            'nom_producto' => $nombre,
            'unidad' => $unidad,
        ];

        $payload['cantidad'] = $cantidad;
        $payload['fecha_vencimiento'] = $fechaVencimiento;
        $payload['comentarios'] = $comentarios;

        if ($estado !== null) {
            $payload['estado'] = $estado;
        }

        return $this->update($id, $payload);
    }

    public function encontrarPorNombre(string $nombre): array
    {
        self::initDb();

        $stmt = self::$db->prepare(
            'SELECT * FROM ' . $this->table . ' WHERE nom_producto LIKE ?'
        );
        $stmt->execute(['%' . $nombre . '%']);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function encontrarPorId($id)
    {
        return $this->find($id);
    }

    public function eliminarPorId($id): bool
    {
        return $this->delete($id);
    }

    public static function all(int $limit = 100, int $offset = 0): array
    {
        return parent::all($limit, $offset);
    }
}