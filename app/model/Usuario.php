<?php
require_once "Model.php";

/**
 * Modelo Usuario para la tabla 'usuarios'.
 * Proporciona métodos CRUD y utilidades específicas para la entidad usuario.
 */
class Usuario extends Model {
    /**
     * Nombre de la tabla asociada al modelo.
     * @var string
     */
    protected string $table = "usuarios";

    /**
     * Nombre de la clave primaria de la tabla.
     * @var string
     */
    protected string $pk    = "id_usuario";

    /**
     * Crea un nuevo usuario en la base de datos.
     *
     * @param string $nombre     Nombre del usuario.
     * @param string $email      Correo electrónico.
     * @param string $password   Contraseña en texto plano.
     * @param string $rol        Rol del usuario.
     * @param string $telefono   Teléfono de contacto.
     * @param float  $lat        Latitud.
     * @param float  $lng        Longitud.
     * @param int    $activo     Estado de activación (1=activo, 0=inactivo).
     * @return string            ID del nuevo registro insertado.
     */
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

    /**
     * Actualiza los datos de un usuario existente.
     *
     * @param mixed  $id         ID del usuario a actualizar.
     * @param string $nombre     Nuevo nombre.
     * @param string $email      Nuevo correo electrónico.
     * @param string $rol        Nuevo rol.
     * @param string $telefono   Nuevo teléfono.
     * @param float  $lat        Nueva latitud.
     * @param float  $lng        Nueva longitud.
     * @param int    $activo     Nuevo estado de activación.
     * @param string|null $password Nueva contraseña (opcional).
     * @return bool              true si la actualización fue exitosa, false en caso contrario.
     */
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

    /**
     * Busca un usuario por su ID.
     *
     * @param mixed $id  ID del usuario a buscar.
     * @return array|null Array asociativo con los datos del usuario o null si no existe.
     */
    public function encontrarPorId($id): array|null {
        return $this->find($id);
    }

    /**
     * Busca un usuario por su correo electrónico.
     *
     * @param string $email  Correo electrónico a buscar.
     * @return array|null    Array asociativo con los datos del usuario o null si no existe.
     */
    public function findByEmail(string $email): array|null {
        $stmt = self::$db->prepare(
            "SELECT * FROM {$this->table} WHERE Email = ? LIMIT 1"
        );
        $stmt->execute([$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Elimina un usuario por su ID.
     *
     * @param mixed $id  ID del usuario a eliminar.
     * @return bool      true si la eliminación fue exitosa, false en caso contrario.
     */
    public function eliminarUsuario($id): bool {
        return $this->delete($id);
    }
}
