<?php

namespace App\Lib;

class Sessao
{
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
    
    public static function getFormulario()
    {
        if (isset($_SESSION['formulario']))
            return $_SESSION['formulario'];
        return false;
    }

    public static function setFormulario($valor)
    {
        $_SESSION['formulario'] = $valor;
    }

    public static function getValidacaoFormulario()
    {
        if (isset($_SESSION['validacao_formulario']))
            return $_SESSION['validacao_formulario'];
        return false;
    }

    public static function setValidacaoFormulario($valor)
    {
        $_SESSION['validacao_formulario'] = $valor;
    }
}