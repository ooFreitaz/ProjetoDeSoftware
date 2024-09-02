<?php
class Connection {
    private $host = 'localhost';
    private $dbname = 'BD_PROJETOSOFTWARE';
    private $username = 'root';
    private $password = '';
    private $connection;

    public function getConnection() {
        if ($this->connection === null) {
            try {
                $this->connection = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Conexão falhou: " . $e->getMessage());
            }
        }
        return $this->connection;
    }
}
?>