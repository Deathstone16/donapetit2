<?php
class Model {
  protected static PDO $db;
  protected string $table;
  protected string $pk = 'id';
  // Establece la conexión PDO (debe llamarse una vez al iniciar la aplicación)
  public static function setConnection(PDO $pdo){ self::$db = $pdo; }
  // Busca un registro por su clave primaria
  public function find($id){
    $stmt = self::$db->prepare("SELECT * FROM {$this->table} WHERE {$this->pk}=? LIMIT 1");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
  // Devuelve todos los registros con paginación
  public function all($limit=100, $offset=0){
    $stmt = self::$db->prepare("SELECT * FROM {$this->table} LIMIT ? OFFSET ?");
    $stmt->bindValue(1,(int)$limit,PDO::PARAM_INT);
    $stmt->bindValue(2,(int)$offset,PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  // Inserta un nuevo registro
  public function insert(array $data){
    $cols = array_keys($data);
    $ph   = array_fill(0, count($cols), '?');
    $sql  = "INSERT INTO {$this->table} (".implode(',',$cols).") VALUES (".implode(',',$ph).")";
    $stmt = self::$db->prepare($sql);
    $stmt->execute(array_values($data));
    return self::$db->lastInsertId();
  }
  // Actualiza un registro por su clave primaria
  public function update($id, array $data){
    $sets = implode(',', array_map(fn($c)=>"$c=?", array_keys($data)));
    $sql  = "UPDATE {$this->table} SET $sets WHERE {$this->pk}=?";
    $stmt = self::$db->prepare($sql);
    $vals = array_values($data); $vals[] = $id;
    return $stmt->execute($vals);
  }
  // Elimina un registro por su clave primaria
  public function delete($id){
    $stmt = self::$db->prepare("DELETE FROM {$this->table} WHERE {$this->pk}=?");
    return $stmt->execute([$id]);
  }
}
