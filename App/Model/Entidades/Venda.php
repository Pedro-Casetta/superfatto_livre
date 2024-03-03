<?php


namespace App\Model\Entidades;

use App\Model\DAO\VendaDAO;
use App\Model\Entidades\Conta\Cliente;
use App\Model\Entidades\Endereco;

class Venda
{
    private int $codigo;
    private string $data;
    private float $total;
    private string $situacao;
    private string $idPagamento;
    private Cliente $cliente;
    private Endereco $endereco;
    
    public function __construct(int $codigo = 0, string $data = "", float $total = 0.0, string $situacao = "",
    string $idPagamento = "", int $cod_cliente = 0, string $nome_cliente = "", int $cod_endereco = 0, string $rua = "",
    int $numero = 0, string $bairro = "", string $cidade = "", string $estado = "", string $cep = "")
    {
        $this->codigo = $codigo;
        $this->data = $data;
        $this->total = $total;
        $this->situacao = $situacao;
        $this->idPagamento = $idPagamento;
        $this->cliente = new Cliente($cod_cliente, $nome_cliente);
        $this->endereco = new Endereco($cod_endereco, $rua, $numero, $bairro, $cidade, $estado, $cep);
    }
    
    public function localizar()
    {
        $vendaDAO = new VendaDAO();
        $resultado = $vendaDAO->localizar($this->getCodigo(), $this->getIdPagamento());

        return $resultado;
    }

    public function listarPaginacao($indice, $limitePorPagina, $busca = "", $data = "")
    {
        $vendaDAO = new VendaDAO();
        $resultado = $vendaDAO->listarPaginacao($indice, $limitePorPagina, $busca, $data);
        
        return $resultado;
    }

    public function listarPaginacaoCliente($indice, $limitePorPagina, $busca = "", $data = "")
    {
        $vendaDAO = new VendaDAO();
        $resultado = $vendaDAO->listarPaginacaoCliente($indice, $limitePorPagina, $busca, $data, $this->getCliente()->getCodigo());
        
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

    public function excluir()
    {
        $vendaDAO = new VendaDAO();
        $resultado = $vendaDAO->excluir($this);
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

    public function getDataView() : string
    {
        $data_formatada = explode("-", $this->data);
        $data_formatada = $data_formatada[2] . '/' . $data_formatada[1] . '/' . $data_formatada[0];
        return $data_formatada;
    }

    public function setData(string $valor)
    {
        $this->data = $valor;
    }

    public function getTotal() : float
    {
        return $this->total;
    }
    
    public function getTotalView() : string
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

    public function getIdPagamento() : string
    {
        return $this->idPagamento;
    }

    public function setIdPagamento(string $valor)
    {
        $this->idPagamento = $valor;
    }

    public function getCliente() : Cliente
    {
        return $this->cliente;
    }

    public function setCliente(Cliente $valor)
    {
        $this->cliente = $valor;
    }

    public function getEndereco() : Endereco
    {
        return $this->endereco;
    }

    public function setEndereco(Endereco $valor)
    {
        $this->endereco = $valor;
    }
}