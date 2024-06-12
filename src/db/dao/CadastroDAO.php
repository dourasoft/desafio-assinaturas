<?php

include_once "DAO.php";
include_once "src/db/ORMInstance.php";
include_once "src/controller/dto/CadastroDTO.php";

/**
 * @implements DAO<CadastroDTO>
 */
class CadastroDAO implements DAO
{
    private static CadastroDAO $INSTANCE;
    public static function getInstance() {
        return self::$INSTANCE ?? (self::$INSTANCE = new CadastroDAO());
    }


    private function __construct() {}

    /**
     * @throws Exception
     */
    function getAll()
    {
       $orm = ORMInstance::getInstance();

       $statement = $orm->makeStatement("SELECT * FROM cadastros");
        if($statement->execute()){
            $data = $statement->fetchAll();
            $toReturn = array();

            foreach($data as $dto){
                $cadastro = new CadastroDTO();
                $cadastro->setId($dto["id"])
                    ->setNome($dto["nome"])
                    ->setEmail($dto["email"])
                    ->setTelefone($dto["telefone"]);

                $toReturn[] = $cadastro;
            }
            return $toReturn;
        }
        throw new Exception("Falha ao buscar os cadastros");
    }

    function getById($id)
    {
        $orm = ORMInstance::getInstance();
        $statement = $orm->makeStatement("SELECT * FROM cadastros WHERE id = ?");
        $statement->bindValue(1, $id);
        if($statement->execute()){
            $data = $statement->fetch();
            $dto = new CadastroDTO();
            $dto->setId($data['id'] ?? throw new Exception("Falha ao buscar o cadastro com id = ". $id))
                ->setNome($data['nome'])
                ->setEmail($data['email'])
                ->setTelefone($data['telefone']);
            return $dto;
        }
        throw new Exception("Falha ao buscar o cadastro com id = ". $id);
    }

    function insert($obj)
    {
        $orm = ORMInstance::getInstance();
        $orm->beginTransaction();

        $statement = $orm->makeStatement("INSERT INTO cadastros (nome, email, telefone) VALUES (?, ?, ?)");
        $statement->bindValue(1, $obj->getNome());
        $statement->bindValue(2, $obj->getEmail());
        $statement->bindValue(3, $obj->getTelefone());
        if($statement->execute()){
            $orm->commit();
            return;
        }
        $orm->rollBack();
        throw new Exception("Falha ao inserir o cadastro");
    }

    function update($obj)
    {
        $orm = ORMInstance::getInstance();
        $orm->beginTransaction();
        $statement = $orm->makeStatement("UPDATE cadastros SET id = ?,nome = ?, email = ?, telefone = ? where id = ?");
        $statement->bindValue(1, $obj->getId());
        $statement->bindValue(2, $obj->getNome());
        $statement->bindValue(3, $obj->getEmail());
        $statement->bindValue(4, $obj->getTelefone());
        $statement->bindValue(5, $obj->getId());
        if($statement->execute()){
            $orm->commit();
            return;
        }
        $orm->rollBack();
        throw new Exception("Falha ao atualizar o cadastro");
    }

    function delete($obj)
    {
        $orm = ORMInstance::getInstance();
        $orm->beginTransaction();
        $statement = $orm->makeStatement("DELETE FROM cadastros WHERE id = ?");
        $statement->bindValue(1, $obj->getId());
        if($statement->execute()){
            $orm->commit();
            return;
        }
        $orm->rollBack();
        throw new Exception("Falha ao deletar o cadastro");
    }
}