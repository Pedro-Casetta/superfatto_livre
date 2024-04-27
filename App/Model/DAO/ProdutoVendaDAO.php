<?php

namespace App\Model\DAO;

use App\Model\Entidades\ProdutoVenda;
use Exception;
use PDO;

class ProdutoVendaDAO extends BaseDAO
{
    public function listar($cod_venda)
    {
        try {
            $pdoStatement = $this->select("SELECT pv.*, p.nome, p.preco, p.imagem
                FROM produto_venda pv, produto p
                WHERE pv.cod_produto = p.codigo AND pv.cod_venda = '$cod_venda'");

            $arrayProdutosVenda = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

            $produtosVenda = [];

            foreach($arrayProdutosVenda as $produtoVendaEncontrado)
            {
                $produtoVenda = new ProdutoVenda(
                    $produtoVendaEncontrado['cod_produto'],
                    $produtoVendaEncontrado['cod_venda'],
                    $produtoVendaEncontrado['quantidade'],
                    $produtoVendaEncontrado['subtotal'],
                    $produtoVendaEncontrado['nome'],
                    $produtoVendaEncontrado['preco'],
                    0,
                    $produtoVendaEncontrado['imagem']
                );

                $produtosVenda[] = $produtoVenda;
            }

            return $produtosVenda;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no acesso aos dados");
            return $erro;
        }
    }

    public function cadastrar(ProdutoVenda $produtoVenda)
    {
        try {
            $cod_produto = $produtoVenda->getCodigo();
            $cod_venda = $produtoVenda->getVenda()->getCodigo();
            $quantidade = $produtoVenda->getQuantidade();

            $resultado = $this->insert(
                'produto_venda',
                ':cod_produto, :cod_venda, :quantidade',
                [
                    ':cod_produto' => $cod_produto,
                    ':cod_venda' => $cod_venda,
                    ':quantidade' => $quantidade
            ]);
            
            return $resultado;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro na inserção dos dados");
            return $erro;
        }
    }
}