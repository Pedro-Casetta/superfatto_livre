<?php 

namespace App\Model\Entidades\Conta;

use App\Model\DAO\ContaDAO;
use App\Model\Entidades\Conta\Credencial;

class Administrador extends Conta
{
    private Credencial $credencial;

    public function __construct(int $codigo = 0, string $nome = "", string $email = "", string $nomeUsuario = "", string $senha = "",
        string $tipo = "", int $cod_credencial = 0, string $nome_credencial = "")
    {
        parent::__construct($codigo, $nome, $email, $nomeUsuario, $senha, $tipo);
        $this->credencial = new Credencial($cod_credencial, $nome_credencial);
    }

    public function verificarCredencial()
    {
        $contaDAO = new ContaDAO();
        $resultado = $contaDAO->verificarCredencial($this);

        return $resultado;
    }

    public function getCredencial() : Credencial
    {
        return $this->credencial;
    }

    public function setCredencial(Credencial $valor)
    {
        $this->credencial = $valor;
    }
}