<?php


namespace App\Model\Entidades;

use App\Model\DAO\VendaDAO;
use App\Model\Entidades\Conta\Cliente;

class Venda
{
    private int $codigo;
    private string $data;
    private float $total;
    private string $situacao;
    private Cliente $cliente;
    
    public function __construct(int $codigo = 0, string $data = "", float $total = 0.0, string $situacao = "",
    int $cod_cliente = 0, string $nome_cliente = "")
    {
        $this->codigo = $codigo;
        $this->data = $data;
        $this->total = $total;
        $this->situacao = $situacao;
        $this->cliente = new Cliente($cod_cliente, $nome_cliente);
    }
    
    public function localizar()
    {
        $vendaDAO = new VendaDAO();
        $resultado = $vendaDAO->localizar($this->getCodigo());

        return $resultado;
    }

    public function listarPaginacao($indice, $limitePorPagina, $busca = "", $data = "")
    {
        $vendaDAO = new VendaDAO();
        $resultado = $vendaDAO->listarPaginacao($indice, $limitePorPagina, $busca, $data);
        
        return $resultado;
    }

    public function contarTotalRegistros($coluna, $where = "")
    {
        $vendaDAO = new VendaDAO();
        $resultado = $vendaDAO->contarTotalRegistros($coluna, $where);
        
        return $resultado;
    }

    public function cadastrar()
    {
        $vendaDAO = new VendaDAO();
        $resultado = $vendaDAO->cadastrar($this);

        return $resultado;
    }

    public function atualizar()
    {
        $vendaDAO = new VendaDAO();
        $resultado = $vendaDAO->atualizar($this);

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

    public function getTotal() : string
    {
        $total_formatado = number_format($this->total, 2, ',', '.');
        return $total_formatado;
    }

    public function setTotal(float $valor)
    {
        $this->total = $valor;
    }
    
    public function getSituacao() : string
    {
        return $this->situacao;
    }

    public function setSituacao(string $valor)
    {
        $this->situacao = $valor;
    }

    public function getCliente() : Cliente
    {
        return $this->cliente;
    }

    public function setCliente(Cliente $valor)
    {
        $this->cliente = $valor;
    }
}