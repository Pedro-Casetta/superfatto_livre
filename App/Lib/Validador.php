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
    
    public static function validarCpf(string $cpf)
    {
        if (preg_match('/^\d{3}\.\d{3}\.\d{3}-\d{2}$/', $cpf) || preg_match('/^\d{11}$/', $cpf))
            return true;
        else
            return false;
    }

    public static function validarMonetario(string $salario)
    {
        if (preg_match('/^\d+(\.\d{1,2})?$/', $salario))
            return true;
        else
            return false;
    }

    public static function validarCnpj(string $cnpj)
    {
        if (preg_match('/^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/', $cnpj) || preg_match('/^\d{14}$/', $cnpj))
            return true;
        else
            return false;
    }

    public static function validarNomeFornecedor(string $nome_fornecedor)
    {
        if (preg_match("/^[a-zA-ZÀ-ÖØ-öø-ÿ0-9\s\'\/]+$/u", $nome_fornecedor))
            return true;
        else
            return false;
    }

    public static function validarNomeProduto(string $nome_fornecedor)
    {
        if (preg_match("/^[a-zA-ZÀ-ÖØ-öø-ÿ0-9\s\']+$/u", $nome_fornecedor))
            return true;
        else
            return false;
    }

    public static function validarCep(string $cep)
    {
        if (preg_match('/^\d{5}-\d{3}$/', $cep) || preg_match('/^\d{8}$/', $cep))
            return true;
        else
            return false;
    }
}