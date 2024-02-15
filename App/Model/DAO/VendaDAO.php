<?php

namespace App\Model\DAO;

use App\Model\Entidades\Venda;
use Exception;
use PDO;

class VendaDAO extends BaseDAO
{
    public function localizar($codigo, $idPagamento)
    {
        try {
            $pdoStatement = $this->select("SELECT v.*, c.nome, e.rua, e.numero, e.bairro, e.cidade, e.estado, e.cep
            FROM venda v
            INNER JOIN conta c ON c.codigo = v.cod_cliente
            INNER JOIN endereco e ON e.codigo = v.cod_endereco
            WHERE v.codigo = $codigo OR v.id_pagamento = '$idPagamento'");
            
            $arrayResultado = $pdoStatement->fetch(PDO::FETCH_ASSOC);

            $venda = new Venda(
                $arrayResultado['codigo'],
                $arrayResultado['data'],
                $arrayResultado['total'],
                $arrayResultado['situacao'],
                $arrayResultado['id_pagamento'],
                $arrayResultado['cod_cliente'],
                "",
                $arrayResultado['cod_endereco'],
                $arrayResultado['rua'],
                $arrayResultado['numero'],
                $arrayResultado['bairro'],
                $arrayResultado['cidade'],
                $arrayResultado['estado'],
                $arrayResultado['cep']
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
            WHERE v.cod_cliente = c.codigo AND c.nome LIKE '%$busca%'
            AND v.data LIKE '%$data%' LIMIT $indice, $limitePorPagina");

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

    public function listarPaginacaoCliente($indice, $limitePorPagina, $busca = "", $data = "", $cod_cliente)
    {
        try {
            $pdoStatement = $this->select("SELECT v.*, c.nome FROM venda v, conta c
                WHERE v.cod_cliente = c.codigo AND v.cod_cliente = $cod_cliente
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
            $situacao = $venda->getSituacao();
            $idPagamento = $venda->getIdPagamento();
            $cod_cliente = $venda->getCliente()->getCodigo();
            $cod_endereco = $venda->getEndereco()->getCodigo();
            
            $resultado = $this->insert(
                'venda',
                ':situacao, :id_pagamento, :cod_cliente, :cod_endereco',
                [
                    ':situacao' => $situacao,
                    ':id_pagamento' => $idPagamento,
                    ':cod_cliente' => $cod_cliente,
                    ':cod_endereco' => $cod_endereco]);
                
            $cod_venda = $this->getConexao()->lastInsertId();
            $arrayRetorno = ['resultado' => $resultado, 'codigo' => $cod_venda];

            return $arrayRetorno;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no cadastro dos dados");
            return $erro;
        }
    }
}