<?php 

class Produto {
    private $conn;
    private $table_name = "produtos";
    public $id;
    public $nome;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        if ($this->validate()) {
            $query = "INSERT INTO " . $this->table_name . " (nome) VALUES (:nome)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':nome', $this->nome);
            return $stmt->execute();
        }
        return false;
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    private function validate() {
        // Validação simples para garantir que o nome não esteja vazio e é seguro
        $this->nome = trim($this->nome);
        return !empty($this->nome);
    }
}
?>
