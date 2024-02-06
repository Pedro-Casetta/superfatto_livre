<?php


namespace App\Model\Entidades;

use App\Model\DAO\CarrinhoDAO;

class Carrinho
{
    private int $codigo;
    private float $total;
    private Cupom $cupom;
    
    public function __construct(int $codigo = 0, float $total = 0.0, int $cod_cupom = 0,
        string $nome_cupom = "", string $descricao_cupom = "", int $desconto = 0)
    {
        $this->codigo = $codigo;
        $this->total = $total;
        $this->cupom = new Cupom($cod_cupom, $nome_cupom, $descricao_cupom, $desconto);
    }
    
    public function localizar()
    {
        $carrinhoDAO = new CarrinhoDAO();
        $resultado = $carrinhoDAO->localizar($this->getCodigo());

        return $resultado;
    }

    public function aplicarCupom()
    {
        $carrinhoDAO = new CarrinhoDAO();
        $resultado = $carrinhoDAO->aplicarCupom($this);

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

    public function getTotal() : string
    {
        $total_formatado = number_format($this->total, 2, ',', '.');
        return $total_formatado;
    }

    public function setTotal(float $valor)
    {
        $this->total = $valor;
    }

    public function getCupom() : Cupom
    {
        return $this->cupom;
    }

    public function setCupom(Cupom $valor)
    {
        $this->cupom = $valor;
    }
}