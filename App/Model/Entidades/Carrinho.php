<?php


namespace App\Model\Entidades;

use App\Model\DAO\CarrinhoDAO;

class Carrinho
{
    private int $codigo;
    private float $total;
    
    public function __construct(int $codigo = 0, float $total = 0.0)
    {
        $this->codigo = $codigo;
        $this->total = $total;
    }
    
    public function localizar()
    {
        $carrinhoDAO = new CarrinhoDAO();
        $resultado = $carrinhoDAO->localizar($this->getCodigo());

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

    public function getTotalView() : string
    {
        $total_formatado = number_format($this->total, 2, ',', '.');
        return $total_formatado;
    }

    public function getTotal() : float
    {
        $total_formatado = number_format($this->total, 2);
        return $total_formatado;
    }
    
    public function setTotal(float $valor)
    {
        $this->total = $valor;
    }
}