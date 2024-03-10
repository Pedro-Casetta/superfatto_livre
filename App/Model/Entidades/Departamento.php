<?php

namespace App\Model\Entidades;

use App\Model\DAO\DepartamentoDAO;

class Departamento
{
    private int $codigo;
    private string $nome;

    public function __construct(int $codigo = 0, string $nome = "")
    {
        $this->codigo = $codigo;
        $this->nome = $nome;
    }

    public function localizar()
    {
        $departamentoDAO = new DepartamentoDAO();
        $resultado = $departamentoDAO->localizar($this->getCodigo());

        return $resultado;
    }

    public function listarPaginacao($indice, $limitePorPagina, $busca = "")
    {
        $departamentoDAO = new DepartamentoDAO();
        $resultado = $departamentoDAO->listarPaginacao($indice, $limitePorPagina, $busca);
        
        return $resultado;
    }

    public function contarTotalRegistros($coluna, $where = "")
    {
        $departamentoDAO = new DepartamentoDAO();
        $resultado = $departamentoDAO->contarTotalRegistros($coluna, $where);
        
        return $resultado;
    }

    public function cadastrar()
    {
        $departamentoDAO = new DepartamentoDAO();
        $resultado = $departamentoDAO->cadastrar($this);

        return $resultado;
    }

    public function atualizar()
    {
        $departamentoDAO = new DepartamentoDAO();
        $resultado = $departamentoDAO->atualizar($this);

        return $resultado;
    }

    public function excluir()
    {
        $departamentoDAO = new DepartamentoDAO();
        $resultado = $departamentoDAO->excluir($this);

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
}