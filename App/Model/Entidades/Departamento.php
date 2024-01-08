<?php

namespace App\Model\Entidades;

class Departamento
{
    private int $codigo;
    private string $nome;

    public function __construct(int $codigo = 0, string $nome = "")
    {
        $this->codigo = $codigo;
        $this->nome = $nome;
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
}