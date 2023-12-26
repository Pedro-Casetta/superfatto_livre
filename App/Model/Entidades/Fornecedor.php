<?php


namespace App\Model\Entidades;

use App\Model\DAO\FornecedorDAO;
use App\Model\Entidades\Departamento;

class Fornecedor
{
    private int $codigo;
    private string $cnpj;
    private string $nome;
    private Departamento $departamento;
    
    public function __construct(int $codigo = 0, string $cnpj = "", string $nome = "", int $cod_departamento = 0, string $nome_departamento = "")
    {
        $this->codigo = $codigo;
        $this->cnpj = $cnpj;
        $this->nome = $nome;
        $this->departamento = new Departamento($cod_departamento, $nome_departamento);
    }
    
    public function localizar()
    {
        $fornecedorDAO = new FornecedorDAO();
        $resultado = $fornecedorDAO->localizar($this->getCodigo());

        return $resultado;
    }
    
    public function listar()
    {
        $fornecedorDAO = new FornecedorDAO();
        $resultado = $fornecedorDAO->listar();
        
        return $resultado;
    }

    public function cadastrar()
    {
        $fornecedorDAO = new FornecedorDAO();
        $resultado = $fornecedorDAO->cadastrar($this);

        return $resultado;
    }

    public function atualizar()
    {
        $fornecedorDAO = new FornecedorDAO();
        $resultado = $fornecedorDAO->atualizar($this);

        return $resultado;
    }

    public function excluir()
    {
        $fornecedorDAO = new FornecedorDAO();
        $resultado = $fornecedorDAO->excluir($this);

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

    public function getDepartamento() : Departamento
    {
        return $this->departamento;
    }

    public function setDepartamento(Departamento $valor)
    {
        $this->departamento = $valor;
    }
}