<?php 

namespace App\Model\Entidades\Conta;

class Cliente extends Conta
{
    private string $telefone;

    public function __construct(int $codigo = 0, string $nome = "", string $email = "", string $nomeUsuario = "", string $senha = "",
        string $tipo = "", string $telefone = "")
    {
        parent::__construct($codigo, $nome, $email, $nomeUsuario, $senha, $tipo);
        $this->telefone = $telefone;
    }

    public function getTelefone() : string
    {
        return $this->telefone;
    }

    public function setTelefone(string $valor)
    {
        $this->telefone = $valor;
    }
}