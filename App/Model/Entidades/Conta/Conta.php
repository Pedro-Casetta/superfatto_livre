<?php

namespace App\Model\Entidades\Conta;

use App\Model\DAO\ContaDAO;

abstract class Conta
{
    protected int $codigo;
    protected string $nome;
    protected string $email;
    protected string $nomeUsuario;
    protected string $senha;
    protected string $tipo;

    public function __construct(int $codigo = 0, string $nome = "", string $email = "", string $nomeUsuario = "", string $senha = "",
        string $tipo = "")
    {
        $this->codigo = $codigo;
        $this->nome = $nome;
        $this->email = $email;
        $this->nomeUsuario = $nomeUsuario;
        $this->senha = $senha;
        $this->tipo = $tipo;
    }
    
    public function cadastrar()
    {
        $contaDAO = new ContaDAO();
        $resultado = $contaDAO->cadastrar($this);

        return $resultado;
    }

    public static function acessar($nome_usuario, $senha)
    {
        $contaDAO = new ContaDAO();
        $resultado = $contaDAO->acessar($nome_usuario, $senha);
        
        return $resultado;
    }

    public static function localizar($codigo, $tipo)
    {
        $contaDAO = new ContaDAO();
        $resultado = $contaDAO->localizar($codigo, $tipo);

        return $resultado;
    }

    public static function localizarNomeUsuario($nome_usuario)
    {
        $contaDAO = new ContaDAO();
        $resultado = $contaDAO->localizarNomeUsuario($nome_usuario);

        return $resultado;
    }

    public function atualizar()
    {
        $contaDAO = new ContaDAO();
        $resultado = $contaDAO->atualizar($this);

        return $resultado;
    }

    public static function excluir($codigo)
    {
        $contaDAO = new ContaDAO();
        $resultado = $contaDAO->excluir($codigo);

        return $resultado;
    }

    public static function trocarSenha($codigo, $senha)
    {
        $contaDAO = new ContaDAO();
        $resultado = $contaDAO->trocarSenha($codigo, $senha);

        return $resultado;
    }
    
    public function getCodigo() : int
    {
        return $this->codigo;
    }

    public function setCodigo(int $valor)
    {
        $this->codigo = $valor;
    }

    public function getNome() : string
    {
        return $this->nome;
    }

    public function setNome(string $valor)
    {
        $this->nome = $valor;
    }
    
    public function getEmail() : string
    {
        return $this->email;
    }

    public function setEmail(string $valor)
    {
        $this->email = $valor;
    }

    public function getNomeUsuario() : string
    {
        return $this->nomeUsuario;
    }

    public function setNomeUsuario(string $valor)
    {
        $this->nomeUsuario = $valor;
    }

    public function getSenha() : string
    {
        return $this->senha;
    }

    public function setSenha(string $valor)
    {
        $this->senha = $valor;
    }

    public function getTipo() : string
    {
        return $this->tipo;
    }

    public function setTipo(string $valor)
    {
        $this->tipo = $valor;
    }
}