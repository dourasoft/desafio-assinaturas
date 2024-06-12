<?php

include_once "Controller.php";

include_once "src/db/dao/FaturaDAO.php";
/**
 * @implements Controller<int, FaturaDTO>
 */
class FaturaController implements Controller
{
    private static $INSTANCE;

    private function __construct()
    {
    }

    public static function getInstance() {
        return self::$INSTANCE ?? (self::$INSTANCE = new FaturaController());
    }

    /**
     * @throws Exception
     */
    function getAll(): array
    {
        return FaturaDAO::getInstance()->getAll();
    }

    /**
     * @throws Exception
     */
    function getById($id)
    {
        return FaturaDAO::getInstance()->getById($id);
    }

    /**
     * @throws Exception
     */
    function insert($obj): void
    {
        FaturaDAO::getInstance()->insert($obj);
    }

    /**
     * @throws Exception
     */
    function update($obj): void
    {
        FaturaDAO::getInstance()->update($obj);
    }

    /**
     * @throws Exception
     */
    function delete($obj): void
    {
        FaturaDAO::getInstance()->delete($obj);
    }

    /**
     * @throws Exception
     */
    function hasFaturaWithExpireDate(DateTime $time,int $assinatura_id){
        return FaturaDAO::getInstance()->hasFaturaWithExpireDate($time, $assinatura_id);
    }
}