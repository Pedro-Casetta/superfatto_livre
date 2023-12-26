<?php

namespace App\Model\Entidades\Conta;

use App\Model\DAO\ContaDAO;

abstract class Conta
{
    private int $codigo;
    private string $nome;
    private string $email;
    private string $nomeUsuario;
    private string $senha;

    public function __construct(int $codigo = 0, string $nome = "", string $email = "", string $nomeUsuario = "", string $senha = "")
    {
        $this->codigo = $codigo;
        $this->nome = $nome;
        $this->email = $email;
        $this->nomeUsuario = $nomeUsuario;
        $this->senha = $senha;
    }
    
    public function cadastrar()
    {
        $contaDAO = new ContaDAO();
        $resultado = $contaDAO->cadastrar($this);

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
}