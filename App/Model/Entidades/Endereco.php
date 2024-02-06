<?php


namespace App\Model\Entidades;

use App\Model\DAO\EnderecoDAO;
use App\Model\Entidades\Conta\Cliente;

class Endereco
{
    private int $codigo;
    private string $rua;
    private int $numero;
    private string $bairro;
    private string $cidade;
    private string $estado;
    private Cliente $cliente;
    
    public function __construct(int $codigo = 0, string $rua = "", int $numero = 0, string $bairro = "",
    string $cidade = "", string $estado = "", int $cod_cliente = 0)
    {
        $this->codigo = $codigo;
        $this->rua = $rua;
        $this->numero = $numero;
        $this->bairro = $bairro;
        $this->cidade = $cidade;
        $this->estado = $estado;
        $this->cliente = new Cliente($cod_cliente);
    }
    
    public function localizar()
    {
        $enderecoDAO = new EnderecoDAO();
        $resultado = $enderecoDAO->localizar($this->getCodigo());

        return $resultado;
    }
    
    public function listar()
    {
        $enderecoDAO = new EnderecoDAO();
        $resultado = $enderecoDAO->listar($this->getCliente()->getCodigo());

        return $resultado;
    }
    
    public function listarPaginacao($indice, $limitePorPagina, $busca = "")
    {
        $enderecoDAO = new EnderecoDAO();
        $resultado = $enderecoDAO->listarPaginacao($indice, $limitePorPagina, $busca, $this->getCliente()->getCodigo());
        
        return $resultado;
    }

    public function contarTotalRegistros($coluna, $where = "")
    {
        $enderecoDAO = new EnderecoDAO();
        $resultado = $enderecoDAO->contarTotalRegistros($coluna, $where);
        
        return $resultado;
    }

    public function cadastrar()
    {
        $enderecoDAO = new EnderecoDAO();
        $resultado = $enderecoDAO->cadastrar($this);

        return $resultado;
    }

    public function atualizar()
    {
        $enderecoDAO = new EnderecoDAO();
        $resultado = $enderecoDAO->atualizar($this);

        return $resultado;
    }

    public function excluir()
    {
        $enderecoDAO = new EnderecoDAO();
        $resultado = $enderecoDAO->excluir($this);

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

    public function getRua() : string
    {
        return $this->rua;
    }

    public function setRua(string $valor)
    {
        $this->rua = $valor;
    }

    public function getNumero() : string
    {
        return $this->numero;
    }

    public function setNumero(string $valor)
    {
        $this->numero = $valor;
    }

    public function getBairro() : string
    {
        return $this->bairro;
    }

    public function setBairro(string $valor)
    {
        $this->bairro = $valor;
    }

    public function getCidade() : string
    {
        return $this->cidade;
    }

    public function setCidade(string $valor)
    {
        $this->cidade = $valor;
    }

    public function getEstado() : string
    {
        return $this->estado;
    }

    public function setEstado(string $valor)
    {
        $this->estado = $valor;
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