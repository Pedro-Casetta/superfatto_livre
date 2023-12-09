<?php


namespace App\Model\Entidades;

use App\Model\DAO\FornecedorDAO;

class Fornecedor
{
    private int $codigo;
    private string $cnpj;
    private string $nome;
    private string $categoria;
    
    public function listar()
    {
        $fornecedorDAO = new FornecedorDAO();
        $fornecedores = $fornecedorDAO->listar();
        return $fornecedores;
    }

    public function getCodigo() : int
    {
        return $this->codigo;
    }

    public function setCodigo(int $valor)
    {
        $this->codigo = $valor;
    }

    public function getCnpj() : string
    {
        return $this->cnpj;
    }

    public function setCnpj(string $valor)
    {
        $this->cnpj = $valor;
    }

    public function getNome() : string
    {
        return $this->nome;
    }

    public function setNome(string $valor)
    {
        $this->nome = $valor;
    }

    public function getCategoria() : string
    {
        return $this->categoria;
    }

    public function setCategoria(string $valor)
    {
        $this->categoria = $valor;
    }
}