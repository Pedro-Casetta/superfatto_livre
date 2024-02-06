<?php


namespace App\Model\Entidades;

use App\Model\DAO\ProdutoVendaDAO;
use App\Model\Entidades\Produto;
use App\Model\Entidades\Venda;

class ProdutoVenda extends Produto
{
    private int $quantidade;
    private float $subtotal;
    private Venda $venda;
    
    public function __construct(int $cod_produto = 0, int $cod_venda = 0, int $quantidade = 0, float $subtotal = 0.0,
        
        string $nome_produto = "",  float $preco = 0.0, string $imagem = "",

        string $data = "", float $total = 0.0)
    {
        parent::__construct($cod_produto, $nome_produto, $preco, 0, $imagem);
        $this->quantidade = $quantidade;
        $this->subtotal = $subtotal;
        $this->venda = new Venda($cod_venda, $data, $total, "");
    }
    
    public function localizar()
    {
        $produtoVendaDAO = new ProdutoVendaDAO();
        $resultado = $produtoVendaDAO->localizar($this->getCodigo(), $this->getVenda()->getCodigo());

        return $resultado;
    }
    
    public function listar()
    {
        $produtoVendaDAO = new ProdutoVendaDAO();
        $resultado = $produtoVendaDAO->listar($this->getVenda()->getCodigo());
        
        return $resultado;
    }

    public function cadastrar()
    {
        $produtoVendaDAO = new ProdutoVendaDAO();
        $resultado = $produtoVendaDAO->cadastrar($this);

        return $resultado;
    }

    public function excluir()
    {
        $produtoVendaDAO = new ProdutoVendaDAO();
        $resultado = $produtoVendaDAO->excluir($this);

        return $resultado;
    }

    public function getQuantidade() : int
    {
        return $this->quantidade;
    }

    public function setQuantidade(int $valor)
    {
        $this->quantidade = $valor;
    }

    public function getSubtotal() : string
    {
        $subtotal_formatado = number_format($this->subtotal, 2, ',', '.');
        return $subtotal_formatado;
    }

    public function setSubtotal(float $valor)
    {
        $this->subtotal = $valor;
    }

    public function getVenda() : Venda
    {
        return $this->venda;
    }

    public function setVenda(Venda $valor)
    {
        $this->venda = $valor;
    }
}