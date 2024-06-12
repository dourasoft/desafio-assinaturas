<?php

include_once "DAO.php";
include_once "src/db/ORMInstance.php";
include_once "src/db/dao/CadastroDAO.php";
include_once "src/db/dao/AssinaturaDAO.php";


/**
 * @implements DAO<FaturaDTO>
 */
class FaturaDAO implements DAO
{

    private static FaturaDAO $INSTANCE;

    public static function getInstance()
    {
        return self::$INSTANCE ?? (self::$INSTANCE = new FaturaDAO());
    }

    private function __construct()
    {
    }

    /**
     * @throws Exception
     */
    function getAll()
    {
        $orm = ORMInstance::getInstance();
        $statement = $orm->makeStatement("SELECT * FROM faturas");
        if ($statement->execute()) {
            $data = $statement->fetchAll();
            $toReturn = array();

            foreach ($data as $dto) {

                $cadastroDTO = CadastroDAO::getInstance()->getById($dto["cadastro_id"]);
                $assinaturaDTO = AssinaturaDAO::getInstance()->getById($dto["assinatura_id"]);

                $fatura = new FaturaDTO();
                $fatura->setId($dto["id"])
                    ->setCadastro($cadastroDTO)
                    ->setAssinatura($assinaturaDTO)
                    ->setVencimento(date_create($dto["vencimento"]))
                    ->setValor($dto["valor"])
                    ->setDescricao($dto["descricao"]);

                $toReturn[] = $fatura;
            }
            return $toReturn;
        }
        throw new Exception("Falha ao buscar as faturas");
    }

    /**
     * @throws Exception
     */
    function getById($id)
    {
        $orm = ORMInstance::getInstance();
        $statement = $orm->makeStatement("SELECT * FROM faturas WHERE id = :id");
        $statement->bindParam(":id", $id);
        if ($statement->execute()) {
            $data = $statement->fetch();
            $cadastroDTO = CadastroDAO::getInstance()->getById($data["cadastro_id"]);
            $assinaturaDTO = AssinaturaDAO::getInstance()->getById($data["assinatura_id"]);
            $fatura = new FaturaDTO();
            $fatura->setId($data["id"])
                ->setCadastro($cadastroDTO)
                ->setAssinatura($assinaturaDTO)
                ->setVencimento(date_create($data["vencimento"]))
                ->setValor($data["valor"])
                ->setDescricao($data["descricao"]);

            return $fatura;
        }
        throw new Exception("Falha ao buscar as faturas");
    }

    /**
     * @throws Exception
     */
    function insert($obj)
    {
        $orm = ORMInstance::getInstance();
        $orm->beginTransaction();
        $statement = $orm->makeStatement("INSERT INTO faturas(cadastro_id ,assinatura_id, vencimento, valor, descricao) VALUES (?, ?, ?, ?, ?)");
        $statement->bindValue(1, $obj->getCadastro()->getId());
        $statement->bindValue(2, $obj->getAssinatura()->getId());
        $statement->bindValue(3, $obj->getVencimento()->format("Y-m-d"));
        $statement->bindValue(4, $obj->getValor());
        $statement->bindValue(5, $obj->getDescricao());
        if ($statement->execute()) {
            $orm->commit();
            return;
        }
        $orm->rollBack();
        throw new Exception("Falha ao inserir a fatura");
    }

    function update($obj)
    {
        $orm = ORMInstance::getInstance();
        $orm->beginTransaction();
        $statement = $orm->makeStatement("UPDATE faturas SET id = ? cadastro_id = ?, assinatura_id = ?, vencimento = ?, valor = ?, descricao = ? WHERE id = ?");

        $statement->bindValue(1, $obj->getId());
        $statement->bindValue(2, $obj->getCadastro()->getId());
        $statement->bindValue(3, $obj->getAssinatura()->getId());
        $statement->bindValue(4, $obj->getVencimento()->format("Y-m-d"));
        $statement->bindValue(5, $obj->getValor());
        $statement->bindValue(6, $obj->getDescricao());
        $statement->bindValue(7, $obj->getId());

        if ($statement->execute()) {
            $orm->commit();
            return;
        }
        $orm->rollBack();
        throw new Exception("Falha ao atualizar a fatura");
    }

    function delete($obj)
    {
        $orm = ORMInstance::getInstance();
        $orm->beginTransaction();
        $statement = $orm->makeStatement("DELETE FROM faturas WHERE id = ?");
        $statement->bindValue(1, $obj->getId());
        if ($statement->execute()) {
            $orm->commit();
            return;
        }
        $orm->rollBack();
        throw new Exception("Falha ao deletar a fatura");
    }

    function hasFaturaWithExpireDate(DateTime $time, int $assinatura_id)
    {
        $orm = ORMInstance::getInstance();
        $statement = $orm->makeStatement("SELECT * FROM faturas WHERE vencimento = ? and assinatura_id = ?");
        $statement->bindValue(1, $time->format("Y-m-d"));
        $statement->bindValue(2, $assinatura_id);

        if ($statement->execute()) {
            $data = $statement->fetch();
            return $data;
        }
        throw new Exception("Falha ao buscar as faturas");
    }
}