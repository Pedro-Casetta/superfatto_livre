<?php


namespace App\Model\Entidades;

use App\Model\DAO\FuncionarioDAO;

class Funcionario
{
    private int $codigo;
    private string $cpf;
    private string $nome;
    private string $setor;
    private float $salario;
    
    public function __construct(int $codigo = 0, string $cpf = "", string $nome = "", string $setor = "", float $salario = 0.0)
    {
        $this->codigo = $codigo;
        $this->cpf = $cpf;
        $this->nome = $nome;
        $this->setor = $setor;
        $this->salario = $salario;
    }
    
    public function localizar()
    {
        $funcionarioDAO = new FuncionarioDAO();
        $resultado = $funcionarioDAO->localizar($this->getCodigo());

        return $resultado;
    }

    public function listarPaginacao($indice, $limitePorPagina, $busca = "")
    {
        $funcionarioDAO = new FuncionarioDAO();
        $resultado = $funcionarioDAO->listarPaginacao($indice, $limitePorPagina, $busca);
        
        return $resultado;
    }

    public function contarTotalRegistros($coluna, $where = "")
    {
        $funcionarioDAO = new FuncionarioDAO();
        $resultado = $funcionarioDAO->contarTotalRegistros($coluna, $where);
        
        return $resultado;
    }

    public function cadastrar()
    {
        $funcionarioDAO = new FuncionarioDAO();
        $resultado = $funcionarioDAO->cadastrar($this);

        return $resultado;
    }

    public function atualizar()
    {
        $funcionarioDAO = new FuncionarioDAO();
        $resultado = $funcionarioDAO->atualizar($this);

        return $resultado;
    }

    public function excluir()
    {
        $funcionarioDAO = new FuncionarioDAO();
        $resultado = $funcionarioDAO->excluir($this);

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

    public function getCpf() : string
    {
        return $this->cpf;
    }

    public function setCpf(string $valor)
    {
        $this->cpf = $valor;
    }

    public function getNome() : string
    {
        return $this->nome;
    }

    public function setNome(string $valor)
    {
        $this->nome = $valor;
    }

    public function getSetor() : string
    {
        return $this->setor;
    }

    public function setSetor(string $valor)
    {
        $this->setor = $valor;
    }

    public function getSalario() : float
    {
        return $this->salario;
    }

    public function getSalarioView() : string
    {
        $valor_formatado = number_format($this->salario, 2, ',', '.');
        return $valor_formatado;
    }

    public function setSalario(float $valor)
    {
        $this->salario = $valor;
    }
}