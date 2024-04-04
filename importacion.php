<?php
require_once("class/importar.php");

$importar = new Importar;
$custo = $importar->customers();
$IdCusAndBra = $importar->brandCustomer();