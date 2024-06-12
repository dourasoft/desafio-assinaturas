<?php

set_include_path(get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT']);
include_once "src/controller/CadastroController.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$json = file_get_contents('php://input');
$data = json_decode($json, null, 512, JSON_OBJECT_AS_ARRAY);


$methods = array(
    'getById' => function ($data) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            return call_user_func(array(
                CadastroController::getInstance(), $_REQUEST["method"]
            ), $_REQUEST["id"]);
        }
        return array(
            "erro" => "Esperado uma requisição GET, recebeu " . $_SERVER['REQUEST_METHOD'],
        );
    },
    'getAll' => function ($data) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            return call_user_func(array(
                CadastroController::getInstance(), $_REQUEST["method"]
            ));
        }
        return array(
            "erro" => "Esperado uma requisição GET, recebeu " . $_SERVER['REQUEST_METHOD'],
        );
    },
    'insert' => function ($data) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $cadastro = new CadastroDTO();
            $cadastro->setNome($data["nome"]);
            $cadastro->setEmail($data["email"]);
            $cadastro->setTelefone($data["telefone"]);
            call_user_func(array(
                CadastroController::getInstance(), $_REQUEST["method"]
            ), $cadastro);
            return array("sucesso" => "Cadastro realizado");
        }
        return array(
            "erro" => "Esperado uma requisição POST, recebeu " . $_SERVER['REQUEST_METHOD'],
        );
    },
    'update' => function ($data) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $cadastro = new CadastroDTO();
            $cadastro->setId($data["id"]);
            $cadastro->setNome($data["nome"]);
            $cadastro->setEmail($data["email"]);
            $cadastro->setTelefone($data["telefone"]);

            call_user_func(array(
                CadastroController::getInstance(), $_REQUEST["method"]
            ), $cadastro);
            return array("sucesso" => "Atualização realizada");
        }

        return array(
            "erro" => "Esperado uma requisição POST, recebeu " . $_SERVER['REQUEST_METHOD'],
        );

    },
    'delete' => function ($data) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $cadastro = new CadastroDTO();
            $cadastro->setId($data["id"]);
            call_user_func(array(
                CadastroController::getInstance(), $_REQUEST["method"]
            ), $cadastro);
            return array("sucesso" => "Remoção realizada");
        }
        return array(
            "erro" => "Esperado uma requisição POST, recebeu " . $_SERVER['REQUEST_METHOD'],
        );
    }
);

$value = isset($methods[$_REQUEST["method"]]) ? $methods[$_REQUEST["method"]]($data) : array("erro" => "Método não encontrado");

echo json_encode($value);