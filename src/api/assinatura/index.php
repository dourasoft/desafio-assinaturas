<?php

set_include_path(get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT']);
include_once "src/controller/AssinaturaController.php";
include_once "src/controller/dto/AssinaturaDTO.php";
include_once "src/controller/dto/CadastroDTO.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$json = file_get_contents('php://input');
$data = json_decode($json, null, 512, JSON_OBJECT_AS_ARRAY);


$methods = array(
    'getById' => function ($data) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            return call_user_func(array(
                AssinaturaController::getInstance(), $_REQUEST["method"]
            ), $_REQUEST["id"]);
        }
        return array(
            "erro" => "Esperado uma requisição GET, recebeu " . $_SERVER['REQUEST_METHOD'],
        );
    },
    'getAll' => function ($data) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            return call_user_func(array(
                AssinaturaController::getInstance(), $_REQUEST["method"]
            ));
        }
        return array(
            "erro" => "Esperado uma requisição GET, recebeu " . $_SERVER['REQUEST_METHOD'],
        );
    },
    'insert' => function ($data) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $assinatura = new AssinaturaDTO();

            $cadastro = new CadastroDTO();
            $cadastro->setId($data["cadastro_id"]);

            $assinatura->setCadastro($cadastro);
            $assinatura->setVencimento(date_create($data["vencimento"]));
            $assinatura->setDescricao($data["descricao"]);
            $assinatura->setValor($data["valor"]);


            call_user_func(array(
                AssinaturaController::getInstance(), $_REQUEST["method"]
            ), $assinatura);
            return array("sucesso" => "Cadastro realizado");
        }
        return array(
            "erro" => "Esperado uma requisição POST, recebeu " . $_SERVER['REQUEST_METHOD'],
        );
    },
    'update' => function ($data) {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $assinatura = new AssinaturaDTO();
            $assinatura->setId($data["id"]);

            $cadastro = new CadastroDTO();
            $cadastro->setId($data["cadastro_id"]);
            $assinatura->setCadastro($cadastro);

            $assinatura->setVencimento(date_create($data["vencimento"]));
            $assinatura->setDescricao($data["descricao"]);
            $assinatura->setValor($data["valor"]);
            call_user_func(array(
                AssinaturaController::getInstance(), $_REQUEST["method"]
            ), $assinatura);
            return array("sucesso" => "Atualização realizada");
        }
        return array(
            "erro" => "Esperado uma requisição POST, recebeu " . $_SERVER['REQUEST_METHOD'],
        );
    },
    'delete' => function ($data) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $assinatura = new AssinaturaDTO();
            $assinatura->setId($data["id"]);
            call_user_func(array(
                AssinaturaController::getInstance(), $_REQUEST["method"]
            ), $assinatura);
            return array("sucesso" => "Remoção realizada");
        }
        return array(
            "erro" => "Esperado uma requisição POST, recebeu " . $_SERVER['REQUEST_METHOD'],
        );
    }
);

$value = isset($methods[$_REQUEST["method"]]) ? $methods[$_REQUEST["method"]]($data) : array("erro" => "Método não encontrado");

echo json_encode($value);