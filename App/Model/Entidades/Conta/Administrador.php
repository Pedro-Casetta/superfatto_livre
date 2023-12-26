<?php 

namespace App\Model\Entidades\Conta;

class Administrador extends Conta
{
    private string $credencial;

    public function __construct(int $codigo = 0, string $nome = "", string $email = "", string $nomeUsuario = "", string $senha = "",
        string $credencial = "")
    {
        parent::__construct($codigo, $nome, $email, $nomeUsuario, $senha);
        $this->credencial = $credencial;
    }

    public function getCredencial() : string
    {
        return $this->credencial;
    }

    public function setCredencial(string $valor)
    {
        $this->credencial = $valor;
    }
}