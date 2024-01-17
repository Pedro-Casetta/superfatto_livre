<?php


namespace App\Model\Entidades;

use App\Model\DAO\ProdutoDAO;
use App\Model\Entidades\Departamento;

class Produto
{
    protected int $codigo;
    protected string $nome;
    protected float $preco;
    protected int $estoque;
    protected string $imagem;
    protected Departamento $departamento;
    
    public function __construct(int $codigo = 0, string $nome = "",  float $preco = 0.0, int $estoque = 0, string $imagem = "",
        int $cod_departamento = 0, string $nome_departamento = "")
    {
        $this->codigo = $codigo;
        $this->nome = $nome;
        $this->preco = $preco;
        $this->estoque = $estoque;
        $this->imagem = $imagem;
        $this->departamento = new Departamento($cod_departamento, $nome_departamento);
    }
    
    public function localizar()
    {
        $produtoDAO = new ProdutoDAO();
        $resultado = $produtoDAO->localizar($this->getCodigo());

        return $resultado;
    }
    
    public function listar()
    {
        $produtoDAO = new ProdutoDAO();
        $resultado = $produtoDAO->listar();
        
        return $resultado;
    }

    public function cadastrar()
    {
        $produtoDAO = new ProdutoDAO();
        $resultado = $produtoDAO->cadastrar($this);

        return $resultado;
    }

    public function atualizar(int $velho_codigo_produto = 0)
    {
        $produtoDAO = new ProdutoDAO();
        $resultado = $produtoDAO->atualizar($this);

        return $resultado;
    }

    public function excluir()
    {
        $produtoDAO = new ProdutoDAO();
        $resultado = $produtoDAO->excluir($this);

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

    public function getPreco() : float
    {
        return $this->preco;
    }

    public function setPreco(float $valor)
    {
        $this->preco = $valor;
    }

    public function getEstoque() : int
    {
        return $this->estoque;
    }

    public function setEstoque(int $valor)
    {
        $this->estoque = $valor;
    }

    public function getImagem() : string
    {
        return $this->imagem;
    }

    public function setImagem(string $valor)
    {
        $this->imagem = $valor;
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