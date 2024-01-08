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

    public static function getNomeUsuario()
    {
        if (isset($_SESSION['nome_usuario']))
            return $_SESSION['nome_usuario'];
        return false;
    }

    public static function setNomeUsuario($valor)
    {
        $_SESSION['nome_usuario'] = $valor;
    }

    public static function getTipoConta()
    {
        if (isset($_SESSION['tipo']))
            return $_SESSION['tipo'];
        return false;
    }

    public static function setTipoConta($valor)
    {
        $_SESSION['tipo'] = $valor;
    }

    public static function getCodigoConta()
    {
        if (isset($_SESSION['codigo']))
            return $_SESSION['codigo'];
        return false;
    }

    public static function setCodigoConta($valor)
    {
        $_SESSION['codigo'] = $valor;
    }
    
    public static function verificarAcesso($tipo)
    {
        if (self::getNomeUsuario() && self::getTipoConta() == $tipo)
            return true;
        else
            return false;
    }

    public static function logout()
    {
        unset($_SESSION['nome_usuario'], $_SESSION['tipo']);
    }
}