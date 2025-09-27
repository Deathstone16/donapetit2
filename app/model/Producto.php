<?php
require_once "Model.php";

/**
 * Modelo Producto para la tabla 'productos'.
 * Proporciona métodos CRUD específicos para la entidad producto.
 */
class Producto extends Model {
    /**
     * Nombre de la tabla asociada al modelo.
     * @var string
     */
    protected string $table = "productos";

    /**
     * Nombre de la clave primaria de la tabla.
     * @var string
     */
    protected string $pk    = "id_producto";

    /**
     * Inserta un nuevo producto en la base de datos.
     *
     * @param string $nombre  Nombre del producto.
     * @param string $unidad  Unidad de medida del producto.
     * @return string         ID del nuevo registro insertado.
     */
    public function crear($nombre, $unidad) {
        return $this->insert([
            'nom_producto' => $nombre,
            'unidad'       => $unidad
        ]);
    }

    /**
     * Actualiza los datos de un producto existente.
     *
     * @param mixed  $id      ID del producto a actualizar.
     * @param string $nombre  Nuevo nombre del producto.
     * @param string $unidad  Nueva unidad de medida.
     * @return bool           true si la actualización fue exitosa, false en caso contrario.
     */
    public function actualizarProducto($id, $nombre, $unidad) {
        return $this->update($id, [
            'nom_producto' => $nombre,
            'unidad'       => $unidad
        ]);
    }

    /**
     * Busca productos por nombre (búsqueda parcial).
     *
     * @param string $nombre  Nombre (o parte) del producto a buscar.
     * @return array          Lista de productos encontrados como arrays asociativos.
     */
    public function encontrarPorNombre(string $nombre): array {
        $stmt = self::$db->prepare(
            "SELECT * FROM {$this->table} WHERE nom_producto LIKE ?"
        );
        $stmt->execute(["%" . $nombre . "%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Elimina un producto por su ID.
     *
     * @param mixed $id  ID del producto a eliminar.
     * @return bool      true si la eliminación fue exitosa, false en caso contrario.
     */
    public function eliminarPorId($id) {
        return $this->delete($id);
    }

    /**
     * Busca un producto por su ID.
     *
     * @param mixed $id  ID del producto a buscar.
     * @return mixed     Array asociativo con los datos del producto o false si no existe.
     */
    public function encontrarPorId($id): mixed {
        return $this->find($id);
    }
}
