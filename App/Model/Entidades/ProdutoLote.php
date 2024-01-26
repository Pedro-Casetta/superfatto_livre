<?php


namespace App\Model\Entidades;

use App\Model\DAO\ProdutoLoteDAO;
use App\Model\Entidades\Produto;
use App\Model\Entidades\Lote;

class ProdutoLote extends Produto
{
    private int $quantidade;
    private float $subtotal;
    private Lote $lote;
    
    public function __construct(int $cod_produto = 0, int $cod_lote = 0, int $quantidade = 0, float $subtotal = 0.0,
        
        string $nome_produto = "",  float $preco = 0.0, string $imagem = "",

        string $data = "", float $total = 0.0, string $nome_fornecedor = "",
        int $cod_departamento_fornecedor = 0, string $nome_departamento_fornecedor = "")
    {
        parent::__construct($cod_produto, $nome_produto, $preco, 0, $imagem);
        $this->quantidade = $quantidade;
        $this->subtotal = $subtotal;
        $this->lote = new Lote($cod_lote, $data, $total, 0, "", $nome_fornecedor, $cod_departamento_fornecedor,
            $nome_departamento_fornecedor);
    }
    
    public function localizar()
    {
        $produtoLoteDAO = new ProdutoLoteDAO();
        $resultado = $produtoLoteDAO->localizar($this->getCodigo(), $this->getLote()->getCodigo());

        return $resultado;
    }
    
    public function listarPaginacao($indice, $limitePorPagina, $busca = "", $departamento = "")
    {
        $produtoLoteDAO = new ProdutoLoteDAO();
        $resultado = $produtoLoteDAO->listarPaginacao($indice, $limitePorPagina, $busca, $this->getLote()->getCodigo());
        
        return $resultado;
    }

    public function cadastrar()
    {
        $produtoLoteDAO = new ProdutoLoteDAO();
        $resultado = $produtoLoteDAO->cadastrar($this);

        return $resultado;
    }

    public function atualizar(int $velho_codigo_produto = 0)
    {
        $produtoLoteDAO = new ProdutoLoteDAO();
        $resultado = $produtoLoteDAO->atualizar($this, $velho_codigo_produto);

        return $resultado;
    }

    public function excluir()
    {
        $produtoLoteDAO = new ProdutoLoteDAO();
        $resultado = $produtoLoteDAO->excluir($this);

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

    public function getLote() : Lote
    {
        return $this->lote;
    }

    public function setLote(Lote $valor)
    {
        $this->lote = $valor;
    }
}