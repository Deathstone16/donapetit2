<?php
/**
 * Clase base Model para operaciones CRUD usando PDO.
 * Provee métodos genéricos para interactuar con una tabla de base de datos.
 */
class Model {
  /** 
   * Instancia PDO compartida para la conexión a la base de datos.
   * @var PDO
   */
  protected static PDO $db;

  /**
   * Nombre de la tabla asociada al modelo.
   * @var string
   */
  protected string $table;

  /**
   * Nombre de la clave primaria de la tabla.
   * @var string
   */
  protected string $pk = 'id';

  /**
   * Establece la conexión PDO (debe llamarse una vez al iniciar la aplicación).
   * @param PDO $pdo Instancia de PDO ya configurada.
   * @return void
   */
  public static function setConnection(PDO $pdo){ self::$db = $pdo; }

  /**
   * Busca un registro por su clave primaria.
   * @param mixed $id Valor de la clave primaria.
   * @return array|false Registro encontrado como array asociativo o false si no existe.
   */
  public function find($id){
    $stmt = self::$db->prepare("SELECT * FROM {$this->table} WHERE {$this->pk}=? LIMIT 1");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  /**
   * Devuelve todos los registros con paginación.
   * @param int $limit Número máximo de registros a devolver.
   * @param int $offset Número de registros a omitir.
   * @return array Lista de registros como arrays asociativos.
   */
  public function all($limit=100, $offset=0){
    $stmt = self::$db->prepare("SELECT * FROM {$this->table} LIMIT ? OFFSET ?");
    $stmt->bindValue(1,(int)$limit,PDO::PARAM_INT);
    $stmt->bindValue(2,(int)$offset,PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Inserta un nuevo registro en la tabla.
   * @param array $data Datos a insertar (clave => valor).
   * @return string El ID del nuevo registro insertado.
   */
  public function insert(array $data){
    $cols = array_keys($data);
    $ph   = array_fill(0, count($cols), '?');
    $sql  = "INSERT INTO {$this->table} (".implode(',',$cols).") VALUES (".implode(',',$ph).")";
    $stmt = self::$db->prepare($sql);
    $stmt->execute(array_values($data));
    return self::$db->lastInsertId();
  }

  /**
   * Actualiza un registro por su clave primaria.
   * @param mixed $id Valor de la clave primaria.
   * @param array $data Datos a actualizar (clave => valor).
   * @return bool true en caso de éxito, false en caso contrario.
   */
  public function update($id, array $data){
    $sets = implode(',', array_map(fn($c)=>"$c=?", array_keys($data)));
    $sql  = "UPDATE {$this->table} SET $sets WHERE {$this->pk}=?";
    $stmt = self::$db->prepare($sql);
    $vals = array_values($data); $vals[] = $id;
    return $stmt->execute($vals);
  }

  /**
   * Elimina un registro por su clave primaria.
   * @param mixed $id Valor de la clave primaria.
   * @return bool true en caso de éxito, false en caso contrario.
   */
  public function delete($id){
    $stmt = self::$db->prepare("DELETE FROM {$this->table} WHERE {$this->pk}=?");
    return $stmt->execute([$id]);
  }
}
