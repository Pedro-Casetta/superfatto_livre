<?php

namespace App\Model\DAO;

use App\Model\Entidades\Fornecedor;
use Exception;
use PDO;

class FornecedorDAO extends BaseDAO
{
    public function localizar($codigo)
    {
        try {
            $pdoStatement = $this->select("SELECT f.*, d.nome nome_departamento FROM fornecedor f, departamento d
                WHERE f.codigo = $codigo AND d.codigo = f.cod_departamento");

            $arrayResultado = $pdoStatement->fetch(PDO::FETCH_ASSOC);

            $fornecedor = new Fornecedor(
                $arrayResultado['codigo'],
                $arrayResultado['cnpj'],
                $arrayResultado['nome'],
                $arrayResultado['cod_departamento'],
                $arrayResultado['nome_departamento']
            );
            
            return $fornecedor;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no acesso aos dados");
            return $erro;
        }
    }
    
    public function listar()
    {
        try {
            $pdoStatement = $this->select("SELECT f.*, d.nome nome_departamento FROM fornecedor f, departamento d
                WHERE f.cod_departamento = d.codigo");

            $arrayFornecedores = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

            $fornecedores = [];

            foreach($arrayFornecedores as $fornecedorEncontrado)
            {
                $fornecedor = new Fornecedor(
                    $fornecedorEncontrado['codigo'],
                    $fornecedorEncontrado['cnpj'],
                    $fornecedorEncontrado['nome'],
                    $fornecedorEncontrado['cod_departamento'],
                    $fornecedorEncontrado['nome_departamento']
                );

                $fornecedores[] = $fornecedor;
            }

            return $fornecedores;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no acesso aos dados");
            return $erro;
        }
    }

    public function listarPaginacao($indice, $limitePorPagina, $busca = "", $departamento = "")
    {
        try {
            $pdoStatement = $this->select("SELECT f.*, d.nome nome_departamento FROM fornecedor f
            INNER JOIN departamento d ON d.codigo = f.cod_departamento
            WHERE f.cnpj LIKE '%$busca%' AND d.nome LIKE '%$departamento%'
            OR f.nome LIKE '%$busca%' AND d.nome LIKE '%$departamento%' LIMIT $indice, $limitePorPagina");

            $arrayFornecedores = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

            $fornecedores = [];

            foreach($arrayFornecedores as $fornecedorEncontrado)
            {
                $fornecedor = new Fornecedor(
                    $fornecedorEncontrado['codigo'],
                    $fornecedorEncontrado['cnpj'],
                    $fornecedorEncontrado['nome'],
                    $fornecedorEncontrado['cod_departamento'],
                    $fornecedorEncontrado['nome_departamento']
                );

                $fornecedores[] = $fornecedor;
            }

            return $fornecedores;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no acesso aos dados");
            return $erro;
        }
    }

    public function cadastrar(Fornecedor $fornecedor)
    {
        try {
            $cnpj = $fornecedor->getCnpj();
            $nome = $fornecedor->getNome();
            $cod_departamento = $fornecedor->getDepartamento()->getCodigo();

            $resultado = $this->insert(
                'fornecedor',
                ':cnpj, :nome, :cod_departamento',
                [
                    ':cnpj' => $cnpj,
                    ':nome' => $nome,
                    ':cod_departamento' => $cod_departamento
            ]);
            
            return $resultado;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no cadastro dos dados");
            return $erro;
        }
    }

    public function atualizar(Fornecedor $fornecedor)
    {
        try {
            $codigo = $fornecedor->getCodigo();
            $cnpj = $fornecedor->getCnpj();
            $nome = $fornecedor->getNome();
            $cod_departamento = $fornecedor->getDepartamento()->getCodigo();

            $resultado = $this->update(
                'fornecedor',
                'cnpj = :cnpj, nome = :nome, cod_departamento = :cod_departamento',
                [
                 ':cnpj' => $cnpj,
                 ':nome' => $nome,
                 ':cod_departamento' => $cod_departamento
                ],
                'codigo = ' . $codigo
            );
            
            return $resultado;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro na atualização dos dados");
            return $erro;
        }
    }

    public function excluir(Fornecedor $fornecedor)
    {
        try {
            $codigo = $fornecedor->getCodigo();
            $resultado = $this->delete('fornecedor', 'codigo = ' . $codigo);

            return $resultado;
        }
        catch (Exception $excecao) {
            if ($excecao->getCode() == 23000)
                $erro = new Exception("Erro " . $excecao->getCode() . ". Fornecedor não foi excluído pois está em um lote.");
            else
                $erro = new Exception("Erro " . $excecao->getCode() . ". Erro na exclusão dos dados");
            return $erro;
        }
    }
}