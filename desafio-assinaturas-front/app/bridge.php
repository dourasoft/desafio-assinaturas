<?php

require_once __DIR__ . "/../config/autoload.php";

$order = clearInputsForm(json_decode(file_get_contents('php://input')));

echo json_encode((new Customs())->get($order));
