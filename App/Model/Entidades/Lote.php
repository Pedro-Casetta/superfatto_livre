<?php


namespace App\Model\Entidades;

use App\Model\DAO\LoteDAO;
use App\Model\Entidades\Fornecedor;

class Lote
{
    private int $codigo;
    private string $data;
    private float $total;
    private Fornecedor $fornecedor;
    
    public function __construct(int $codigo = 0, string $data = "", float $total = 0.0, int $cod_fornecedor = 0,
        string $cnpj_fornecedor = "", string $nome_fornecedor = "", int $cod_departamento = 0, string $nome_departamento = "")
    {
        $this->codigo = $codigo;
        $this->data = $data;
        $this->total = $total;
        $this->fornecedor = new Fornecedor($cod_fornecedor, $cnpj_fornecedor, $nome_fornecedor, $cod_departamento, $nome_departamento);
    }
    
    public function localizar()
    {
        $loteDAO = new LoteDAO();
        $resultado = $loteDAO->localizar($this->getCodigo());

        return $resultado;
    }
    
    public function listar()
    {
        $loteDAO = new LoteDAO();
        $resultado = $loteDAO->listar();
        
        return $resultado;
    }

    public function cadastrar()
    {
        $loteDAO = new LoteDAO();
        $resultado = $loteDAO->cadastrar($this);

        return $resultado;
    }

    public function atualizar()
    {
        $loteDAO = new LoteDAO();
        $resultado = $loteDAO->atualizar($this);

        return $resultado;
    }

    public function excluir()
    {
        $loteDAO = new LoteDAO();
        $resultado = $loteDAO->excluir($this);

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

    public function getData() : string
    {
        return $this->data;
    }

    public function setData(string $valor)
    {
        $this->data = $valor;
    }

    public function getTotal() : float
    {
        return $this->total;
    }

    public function setTotal(float $valor)
    {
        $this->total = $valor;
    }

    public function getFornecedor() : Fornecedor
    {
        return $this->fornecedor;
    }

    public function setFornecedor(Fornecedor $valor)
    {
        $this->fornecedor = $valor;
    }
}