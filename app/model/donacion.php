<?php
require_once "Model.php";

/**
 * Clase Donacion
 * Maneja las operaciones sobre la tabla `donacion`
 */
class Donacion extends Model {
    protected string $table = "donacion";
    protected string $pk    = "id_donacion";

    /**
     * Crear una donación
     *
     * @param int $idProducto ID del producto donado
     * @param int $cantidad Cantidad donada
     * @param string $fecha Fecha y hora de publicación (YYYY-MM-DD HH:MM:SS)
     * @param string $estado Estado de la donación ("DISPONIBLE", "ENTREGADO")
     * @return int|false ID generado o false si falla
     */
    public function crear($idProducto, $cantidad, $fecha, $estado = "DISPONIBLE") {
        return $this->insert([
            'id_producto'     => $idProducto,
            'cantidad_donado' => $cantidad,
            'fecha_publicacion' => $fecha,
            'estado'          => $estado
        ]);
    }

    /**
     * Actualizar estado de una donación
     *
     * @param int $idDonacion
     * @param string $estado
     * @return bool
     */
    public function actualizarEstado($idDonacion, $estado) {
        return $this->update($idDonacion, ['estado' => $estado]);
    }

    /**
     * Buscar donaciones por producto
     *
     * @param int $idProducto
     * @return array
     */
    public function buscarPorProducto($idProducto) {
        $stmt = self::$db->prepare("SELECT * FROM {$this->table} WHERE id_producto = ?");
        $stmt->execute([$idProducto]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Eliminar donación
     *
     * @param int $idDonacion
     * @return bool
     */
    public function eliminarDonacion($idDonacion) {
        return $this->delete($idDonacion);
    }
}
