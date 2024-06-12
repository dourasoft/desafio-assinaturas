<?php
/**
 * @template T
 */
interface DTO{

    /**
     * @return T;
     */
    function build();
}