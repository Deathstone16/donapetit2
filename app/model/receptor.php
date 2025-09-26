
<?php
require_once "Model.php";

class Receptor extends Model {
    // Nombre de la tabla
    protected string $table = "receptores";  // 👈 usa el nombre real de tu tabla
    // Clave primaria
    protected string $pk    = "id_usu_receptor"; // 👈 usa el nombre real de tu clave primaria

    // Crear un receptor
    public function crear($renacom, $institucion, $responsable) {
        return $this->insert([
            'num_renacom'    => $renacom,
            'nom_institucion'=> $institucion,
            'responsable'    => $responsable
        ]);
    }

    // Actualizar un receptor
    public function actualizarReceptor($id, $renacom, $institucion, $responsable) { 
        return $this->update($id, [
            'num_renacom'    => $renacom,
            'nom_institucion'=> $institucion,
            'responsable'    => $responsable
        ]);
    }

    // Buscar receptor por RENACOM
    public function encontrarPorId($renacom): array|null {
        return $this->find($renacom); // devuelve array|null
    }

    // Buscar receptor por nombre de institución
    public function encontrarPorInst(string $institucion): array {
        $stmt = self::$db->prepare(
            "SELECT * FROM {$this->table} WHERE nom_institucion LIKE ?"
        );
        $stmt->execute(["%" . $institucion . "%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Eliminar receptor
    public function eliminarReceptor($id): bool {
        return $this->delete($id);
    }
}

