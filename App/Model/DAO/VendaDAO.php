<?php

namespace App\Model\DAO;

use App\Model\Entidades\Venda;
use Exception;
use PDO;

class VendaDAO extends BaseDAO
{
    public function localizar($codigo)
    {
        try {
            $pdoStatement = $this->select("SELECT v.* c.nome FROM venda v, conta c
            WHERE v.codigo = $codigo AND c.codigo = v.cod_cliente");
            
            $arrayResultado = $pdoStatement->fetch(PDO::FETCH_ASSOC);

            $venda = new Venda(
                $arrayResultado['codigo'],
                $arrayResultado['data'],
                $arrayResultado['total'],
                $arrayResultado['situacao'],
                $arrayResultado['cod_cliente'],
                $arrayResultado['nome']
            );
            
            return $venda;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no acesso aos dados");
            return $erro;
        }
    }

    public function listarPaginacao($indice, $limitePorPagina, $busca = "", $data = "")
    {
        try {
            $pdoStatement = $this->select("SELECT v.*, c.nome FROM venda v, conta c
                WHERE v.cod_cliente = c.codigo
            AND c.nome LIKE '%$busca%' AND v.data LIKE '%$data%' LIMIT $indice, $limitePorPagina");

            $arrayVendas = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

            $vendas = [];

            foreach($arrayVendas as $vendaEncontrada)
            {
                $venda = new Venda(
                    $vendaEncontrada['codigo'],
                    $vendaEncontrada['data'],
                    $vendaEncontrada['total'],
                    $vendaEncontrada['situacao'],
                    $vendaEncontrada['cod_cliente'],
                    $vendaEncontrada['nome']
                );

                $vendas[] = $venda;
            }

            return $vendas;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no acesso aos dados");
            return $erro;
        }
    }

    public function cadastrar(Venda $venda)
    {
        try {
            $data = $venda->getData();
            $cod_cliente = $venda->getCliente()->getCodigo();
            
            $resultado = $this->insert(
                'venda',
                ':cod_cliente',
                [':cod_cliente' => $cod_cliente]);
                
            $cod_venda = $this->getConexao()->lastInsertId();
            $arrayRetorno = ['resultado' => $resultado, 'cod_venda' => $cod_venda];

            return $arrayRetorno;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no cadastro dos dados");
            return $erro;
        }
    }

    public function atualizar(Lote $lote)
    {
        try {
            $codigo = $lote->getCodigo();
            $data = $lote->getData();
            $cod_fornecedor = $lote->getFornecedor()->getCodigo();

            $resultado = $this->update(
                'lote',
                'data = :data, cod_fornecedor = :cod_fornecedor',
                [
                 ':data' => $data,
                 ':cod_fornecedor' => $cod_fornecedor
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

    public function excluir(Lote $lote)
    {
        try {
            $codigo = $lote->getCodigo();
            $resultado = $this->delete('lote', 'codigo = ' . $codigo);

            return $resultado;
        }
        catch (Exception $excecao) {
            if ($excecao->getCode() == 23000)
                $erro = new Exception("Erro " . $excecao->getCode() . ". Lote não foi excluído pois contém produtos.");
            else
                $erro = new Exception("Erro " . $excecao->getCode() . ". Erro na exclusão dos dados");
            return $erro;
        }
    }
}