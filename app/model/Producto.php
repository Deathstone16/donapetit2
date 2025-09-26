<?php
require_once "Model.php";

class Producto extends Model {
    // Nombre de la tabla.
    protected string $table = "productos";
    // Clave primaria.
    protected string $pk    = "id_producto";

    // Método específico para insertar un producto.
    public function crear($nombre, $unidad) {
        return $this->insert([
            'nom_producto' => $nombre,
            'unidad'       => $unidad
        ]);
    }

    // Método específico para actualizar un producto.
    public function actualizarProducto($id, $nombre, $unidad) {
        return $this->update($id, [
            'nom_producto' => $nombre,
            'unidad'       => $unidad
        ]);
    }
    // Método específico para buscar productos por nombre.
    public function encontrarPorNombre(string $nombre): array {
        $stmt = self::$db->prepare(
            "SELECT * FROM {$this->table} WHERE nom_producto LIKE ?"
        );
        $stmt->execute(["%" . $nombre . "%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Método específico para eliminar un producto por ID.
    public function eliminarPorId($id) {
        return $this->delete($id);
    }

    //Buscar por ID.
    public function encontrarPorId($id): mixed {   //“Esta función puede devolver más de un tipo de valor”.
        return $this->find($id);
        
    }    
}
 