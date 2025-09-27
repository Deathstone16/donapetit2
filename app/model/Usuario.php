<?php
require_once "Model.php";

class Usuario extends Model {
    // Nombre de la tabla
    protected string $table = "usuarios";
    // Clave primaria
    protected string $pk    = "id_usuario";

    // Crear un usuario
    public function crear($nombre, $email, $password, $rol, $telefono, $lat, $lng, $activo) {
        // Encriptamos la contraseña antes de guardar
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        return $this->insert([
            'Nombre'      => $nombre,
            'Email'       => $email,
            'Contraseña'  => $passwordHash,
            'rol'         => $rol,
            'telefono'    => $telefono,
            'Latitud'     => $lat,
            'Longitud'    => $lng,
            'activo'      => $activo
        ]);
    }

    // Actualizar usuario
    public function actualizarUsuario($id, $nombre, $email, $rol, $telefono, $lat, $lng, $activo, $password = null) {
        $data = [
            'Nombre'      => $nombre,
            'Email'       => $email,
            'rol'         => $rol,
            'telefono'    => $telefono,
            'Latitud'     => $lat,
            'Longitud'    => $lng,
            'activo'      => $activo
        ];

        // Solo actualiza la contraseña si viene una nueva
        if ($password !== null) {
            $data['Contraseña'] = password_hash($password, PASSWORD_BCRYPT);
        }  //Hacerlo con funcionalidad de recuperar contraseña.

        return $this->update($id, $data);
    }

    // Buscar por ID
    public function encontrarPorId($id): array|null {
        return $this->find($id);
    }

    // Buscar por Email (para login)
    public function findByEmail(string $email): array|null {
        $stmt = self::$db->prepare(
            "SELECT * FROM {$this->table} WHERE Email = ? LIMIT 1"
        );
        $stmt->execute([$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    // Eliminar usuario
    public function eliminarUsuario($id): bool {
        return $this->delete($id);
    }
}
