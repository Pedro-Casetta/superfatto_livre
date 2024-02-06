<?php

namespace App\Controller;

use App\Lib\Sessao;
use App\Model\Entidades\ProdutoCarrinho;
use App\Model\Entidades\Produto;
use App\Model\Entidades\Carrinho;
use Exception;

class ProdutoCarrinhoController extends BaseController
{

    public function index($parametros)
    {
        if (Sessao::verificarAcesso('cliente'))
        {
            $cod_carrinho = $parametros[0];
            $produtoCarrinho = new ProdutoCarrinho(0, $cod_carrinho);
            $resultado_produto = $produtoCarrinho->listar();
            
            $carrinho = new Carrinho($cod_carrinho);
            $resultado_carrinho = $carrinho->localizar();

            if (is_array($resultado_produto) && $resultado_carrinho instanceof Carrinho)
            {
                    $this->setDados('produtos_carrinho', $resultado_produto);
                    $this->setDados('carrinho', $resultado_carrinho);
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
            $produtoCarrinho = new ProdutoCarrinho(
                $_POST['produto_carrinho'],
                $_POST['carrinho'],
                $_POST['quantidade_carrinho']
            );

            $resultado = $produtoCarrinho->cadastrar();

            if (is_bool($resultado) && $resultado)
                Sessao::setMensagem("Dados inseridos com sucesso!");
            else
                Sessao::setMensagem($resultado->getMessage());

            $this->redirecionar('/');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function atualizar()
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $produtoLote = new ProdutoLote(
                $_POST['produto'],
                $_POST['lote'],
                $_POST['quantidade'],
            );

            $resultado = $produtoLote->atualizar($_POST['velho_cod_produto']);

            if (is_bool($resultado) && $resultado)
                Sessao::setMensagem("Dados atualizados com sucesso!");
            else
                Sessao::setMensagem($resultado->getMessage());

            $this->redirecionar('/produtoLote/index/' . $_POST['lote']);
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function encaminharExclusao($parametros)
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $cod_lote = $parametros[0];
            $cod_produto = $parametros[1];

            $produtoLote = new ProdutoLote($cod_produto, $cod_lote);
            $resultado = $produtoLote->localizar();

            if ($resultado instanceof ProdutoLote)
            {
                $this->setDados('produto_lote', $resultado);
                Sessao::setMensagem(null);
            }
            else
                Sessao::setMensagem($resultado->getMessage());

            $this->renderizar('produto_lote/exclusao');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function excluir()
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $cod_produto = $_POST['produto'];
            $cod_lote = $_POST['lote'];
            $produtoLote = new ProdutoLote($cod_produto, $cod_lote);
            $resultado = $produtoLote->excluir();

            if (is_bool($resultado) && $resultado)
                Sessao::setMensagem("Dados excluídos com sucesso!");
            else
                Sessao::setMensagem($resultado->getMessage());

            $this->redirecionar('/produtoLote/index/' . $cod_lote);
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }
}