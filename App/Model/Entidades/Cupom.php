<?php


namespace App\Model\Entidades;

use App\Model\DAO\CupomDAO;

class Cupom
{
    private int $codigo;
    private string $nome;
    private string $descricao;
    private int $desconto;
    
    public function __construct(int $codigo = 0, string $nome = "", string $descricao = "", int $desconto = 0)
    {
        $this->codigo = $codigo;
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->desconto = $desconto;
    }
    
    public function localizar()
    {
        $cupomDAO = new CupomDAO();
        $resultado = $cupomDAO->localizar($this->getCodigo());

        return $resultado;
    }

    public function listarPaginacao($indice, $limitePorPagina, $busca = "")
    {
        $cupomDAO = new CupomDAO();
        $resultado = $cupomDAO->listarPaginacao($indice, $limitePorPagina, $busca);
        
        return $resultado;
    }

    public function contarTotalRegistros($coluna, $where = "")
    {
        $cupomDAO = new CupomDAO();
        $resultado = $cupomDAO->contarTotalRegistros($coluna, $where);
        
        return $resultado;
    }

    public function cadastrar()
    {
        $cupomDAO = new CupomDAO();
        $resultado = $cupomDAO->cadastrar($this);

        return $resultado;
    }

    public function atualizar()
    {
        $cupomDAO = new CupomDAO();
        $resultado = $cupomDAO->atualizar($this);

        return $resultado;
    }

    public function excluir()
    {
        $cupomDAO = new CupomDAO();
        $resultado = $cupomDAO->excluir($this);

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

    public function getDescricao() : string
    {
        return $this->descricao;
    }

    public function setDescricao(string $valor)
    {
        $this->descricao = $valor;
    }

    public function getDesconto() : int
    {
        return $this->desconto;
    }

    public function setDesconto(int $valor)
    {
        $this->desconto = $valor;
    }
}