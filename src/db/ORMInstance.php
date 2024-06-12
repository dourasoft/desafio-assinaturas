<?php


class ORMInstance
{
    private static $INSTANCE;

    private PDO $pdo;

    private function __construct()
    {
        $this->pdo = new PDO("pgsql:host=localhost;port=5432;dbname=assinaturas", "postgres", "123");
    }

    public static function getInstance() {
        return self::$INSTANCE ?? (self::$INSTANCE = new ORMInstance());
    }


    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    public function makeStatement(string $statement): PDOStatement
    {
        return $this->getPdo()->prepare($statement);
    }

    public function beginTransaction(): void
    {
        $this->pdo->beginTransaction();
    }

    public function commit(): void{
        $this->pdo->commit();
    }

    public function rollBack(): void{
        $this->pdo->rollBack();
    }
}