<?php

namespace App\Lib;

class Sessao
{
    public static function getMensagem()
    {
        if (isset($_SESSION['mensagem']))
            return $_SESSION['mensagem'];
        return false;
    }

    public static function setMensagem($valor)
    {
        $_SESSION['mensagem'] = $valor;
    }
}