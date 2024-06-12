<?php

include_once "DAO.php";
include_once "CadastroDAO.php";
include_once "src/db/ORMInstance.php";
/**
 * @implements DAO<AssinaturaDTO>
 */
class AssinaturaDAO implements DAO {

    private static AssinaturaDAO $INSTANCE;

    public static function getInstance() {
        return self::$INSTANCE ?? (self::$INSTANCE = new AssinaturaDAO());
    }

    private function __construct() {}

    /**
     * @throws Exception
     */
    function getAll()
    {
        $orm = ORMInstance::getInstance();
        $statement = $orm->makeStatement("SELECT * FROM assinaturas");
        if($statement->execute()){
            $data = $statement->fetchAll();
            $toReturn = array();

            foreach($data as $dto){

                $cadastroDTO = CadastroDAO::getInstance()->getById($dto["cadastro_id"]);

                $assinatura = new AssinaturaDTO();
                $assinatura->setId($dto["id"])
                    ->setCadastro($cadastroDTO)
                    ->setDescricao($dto["descricao"])
                    ->setVencimento(date_create($dto["vencimento"]))
                    ->setValor($dto["valor"]);

                $toReturn[] = $assinatura;
            }
            return $toReturn;
        }

        throw new Exception("Falha ao buscar as assinaturas");
    }

    /**
     * @throws Exception
     */
    function getById($id)
    {
        $orm = ORMInstance::getInstance();

        $statement = $orm->makeStatement("SELECT * FROM assinaturas WHERE id = ?");
        $statement->bindValue(1,$id);

        if($statement->execute()){
            $data = $statement->fetch();

            $cadastroDTO = CadastroDAO::getInstance()->getById($data["cadastro_id"]);

            $assinatura = new AssinaturaDTO();
            $assinatura->setId($data["id"])
                ->setCadastro($cadastroDTO)
                ->setVencimento(date_create($data["vencimento"]))
                ->setDescricao($data["descricao"])
                ->setValor($data["valor"]);

            return $assinatura;
        }
        throw new Exception("Falha ao buscar a assinatura com o id " . $id);
    }

    /**
     * @throws Exception
     */
    function insert($obj): void
    {
        $orm = ORMInstance::getInstance();
        $orm->beginTransaction();
        $statement = $orm->makeStatement("INSERT INTO assinaturas(cadastro_id, descricao, valor, vencimento) VALUES (?,?,?,?)");

        $statement->bindValue(1,$obj->getCadastro()->getId());
        $statement->bindValue(2,$obj->getDescricao());
        $statement->bindValue(3,$obj->getValor());
        $statement->bindValue(4,$obj->getVencimento()->format("Y-m-d"));

        if($statement->execute()){
            $orm->commit();
            return;
        }
        $orm->rollBack();
        throw new Exception("Falha ao inserir assinatura");
    }

    /**
     * @throws Exception
     */
    function update($obj)
    {
        $orm = ORMInstance::getInstance();
        $orm->beginTransaction();
        $statement = $orm->makeStatement("UPDATE assinaturas SET id=?, cadastro_id= ?, descricao = ?, valor = ?, vencimento = ? WHERE id = ?");
        $statement->bindValue(1,$obj->getId());
        $statement->bindValue(2,$obj->getCadastro()->getId());
        $statement->bindValue(3,$obj->getDescricao());
        $statement->bindValue(4,$obj->getValor());
        $statement->bindValue(5,$obj->getVencimento()->format("Y-m-d"));
        $statement->bindValue(6,$obj->getId());

        if($statement->execute()){
            $orm->commit();
        return;
        }
        $orm->rollBack();
        throw new Exception("Falha ao atualizar assinatura");
    }

    function delete($obj)
    {
        $orm = ORMInstance::getInstance();
        $orm->beginTransaction();
        $statement = $orm->makeStatement("DELETE FROM assinaturas WHERE id = ?");
        $statement->bindValue(1,$obj->getId());
        if($statement->execute()){
            $orm->commit();
            return;
        }
        $orm->rollBack();
        throw new Exception("Falha ao deletar assinatura");
    }
}