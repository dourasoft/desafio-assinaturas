<?php
// Script em php para criar a Task diaria nos sistemas Windows e Linux (não sei qual é usado por vocês, mas deve funcionar em ambos)

$OS = php_uname('s');

if($OS == 'Windows NT'){
    exec(sprintf("schtasks /create /tn GerarFaturas /tr \"php.exe %s\" /sc daily /st 08:00", __DIR__ . "/src/tasks/GenerateFaturas.php"));
} else if($OS == "Linux"){
    exec("0 8 * * * php " . __DIR__ . "/tasks/GenerateFaturas.php");
}