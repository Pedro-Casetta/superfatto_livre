<?php

namespace App\Lib;

class Validador
{
    public static function validarNome(string $nome)
    {
        if (preg_match("/^[a-zA-ZÀ-ÖØ-öø-ÿ\s']+$/u", $nome))
            return true;
        else
            return false;
    }
    
    public static function validarEmail(string $email)
    {
        if (preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email))
            return true;
        else
            return false;
    }

    public static function validarNomeUsuario(string $nome_usuario)
    {
        if (preg_match("/^\w{6,}$/", $nome_usuario))
            return true;
        else
            return false;
    }

    public static function validarSenha(string $senha)
    {
        if (preg_match("/^.{6,}$/", $senha))
            return true;
        else
            return false;
    }

    public static function validarTelefone(string $telefone)
    {
        if (preg_match("/^\d{8,}$/", $telefone))
            return true;
        else
            return false;
    }
    
}