<?php

namespace App\Model\DAO;

use App\Model\Entidades\ProdutoCarrinho;
use Exception;
use PDO;

class ProdutoCarrinhoDAO extends BaseDAO
{
    public function localizar($cod_produto, $cod_carrinho)
    {
        try {
            $pdoStatement = $this->select(
                "SELECT pc.*, p.nome, p.preco, p.imagem
                FROM produto_carrinho pc, produto p
                WHERE pc.cod_produto = $cod_produto AND pc.cod_carrinho = $cod_carrinho
                AND p.codigo = pc.cod_produto");
            
            $arrayResultado = $pdoStatement->fetch(PDO::FETCH_ASSOC);

            $produtoCarrinho = new ProdutoCarrinho(
                $arrayResultado['cod_produto'],
                $arrayResultado['cod_carrinho'],
                $arrayResultado['quantidade'],
                $arrayResultado['subtotal'],
                $arrayResultado['nome'],
                $arrayResultado['preco'],
                $arrayResultado['imagem']
            );
            
            return $produtoCarrinho;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no acesso aos dados");
            return $erro;
        }
    }

    public function listar($cod_carrinho)
    {
        try {
            $pdoStatement = $this->select("SELECT pc.*, p.nome, p.preco, p.imagem
                FROM produto_carrinho pc, produto p
                WHERE pc.cod_produto = p.codigo AND pc.cod_carrinho = $cod_carrinho");

            $arrayProdutosCarrinho = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

            $produtosCarrinho = [];

            foreach($arrayProdutosCarrinho as $produtoCarrinhoEncontrado)
            {
                $produtoCarrinho = new ProdutoCarrinho(
                    $produtoCarrinhoEncontrado['cod_produto'],
                    $produtoCarrinhoEncontrado['cod_carrinho'],
                    $produtoCarrinhoEncontrado['quantidade'],
                    $produtoCarrinhoEncontrado['subtotal'],
                    $produtoCarrinhoEncontrado['nome'],
                    $produtoCarrinhoEncontrado['preco'],
                    $produtoCarrinhoEncontrado['imagem']
                );

                $produtosCarrinho[] = $produtoCarrinho;
            }

            return $produtosCarrinho;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro no acesso aos dados");
            return $erro;
        }
    }

    public function cadastrar(ProdutoCarrinho $produtoCarrinho)
    {
        try {
            $cod_produto = $produtoCarrinho->getCodigo();
            $cod_carrinho = $produtoCarrinho->getCarrinho()->getCodigo();
            $quantidade = $produtoCarrinho->getQuantidade();

            $resultado = $this->insert(
                'produto_carrinho',
                ':cod_produto, :cod_carrinho, :quantidade',
                [
                    ':cod_produto' => $cod_produto,
                    ':cod_carrinho' => $cod_carrinho,
                    ':quantidade' => $quantidade
            ]);
            
            return $resultado;
        }
        catch (Exception $excecao) {
            if ($excecao->getCode() == 23000)
                $erro = new Exception("Erro " . $excecao->getCode() . ". Esse produto já existe nesse carrinho.");
            else
                $erro = new Exception("Erro " . $excecao->getCode() . ". Erro na inserção dos dados");
            return $erro;
        }
    }

    public function atualizar(ProdutoCarrinho $produtoCarrinho)
    {
        try {
            $cod_produto = $produtoCarrinho->getCodigo();
            $cod_carrinho = $produtoCarrinho->getCarrinho()->getCodigo();
            $quantidade = $produtoCarrinho->getQuantidade();

            $resultado = $this->update(
                'produto_carrinho',
                'quantidade = :quantidade',
                [
                 ':quantidade' => $quantidade
                ],
                'cod_produto = ' . $cod_produto . ' AND cod_carrinho = ' . $cod_carrinho
            );
            
            return $resultado;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro na atualização dos dados");
            return $erro;
        }
    }

    public function excluir(ProdutoCarrinho $produtoCarrinho)
    {
        try {
            $cod_produto = $produtoCarrinho->getCodigo();
            $cod_carrinho = $produtoCarrinho->getCarrinho()->getCodigo();
            $resultado = $this->delete('produto_carrinho', 'cod_produto = ' . $cod_produto . ' AND cod_carrinho = ' . $cod_carrinho);

            return $resultado;
        }
        catch (Exception $excecao) {
            $erro = new Exception("Erro " . $excecao->getCode() . ". Erro na exclusão dos dados");
            return $erro;
        }
    }
}