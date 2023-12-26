<?php

use App\App;

require 'vendor/autoload.php';

session_start();

try
{
    $app = new App();
    $app->identificarController();
    $app->executarController();
} catch (Exception $excecao) {
    throw new Exception("Erro na execução do sistema", $excecao->getCode());
}