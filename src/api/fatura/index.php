<?php

set_include_path( get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT']);
include_once "src/controller/FaturaController.php";
include_once "src/controller/dto/FaturaDTO.php";
include_once "src/controller/dto/CadastroDTO.php";
include_once "src/controller/dto/AssinaturaDTO.php";


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$json = file_get_contents('php://input');
$data = json_decode($json,null, 512, JSON_OBJECT_AS_ARRAY);


$methods = array(
    'getById' => function($data) {
        return call_user_func(array(
            FaturaController::getInstance(), $_REQUEST["method"]
        ), $_REQUEST["id"]);
    },
    'getAll' => function($data) {
        return call_user_func(array(
            FaturaController::getInstance(), $_REQUEST["method"]
        ));
    },
    'insert' => function ($data) {
        $cadastro = new CadastroDTO();
        $cadastro->setId($data["cadastro_id"]);

        $assinatura = new AssinaturaDTO();
        $assinatura->setId($data["assinatura_id"]);

        $fatura = new FaturaDTO();
        $fatura->setAssinatura($assinatura);
        $fatura->setCadastro($cadastro);
        $fatura->setVencimento(date_create($data["vencimento"]));
        $fatura->setDescricao($data["descricao"]);
        $fatura->setValor($data["valor"]);

        call_user_func(array(
            FaturaController::getInstance(), $_REQUEST["method"]
        ), $fatura);
        return array("sucesso" => "Cadastro realizado");

    },
    'update' => function ($data) {

        $cadastro = new CadastroDTO();
        $cadastro->setId($data["cadastro_id"]);

        $assinatura = new AssinaturaDTO();
        $assinatura->setId($data["assinatura_id"]);

        $fatura = new FaturaDTO();
        $fatura->setAssinatura($assinatura);
        $fatura->setCadastro($cadastro);
        $fatura->setVencimento(date_create($data["vencimento"]));
        $fatura->setDescricao($data["descricao"]);
        $fatura->setValor($data["valor"]);

        call_user_func(array(
            FaturaController::getInstance(), $_REQUEST["method"]
        ), $fatura);

        return array("sucesso" => "Atualização realizada");
    },
    'delete' => function ($data) {
        $fatura = new FaturaDTO();
        $fatura->setId($data["id"]);
        call_user_func(array(
            FaturaController::getInstance(), $_REQUEST["method"]
        ),$fatura);
        return array("sucesso" => "Remoção realizada");
    }
);

$value = isset($methods[$_REQUEST["method"]]) ? $methods[$_REQUEST["method"]]($data) : array("erro" => "Método não encontrado");

echo json_encode($value);