<?php

set_include_path(get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT']);

include_once "src/controller/AssinaturaController.php";
include_once "src/controller/FaturaController.php";
include_once "src/controller/dto/AssinaturaDTO.php";
include_once "src/controller/dto/FaturaDTO.php";

$file = fopen("log/latest.txt", "w");

fwrite($file, "Log de execução da Task de Geração de Faturas referente á " . date("d/m/Y H:i:s") . "\n");
fwrite($file, "=============================================================================\n");
foreach (AssinaturaController::getInstance()->getAll() as $assinatura) {
    $date = date_add($assinatura->getVencimento(),date_interval_create_from_date_string("10 days"));

    try {
        if(!FaturaController::getInstance()->hasFaturaWithExpireDate($date, $assinatura->getId())){
            $dto = new FaturaDTO();
            $dto -> setValor($assinatura->getValor());
            $dto -> setVencimento($assinatura->getVencimento());
            $dto -> setDescricao("Fatura referente a ". $assinatura->getDescricao() . " parcela de " . $assinatura->getVencimento()->format("M"));
            $dto -> setAssinatura($assinatura);
            $dto -> setCadastro($assinatura->getCadastro());
            FaturaController::getInstance()->insert(
                $dto
            );
            fwrite($file, sprintf("[%s] -> Fatura criada para assinatura %s, referente ao email cadastrado %s, com valor R$ %.2f, e vencimento %s\n",
                date_create()->format('d/m/Y H:i:s'),
                $assinatura->getDescricao(),
                $assinatura->getCadastro()->getEmail(),
                $assinatura->getValor(),
                $assinatura->getVencimento()->format("d/m/Y"))
            );
        }
    } catch (Exception $e) {
        print_r($e->getMessage());
    }
}
fwrite($file, "=============================================================================\n");
fclose($file);
