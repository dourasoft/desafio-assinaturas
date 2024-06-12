<?php


include_once "Controller.php";
include_once "src/db/dao/AssinaturaDAO.php";
/**
 * @implements Controller<int, AssinaturaDTO>
 */
class AssinaturaController implements Controller
{
    private static AssinaturaController $INSTANCE;


    private function __construct()
    {

    }

    public static function getInstance(): AssinaturaController
    {
        return self::$INSTANCE ?? (self::$INSTANCE = new AssinaturaController());
    }

    /**
     * @return AssinaturaDTO[]
     * @throws Exception
     */
    function getAll(): array
    {
        return AssinaturaDAO::getInstance()->getAll();
    }

    /**
     * @param int $id
     * @return AssinaturaDTO
     * @throws Exception
     */
    function getById($id): ?AssinaturaDTO
    {
        return AssinaturaDAO::getInstance()->getById($id);
    }

    /**
     * @param AssinaturaDTO $obj
     * @return void
     * @throws Exception
     */
    function insert($obj)
    {
        AssinaturaDAO::getInstance()->insert($obj);
    }

    /**
     * @param AssinaturaDTO $obj
     * @return void
     * @throws Exception
     */
    function update($obj)
    {
        AssinaturaDAO::getInstance()->update($obj);
    }

    /**
     * @param AssinaturaDTO $obj
     * @return void
     * @throws Exception
     */
    function delete($obj)
    {
        AssinaturaDAO::getInstance()->delete($obj);
    }
}
