<?php
require_once __DIR__ . "/../../config/autoload.php";
$classInput = "input-text w-3/4 py-2.5 px-1 placeholder:text-gray-400 placeholder:text-xs outline-none border-primary focus:border-secundary border-b-2 text-xl appearance-none rounded";

?>

<div data="content_form" id="form_cadastro" class="space-y-4">
    <input type="text" name="nome" id="nome" class="<?= $classInput ?>" placeholder="Nome">
    <input type="email" name="email" id="email" class="<?= $classInput ?>" placeholder="E-mail">
    <input type="number" name="telefone" id="telefone" class="<?= $classInput ?>" placeholder="Telefone">
</div>