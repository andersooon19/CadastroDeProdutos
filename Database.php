<?php 

class DatabaseProdutos {
    private $host = 'localhost';
    private $dbname = 'produtos';
    private $username = 'root';
    private $password = '';
    private $pdo;

    public function getConnection() {
        $this->pdo = null;
        
        try {
            $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);

            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception("Erro ao conectar com o banco de dados: " . $e->getMessage());
        }
        return $this->pdo;
    }
}

?>