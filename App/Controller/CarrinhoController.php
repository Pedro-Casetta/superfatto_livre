<?php

namespace App\Controller;

use App\Lib\Sessao;
use App\Model\Entidades\ProdutoCarrinho;
use App\Model\Entidades\Carrinho;
use App\Model\DAO\ProdutoDAO;
use Exception;

class CarrinhoController extends BaseController
{

    public function index()
    {
        if (Sessao::verificarAcesso('cliente'))
        {
            $cod_carrinho = Sessao::getCodigoConta();
            $produtoCarrinho = new ProdutoCarrinho(0, $cod_carrinho);
            $resultado_produto = $produtoCarrinho->listar();
            
            $carrinho = new Carrinho($cod_carrinho);
            $resultado_carrinho = $carrinho->localizar();

            $produtoDAO = new ProdutoDAO();
            $resultado_departamento = $produtoDAO->listarDepartamentos();

            if (is_array($resultado_produto) && $resultado_carrinho instanceof Carrinho && is_array($resultado_departamento))
            {
                    $this->setDados('produtos_carrinho', $resultado_produto);
                    $this->setDados('carrinho', $resultado_carrinho);
                    $this->setDados('departamentos', $resultado_departamento);
            }
            else if ($resultado_produto instanceof Exception)
                Sessao::setMensagem($resultado_produto->getMessage());
            else
                Sessao::setMensagem($resultado_carrinho->getMessage());
    
            $this->renderizar('carrinho/index');

            Sessao::setMensagem(null);
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function inserirNoCarrinho()
    {
        if (Sessao::verificarAcesso('cliente'))
        {
            if ($_POST['quantidade_carrinho'] <= $_POST['estoque'])
            {
                $produtoCarrinho = new ProdutoCarrinho(
                    $_POST['produto_carrinho'],
                    $_POST['carrinho'],
                    $_POST['quantidade_carrinho']
                );

                $resultado = $produtoCarrinho->cadastrar();

                if ($resultado instanceof Exception)
                    Sessao::setMensagem($resultado->getMessage());

                $this->redirecionar('/');
            }
            else
            {
                Sessao::setFormulario($_POST);
                Sessao::setValidacaoFormulario(['quantidade_carrinho' => false]);
                $this->redirecionar('/produto/detalhesProduto/' . $_POST['produto_carrinho']);
            }
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function diminuirQuantidade($parametros)
    {
        if (Sessao::verificarAcesso('cliente'))
        {
            $cod_produto = $parametros[0];
            $cod_carrinho = Sessao::getCodigoConta();

            $produtoCarrinho = new ProdutoCarrinho($cod_produto, $cod_carrinho);
            $resultado = $produtoCarrinho->diminuirQuantidade();

            if ($resultado instanceof Exception)
                Sessao::setMensagem($resultado->getMessage());

            $this->redirecionar('/carrinho/index');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function alterarQuantidade($parametros)
    {
        if (Sessao::verificarAcesso('cliente'))
        {
            $cod_produto = $parametros[0];
            $cod_carrinho = Sessao::getCodigoConta();
            $quantidade = $_POST['quantidade'];

            $produtoCarrinho = new ProdutoCarrinho($cod_produto, $cod_carrinho);
            $resultado = $produtoCarrinho->localizar();
            
            if ($resultado instanceof ProdutoCarrinho)
            {
                $estoque = $resultado->getEstoque();
                if ($quantidade <= $estoque && $quantidade > 0)
                {
                    $resultado->setQuantidade($quantidade);
                    $resultado_atualizacao = $resultado->atualizar();
                    if ($resultado_atualizacao instanceof Exception)
                        Sessao::setMensagem($resultado_atualizacao->getMessage());
                }
            }
            else if ($resultado instanceof Exception)
                Sessao::setMensagem($resultado->getMessage());
        }
        else
        $this->redirecionar('/conta/encaminharAcesso');
}

public function aumentarQuantidade($parametros)
{
    if (Sessao::verificarAcesso('cliente'))
    {
        $cod_produto = $parametros[0];
            $cod_carrinho = Sessao::getCodigoConta();

            $produtoCarrinho = new ProdutoCarrinho($cod_produto, $cod_carrinho);
            $resultado = $produtoCarrinho->aumentarQuantidade();

            if ($resultado instanceof Exception)
                Sessao::setMensagem($resultado->getMessage());

            $this->redirecionar('/carrinho/index');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }


    public function removerProduto($parametros)
    {
        if (Sessao::verificarAcesso('cliente'))
        {
            $cod_produto = $parametros[0];
            $cod_carrinho = Sessao::getCodigoConta();
            $produtoCarrinho = new ProdutoCarrinho($cod_produto, $cod_carrinho);
            $resultado = $produtoCarrinho->excluir();

            if ($resultado instanceof Exception)
                Sessao::setMensagem($resultado->getMessage());

            $this->redirecionar('/carrinho/index');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }
}