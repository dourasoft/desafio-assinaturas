<?php
require_once __DIR__ . "/../../config/autoload.php";

$assinaturas = (new Assinaturas())->index();
$assinaturas = $assinaturas['response'];

$cadastros = (new Cadastros())->index();
$cadastros = $cadastros['response'];

$classSelect = "input-text w-3/4 py-2.5 px-1 text-secundary outline-none border-primary focus:border-secundary border-b-2 text-xl appearance-none rounded";
$classInput = "input-text w-3/4 py-2.5 px-1 placeholder:text-gray-400 placeholder:text-xs outline-none border-primary focus:border-secundary border-b-2 text-xl appearance-none rounded";

?>

<div data="content_form" id="form_fatura" class="space-y-4">
    <select id="cadastro_id" name="cadastro_id" class="<?= $classSelect ?>">
        <option value="">Selecione</option>
        <?php foreach ($cadastros as $cadastro) : ?>
            <option value="<?= $cadastro->id ?>"><?= $cadastro->nome ?></option>
        <?php endforeach; ?>
    </select>
    <select id="assinatura_id" name="assinatura_id" class="<?= $classSelect ?>">
        <option value="">Selecione</option>
        <?php foreach ($assinaturas as $assinatura) : ?>
            <option value="<?= $assinatura->id ?>"><?= $assinatura->descricao ?></option>
        <?php endforeach; ?>
    </select>
    <input type="text" name="descricao" id="descricao" class="<?= $classInput ?>" placeholder="Descrição">
    <input type="date" name="data_vencimento" id="data_vencimento" class="<?= $classInput ?>" placeholder="Data de Vencimento">
    <input type="text" name="valor" id="valor" class="<?= $classInput ?>" placeholder="Valor">
</div>