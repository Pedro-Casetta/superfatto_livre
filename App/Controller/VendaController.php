<?php

namespace App\Controller;

use App\Lib\Paginacao;
use App\Lib\Sessao;
use App\Model\Entidades\Venda;
use App\Model\Entidades\ProdutoVenda;
use App\Model\Entidades\ProdutoCarrinho;
use App\Model\Entidades\Carrinho;
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
            $paginaSelecionada = (isset($_POST['paginaSelecionada'])) ? $_POST['paginaSelecionada'] : 1;
            $busca = (isset($_POST['busca'])) ? $_POST['busca'] : "";
            $data = (isset($_POST['data'])) ? $_POST['data'] : "";
            $indice = Paginacao::calcularIndice($paginaSelecionada);
            
            $venda = new Venda();
            $resultado = $venda->listarPaginacao($indice, Paginacao::$limitePorPagina, $busca, $data);

            $totalRegistros = $venda->contarTotalRegistros(
                "venda v, conta c",
                "v.cod_cliente = c.codigo AND c.nome LIKE '%$busca%' AND v.data LIKE '%$data%'");
            $totalPaginas = ceil($totalRegistros / Paginacao::$limitePorPagina);
            $paginacao = Paginacao::criarPaginacao('/venda', $paginaSelecionada, $totalPaginas, $busca, $data);

            if (is_array($resultado))
            {
                    $this->setDados('vendas', $resultado);
                    $this->setDados('paginacao', $paginacao);
            }
            else
                Sessao::setMensagem($resultado->getMessage());
    
            $this->renderizar('venda/index');

            Sessao::setMensagem(null);
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function iniciarVendaIndividual($parametros = null)
    {
        $cod_produto = (isset($_POST['produto'])) ? $_POST['produto'] : $parametros[0];
        $quantidade = (isset($_POST['quantidade'])) ? $_POST['quantidade'] : $parametros[1];
        
        $produto = new Produto($cod_produto);
        $resultado = $produto->localizar();

        if ($resultado instanceof Produto)
        {
            $subtotal = $quantidade * $resultado->getPreco();
        
            $produtoVenda = new ProdutoVenda(
                $resultado->getCodigo(),
                0,
                $quantidade,
                $subtotal,
                $resultado->getNome(),
                $resultado->getPreco(),
                $resultado->getImagem()
            );
            $resultado = [];
            $resultado[] = $produtoVenda;

            $endereco = new Endereco(0,'',0,'','','','', Sessao::getCodigoConta());
            $resultado_endereco = $endereco->listar();

            if (is_array($resultado_endereco))
            {
                $this->setDados('produtos', $resultado);
                $this->setDados('enderecos', $resultado_endereco);
            }
            else
                Sessao::setMensagem($resultado_endereco->getMessage());
        }
        else
            Sessao::setMensagem($resultado->getMessage());

        $this->renderizar('venda/endereco');
        Sessao::setMensagem(null);
    }
    
    public function iniciarVendaCarrinho()
    {
        if (Sessao::verificarAcesso('cliente'))
        {            
            $carrinho = new Carrinho(Sessao::getCodigoConta());
            $resultado = $carrinho->localizar();
            
            if ($resultado instanceof Carrinho)
            {
                $this->setDados('carrinho', $resultado);
                $produtoCarrinho = new ProdutoCarrinho(0, Sessao::getCodigoConta());
                $resultado = $produtoCarrinho->listar();
            }

            $endereco = new Endereco(0,'',0,'','','','', Sessao::getCodigoConta());
            $resultado_endereco = $endereco->listar();
            
            if (is_array($resultado) && is_array($resultado_endereco))
            {
                $this->setDados('produtos', $resultado);
                $this->setDados('enderecos', $resultado_endereco);
            }
            else if ($resultado instanceof Exception)
                Sessao::setMensagem($resultado->getMessage());
            else
                Sessao::setMensagem($resultado_endereco->getMessage());

            $this->renderizar('venda/endereco');
            Sessao::setMensagem(null);
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function salvarEndereco()
    {
        if (Sessao::verificarAcesso('cliente'))
        {
            if (empty($_POST['endereco']) && !empty($_POST['rua']) && !empty($_POST['numero'])
            && !empty($_POST['bairro']) && !empty($_POST['cidade']) && !empty($_POST['estado'])
            && !empty($_POST['cep']))
            {
                $endereco = new Endereco(
                    0,
                    $_POST['rua'],
                    $_POST['numero'],
                    $_POST['bairro'],
                    $_POST['cidade'],
                    $_POST['estado'],
                    $_POST['cep'],
                    Sessao::getCodigoConta()
                );
            
                $resultado = $endereco->cadastrar();

                if (is_array($resultado) && is_bool($resultado['resultado'] && $resultado['resultado']))
                    $endereco->setCodigo($resultado['codigo']);

            } else if (!empty($_POST['endereco']) && empty($_POST['rua']) && empty($_POST['numero'])
            && empty($_POST['bairro']) && empty($_POST['cidade']) && empty($_POST['estado'])
            && empty($_POST['cep']))
            {
                $endereco = new Endereco($_POST['endereco']);
                $resultado = $endereco->localizar();
            }
            else
            {
                Sessao::setMensagem("Selecione um endereço ou cadastre um novo!");
                $this->redirecionar('/venda/iniciarVenda' . 
                (isset($_POST['produto']) ? 'Individual/' . $_POST['produto'] . '/' . $_POST['quantidade'] : 'Carrinho'));
            }

            if (is_array($resultado) || $resultado instanceof Endereco)
            {
                if (isset($_POST['produto']))
                {
                    $produto = new Produto($_POST['produto']);
                    $resultado_produto = $produto->localizar();
                    
                    if ($resultado_produto instanceof Produto)
                    {
                        $subtotal = $_POST['quantidade'] * $resultado_produto->getPreco();
                        
                        $produtoVenda = new ProdutoVenda(
                            $resultado_produto->getCodigo(),
                            0,
                            $_POST['quantidade'],
                            $subtotal,
                            $resultado_produto->getNome(),
                            $resultado_produto->getPreco(),
                            $resultado_produto->getImagem()
                        );
                    
                        $resultado_produto = [];
                        $resultado_produto[] = $produtoVenda;
                    }
                }
                else
                {
                    $carrinho = new Carrinho(Sessao::getCodigoConta());
                    $resultado_carrinho = $carrinho->localizar();
                    
                    if ($resultado_carrinho instanceof Carrinho)
                    {
                        $this->setDados('carrinho', $resultado_carrinho);
                        $produtoCarrinho = new ProdutoCarrinho(0, Sessao::getCodigoConta());
                        $resultado_produto = $produtoCarrinho->listar();
                    }
                    else
                        Sessao::setMensagem($resultado_carrinho->getMessage());
                }

                if (is_array($resultado_produto))
                {
                    $this->setDados('produtos', $resultado_produto);
                    $this->setDados('endereco', ($resultado instanceof Endereco) ? $resultado : $endereco);
                }
                else
                    Sessao::setMensagem($resultado_produto->getMessage());
                
                $this->renderizar('venda/pagamento');
                Sessao::setMensagem(null);
            }
            else
            {
                Sessao::setMensagem($resultado->getMessage());
                $this->redirecionar('/venda/iniciarVenda' . 
                (isset($_POST['produto']) ? 'Individual/' . $_POST['produto'] . '/' . $_POST['quantidade'] : 'Carrinho'));
            }

        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function realizarPagamento()
    {
        $totalVenda = $_POST['total'];
        $pagamento = new Pagamento();
        $respostaToken = $pagamento->getAcessToken();
        $objetoToken = $respostaToken->result;
        $token = $objetoToken->access_token;
        
        if (!empty($token))
        {
            $endereco = new Endereco($_POST['endereco']);
            $resultado = $endereco->localizar();
            
            if ($resultado instanceof Endereco)
            {
                $venda = new Venda(0, '', 0.0, 'Aguardando pagamento', "", Sessao::getCodigoConta(),
                '', $_POST['endereco']);
                $resultado_venda = $venda->cadastrar();
                
                if (is_array($resultado_venda) && is_bool($resultado_venda['resultado'] && $resultado_venda['resultado']))
                {                    
                    $respostaPedido = $pagamento->createOrder($token, $totalVenda, $resultado, $resultado_venda['codigo']);
                    $objetoPedido = $respostaPedido->result;

                    $venda->setCodigo($resultado_venda['codigo']);
                    $venda->setIdPagamento($objetoPedido->id);
                    $venda->atualizar();
                    
                    if (isset($_POST['produto']))
                    {
                        $produtoVenda = new ProdutoVenda($_POST['produto'], $resultado_venda['codigo'], $_POST['quantidade']);
                        $resultado_produto = $produtoVenda->cadastrar();

                        if ($resultado_produto instanceof Exception)
                        {
                            Sessao::setMensagem($resultado_produto->getMessage());
                            $this->redirecionar('/');
                            exit;
                        }
                    }
                    else
                    {
                        $produtosCarrinho = new ProdutoCarrinho(0, Sessao::getCodigoConta());
                        $resultado_produto = $produtosCarrinho->listar();

                        if (is_array($resultado_produto))
                        {
                            foreach ($resultado_produto as $produtoCarrinho)
                            {
                                $produtoVenda = new ProdutoVenda(
                                    $produtoCarrinho->getCodigo(),
                                    $resultado_venda['codigo'],
                                    $produtoCarrinho->getQuantidade()
                                );
                                $resultado_produtoVenda = $produtoVenda->cadastrar();
                                $produtoCarrinho->excluir();

                                if ($resultado_produtoVenda instanceof Exception)
                                {
                                    Sessao::setMensagem($resultado_produtoVenda->getMessage());
                                    $this->redirecionar('/conta/encaminharPerfil');
                                    exit;
                                }
                            }
                        }
                    }

                    if (is_array($resultado_produto) || is_bool($resultado_produto) && $resultado_produto)
                    {
                        $urlPedido = $objetoPedido->links[1]->href;
                        header("Location: " . $urlPedido);
                    }
                    else
                    {
                        Sessao::setMensagem($resultado_produto->getMessage());
                        $this->redirecionar('/');
                    }
                }
                else
                {
                    Sessao::setMensagem($resultado_venda->getMessage());
                    $this->redirecionar('/');
                }
            }
            else
            {
                Sessao::setMensagem($resultado->getMessage());
                $this->redirecionar('/');
            }
        }
    }

    public function realizarPagamentoPendente($parametros)
    {
        if (Sessao::verificarAcesso('cliente'))
        {
            $pagamento = new Pagamento();
            $respostaToken = $pagamento->getAcessToken();
            $objetoToken = $respostaToken->result;
            $token = $objetoToken->access_token;

            $venda = new Venda($parametros[0]);
            $resultado = $venda->localizar();

            if ($resultado instanceof Venda)
            {
                $respostaPedido = $pagamento->getOrder($resultado->getIdPagamento(), $token);
                $objetoPedido = $respostaPedido->result;

                $urlPedido = $objetoPedido->links[1]->href;
                header("Location: " . $urlPedido);
            }
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }
    
    public function autorizarPagamento()
    {
        $pagamento = new Pagamento();
        $respostaToken = $pagamento->getAcessToken();
        $objetoToken = $respostaToken->result;
        $token = $objetoToken->access_token;
        
        if (!empty($token) && isset($_GET['token']))
        {
            $requisicao = $pagamento->authorizePayment($token, $_GET['token']);
            $objetoPagamento = $requisicao->result;

            if ($objetoPagamento->status == "COMPLETED")
            {
                $this->redirecionar('/venda/encaminharConclusao?token=' . $_GET['token']);
            }
            else
            {
                Sessao::setMensagem("Erro ao capturar pagamento");
                $this->redirecionar('/conta/visualizarCompras');
            }
        }
    }

    public function encaminharConclusao()
    {
        $venda = new Venda(0, "", 0.0, "", $_GET['token']);
        $resultado = $venda->localizar();

        if ($resultado instanceof Venda)
        {
            $venda = $resultado;
            $venda->setSituacao("Pagamento efetuado, entrega em andamento.");
            
            $produtosVenda = new ProdutoVenda(0, $resultado->getCodigo());
            $resultado_produto = $produtosVenda->listar();
            
            $resultado_venda = $venda->atualizar();

            if (is_array($resultado_produto) && is_bool($resultado_venda) && $resultado_venda)
            {
                $this->setDados('venda', $resultado);
                $this->setDados('produtos', $resultado_produto);
            }
            else
                Sessao::setMensagem($resultado_produto->getMessage());
        }
        else
            Sessao::setMensagem($resultado->getMessage());
        
        $this->renderizar('venda/conclusao');
        Sessao::setMensagem(null);
    }

    public function indexCompras()
    {
        if (Sessao::verificarAcesso('cliente'))
        {
            $paginaSelecionada = (isset($_GET['paginaSelecionada'])) ? $_GET['paginaSelecionada'] : 1;
            $busca = (isset($_GET['busca'])) ? $_GET['busca'] : "";
            $data = (isset($_GET['data'])) ? $_GET['data'] : "";
            $indice = Paginacao::calcularIndice($paginaSelecionada);
            
            $venda = new Venda(0,'',0.0,'','',Sessao::getCodigoConta());
            $resultado = $venda->listarPaginacaoCliente($indice, Paginacao::$limitePorPagina, $busca, $data);
            
            $totalRegistros = $venda->contarTotalRegistros(
                "venda v, endereco e",
                "v.cod_endereco = e.codigo AND v.cod_cliente = " . Sessao::getCodigoConta() . "
                AND v.data LIKE '%$data%' AND v.total LIKE '%$busca%' OR v.situacao LIKE '%$busca%'
                OR e.rua LIKE '%$busca%' OR e.numero LIKE '%$busca%' OR e.bairro LIKE '%$busca%'
                OR e.cidade LIKE '%$busca%' OR e.estado LIKE '%$busca%' OR e.cep LIKE '%$busca%'");
            $totalPaginas = ceil($totalRegistros / Paginacao::$limitePorPagina);
            $paginacao = Paginacao::criarPaginacao('/venda/indexCompras', $paginaSelecionada, $totalPaginas, $busca, $data);

            if (is_array($resultado))
            {
                    $this->setDados('vendas', $resultado);
                    $this->setDados('paginacao', $paginacao);
            }
            else
                Sessao::setMensagem($resultado->getMessage());
    
            $this->renderizar('venda/indexCompras');
            Sessao::setMensagem(null);
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function indexProdutosCompra($parametros)
    {
        if (Sessao::verificarAcesso('cliente'))
        {
            $venda = new Venda($parametros[0]);
            $resultado_venda = $venda->localizar();
            
            $produtoVenda = new ProdutoVenda(0, $parametros[0]);
            $resultado = $produtoVenda->listar();

            if (is_array($resultado) && $resultado_venda instanceof Venda)
            {
                $this->setDados('venda', $resultado_venda);
                $this->setDados('produtos_venda', $resultado);
            }
            else if ($resultado instanceof Exception)
                Sessao::setMensagem($resultado->getMessage());
            else
                Sessao::setMensagem($resultado_venda->getMessage());
    
            $this->renderizar('venda/indexProdutosCompra');
            Sessao::setMensagem(null);
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function excluir($parametros)
    {
        if (Sessao::verificarAcesso('cliente'))
        {
            $codigo = $parametros[0];
            $venda = new Venda($codigo);
            $resultado = $venda->excluir();

            if ($resultado instanceof Exception)
                Sessao::setMensagem($resultado->getMessage());

            $this->redirecionar('/');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }
}