<?php

/**
 * @template Type
 * @template PrimaryKey
 */
interface DAO {
    /**
     * @return Type[]
     */
    function getAll();

    /**
     * @param PrimaryKey $id
     * @return Type
     */
    function getById($id);

    /**
     * @param Type $obj
     * @return void
     */
    function insert($obj);

    /**
     * @param Type $obj
     * @return void
     */
    function update($obj);

    /**
     * @param Type $obj
     * @return void
     */
    function delete($obj);
}