<?php


include_once "Controller.php";
include_once "src/db/dao/CadastroDAO.php";

/**
 * @implements Controller<int, CadastroDTO>
 */

class CadastroController implements Controller
{

    private static CadastroController $INSTANCE;

    private function __construct()
    {

    }

    public static function getInstance() {
        return self::$INSTANCE ?? (self::$INSTANCE = new CadastroController());
    }

    /**
     * @throws Exception
     */
    function getAll()
    {
        return CadastroDAO::getInstance()->getAll();
    }

    /**
     * @throws Exception
     */
    function getById($id)
    {
        return CadastroDAO::getInstance()->getById($id);
    }

    /**
     * @throws Exception
     */
    function insert($obj)
    {
        CadastroDAO::getInstance()->insert($obj);
    }

    /**
     * @throws Exception
     */
    function update($obj)
    {
        CadastroDAO::getInstance()->update($obj);
    }

    /**
     * @throws Exception
     */
    function delete($obj)
    {
        CadastroDAO::getInstance()->delete($obj);
    }
}