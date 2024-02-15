<?php


namespace App\Model\Entidades;

use App\Model\DAO\ProdutoCarrinhoDAO;
use App\Model\Entidades\Produto;
use App\Model\Entidades\Carrinho;

class ProdutoCarrinho extends Produto
{
    private int $quantidade;
    private float $subtotal;
    private Carrinho $carrinho;
    
    public function __construct(int $cod_produto = 0, int $cod_carrinho = 0, int $quantidade = 0, float $subtotal = 0.0,
        
        string $nome_produto = "",  float $preco = 0.0, int $estoque = 0, string $imagem = "")
    {
        parent::__construct($cod_produto, $nome_produto, $preco, $estoque, $imagem);
        $this->quantidade = $quantidade;
        $this->subtotal = $subtotal;
        $this->carrinho = new Carrinho($cod_carrinho);
    }
    
    public function localizar()
    {
        $produtoCarrinhoDAO = new ProdutoCarrinhoDAO();
        $resultado = $produtoCarrinhoDAO->localizar($this->getCodigo(), $this->getCarrinho()->getCodigo());

        return $resultado;
    }
    
    public function listar()
    {
        $produtoCarrinhoDAO = new ProdutoCarrinhoDAO();
        $resultado = $produtoCarrinhoDAO->listar($this->getCarrinho()->getCodigo());
        
        return $resultado;
    }

    public function cadastrar()
    {
        $produtoCarrinhoDAO = new ProdutoCarrinhoDAO();
        $resultado = $produtoCarrinhoDAO->cadastrar($this);
        
        return $resultado;
    }
    
    public function diminuirQuantidade()
    {
        $produtoCarrinhoDAO = new ProdutoCarrinhoDAO();
        $resultado = $produtoCarrinhoDAO->diminuirQuantidade($this);
        
        return $resultado;
    }
    
    public function atualizar(int $velho_codigo_produto = 0)
    {
        $produtoCarrinhoDAO = new ProdutoCarrinhoDAO();
        $resultado = $produtoCarrinhoDAO->atualizar($this);

        return $resultado;
    }

    public function aumentarQuantidade()
    {
        $produtoCarrinhoDAO = new ProdutoCarrinhoDAO();
        $resultado = $produtoCarrinhoDAO->aumentarQuantidade($this);

        return $resultado;
    }

    public function excluir()
    {
        $produtoCarrinhoDAO = new ProdutoCarrinhoDAO();
        $resultado = $produtoCarrinhoDAO->excluir($this);

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

    public function getCarrinho() : Carrinho
    {
        return $this->carrinho;
    }

    public function setCarrinho(Carrinho $valor)
    {
        $this->carrinho = $valor;
    }
}