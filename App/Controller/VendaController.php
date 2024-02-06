<?php

namespace App\Controller;

use App\Lib\Paginacao;
use App\Lib\Sessao;
use App\Model\Entidades\Venda;
use App\Model\Entidades\ProdutoVenda;
use App\Model\Entidades\Endereco;
use App\Model\Entidades\Produto;
use App\Model\Entidades\Pagamento;
use Exception;

class VendaController extends BaseController
{

    public function index()
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $paginaSelecionada = (isset($_GET['paginaSelecionada'])) ? $_GET['paginaSelecionada'] : 1;
            $busca = (isset($_GET['busca'])) ? $_GET['busca'] : "";
            $data = (isset($_GET['data'])) ? $_GET['data'] : "";
            $indice = Paginacao::calcularIndice($paginaSelecionada);
            
            $venda = new Venda();
            $resultado_venda = $venda->listarPaginacao($indice, Paginacao::$limitePorPagina, $busca, $data);

            $totalRegistros = $venda->contarTotalRegistros(
                "lote l, fornecedor f, departamento d",
                "l.cod_fornecedor = f.codigo AND f.cod_departamento = d.codigo
            AND l.data LIKE '%$busca%' AND d.nome LIKE '%$departamento%'");
            $totalPaginas = ceil($totalRegistros / Paginacao::$limitePorPagina);
            $paginacao = Paginacao::criarPaginacao('/lote', $paginaSelecionada, $totalPaginas, $busca, $departamento);

            if (is_array($resultado_lote) && is_array($resultado_fornecedor) && is_array($resultado_departamento))
            {
                    $this->setDados('lotes', $resultado_lote);
                    $this->setDados('fornecedores', $resultado_fornecedor);
                    $this->setDados('paginacao', $paginacao);
                    $this->setDados('departamentos', $resultado_departamento);
            }
            else if ($resultado_lote instanceof Exception)
                Sessao::setMensagem($resultado_lote->getMessage());
            else if ($resultado_fornecedor instanceof Exception)
                Sessao::setMensagem($resultado_fornecedor->getMessage());
            else
                Sessao::setMensagem($resultado_departamento->getMessage());
    
            $this->renderizar('lote/index');

            Sessao::setMensagem(null);
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function iniciarVenda()
    {
        if (Sessao::verificarAcesso('cliente'))
        {            
            $produto = new Produto($_POST['produto']);
            $resultado = $produto->localizar();
            
            if ($resultado instanceof Produto)
            {
                $preco_float = floatval($resultado->getPreco());
                $subtotal = $_POST['quantidade'] * $preco_float;
                
                $produtoVenda = new ProdutoVenda(
                    $resultado->getCodigo(),
                    0,
                    $_POST['quantidade'],
                    $subtotal,
                    $resultado->getNome(),
                    $preco_float,
                    $resultado->getImagem(),
                );

                $this->setDados('produto', $produtoVenda);
                Sessao::setMensagem(null);
            }
            else
                Sessao::setMensagem($resultado->getMessage());
            
            $this->renderizar('venda/endereco');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function salvarEndereco()
    {
        if (Sessao::verificarAcesso('cliente'))
        {
            $endereco = new Endereco(
                0,
                $_POST['rua'],
                $_POST['numero'],
                $_POST['bairro'],
                $_POST['cidade'],
                $_POST['estado'],
                $_POST['cliente']
            );

            $resultado = $endereco->cadastrar();

            if (is_array($resultado) && is_bool($resultado['resultado']) && $resultado['resultado'])
            {
                $endereco->setCodigo($resultado['codigo']);
                
                $produto = new Produto($_POST['produto']);
                $resultado_produto = $produto->localizar();

                if ($resultado_produto instanceof Produto)
                {
                    $preco_float = floatval($resultado_produto->getPreco());
                    $subtotal = $_POST['quantidade'] * $preco_float;
                    
                    $produtoVenda = new ProdutoVenda(
                        $resultado_produto->getCodigo(),
                        0,
                        $_POST['quantidade'],
                        $subtotal,
                        $resultado_produto->getNome(),
                        $preco_float,
                        $resultado_produto->getImagem()
                    );

                    $this->setDados('produto', $produtoVenda);
                    $this->setDados('endereco', $endereco);
                    Sessao::setMensagem(null);
                }
                else
                    Sessao::setMensagem($resultado_produto->getMessage());
            
                $this->renderizar('venda/pagamento');
            }
            else
            {
                Sessao::setMensagem($resultado->getMessage());
                $this->redirecionar('/');
            }

        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function realizarPagamento()
    {
        $totalVenda = $_POST['subtotal'];
        $pagamento = new Pagamento();
        $respostaToken = $pagamento->getAcessToken();
        $objetoToken = $respostaToken->result;
        $token = $objetoToken->access_token;
        
        if (!empty($token))
        {
            $respostaPedido = $pagamento->createOrder($token, $totalVenda);
            $objetoPedido = $respostaPedido->result;
            $urlPedido = $objetoPedido->links[1]->href;
            header("Location: " . $urlPedido);
        }
    }
}