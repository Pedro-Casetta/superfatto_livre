<?php

namespace App\Controller;

use App\Lib\Paginacao;
use App\Lib\Sessao;
use App\Lib\Validador;
use App\Model\Entidades\Venda;
use App\Model\Entidades\ProdutoVenda;
use App\Model\Entidades\ProdutoCarrinho;
use App\Model\Entidades\Carrinho;
use App\Model\Entidades\Departamento;
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
            $resultado = $venda->listarPaginacao($indice, Paginacao::$limitePorPagina, $busca, $data);

            $totalRegistros = $venda->contarTotalRegistros(
                "venda v INNER JOIN conta c ON c.codigo = v.cod_cliente",
                "c.nome LIKE '%$busca%' AND v.data LIKE '%$data%'");
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
        if (Sessao::verificarAcesso('cliente'))
        {
            $cod_produto = (isset($_POST['produto'])) ? $_POST['produto'] : $parametros[0];
            $quantidade = (isset($_POST['quantidade'])) ? $_POST['quantidade'] : $parametros[1];
            $estoque = (isset($_POST['estoque'])) ? $_POST['estoque'] : $parametros[2];

            if ($quantidade <= $estoque)
            {
                $produto = new Produto($cod_produto);
                $resultado = $produto->localizar();

                $departamento = new Departamento();
                $resultado_departamento = $departamento->listar();
                
                if (is_array($resultado_departamento))
                    $this->setDados('departamentos', $resultado_departamento);
                else
                    Sessao::setMensagem($resultado_departamento->getMessage());
                
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
                        $resultado->getEstoque(),
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

                if (Sessao::getFormulario() && Sessao::getValidacaoFormulario())
                {
                    $this->setDados('formulario', Sessao::getFormulario());
                    $this->setDados('validacao', Sessao::getValidacaoFormulario());
                }

                $this->renderizar('venda/endereco');
                Sessao::setMensagem(null);
                Sessao::setFormulario(null);
                Sessao::setValidacaoFormulario(null);    
            }
            else
            {
                Sessao::setFormulario($_POST);
                Sessao::setValidacaoFormulario(['quantidade_validada' => false]);
                $this->redirecionar('/produto/detalhesProduto/' . $cod_produto);
            }
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }
    
    public function iniciarVendaCarrinho()
    {
        if (Sessao::verificarAcesso('cliente'))
        {
            $carrinho = new Carrinho(Sessao::getCodigoConta());
            $resultado = $carrinho->localizar();
            
            $departamento = new Departamento();
            $resultado_departamento = $departamento->listar();
                        
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

            if (Sessao::getFormulario() && Sessao::getValidacaoFormulario())
            {
                $this->setDados('formulario', Sessao::getFormulario());
                $this->setDados('validacao', Sessao::getValidacaoFormulario());
            }

            if (is_array($resultado_departamento))
                $this->setDados('departamentos', $resultado_departamento);
            else
                Sessao::setMensagem($resultado_departamento->getMessage());
                
            $this->renderizar('venda/endereco');
            Sessao::setMensagem(null);
            Sessao::setFormulario(null);
            Sessao::setValidacaoFormulario(null);
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
                $rua_validada = Validador::validarNome($_POST['rua']);
                $bairro_validado = Validador::validarNome($_POST['bairro']);
                $cidade_validada = Validador::validarNome($_POST['cidade']);
                $cep_validado = Validador::validarCep($_POST['cep']);

                $validacao_formulario = [
                    'rua_validada' => $rua_validada,
                    'bairro_validado' => $bairro_validado,
                    'cidade_validada' => $cidade_validada,
                    'cep_validado' => $cep_validado
                    ];

                if (in_array(false, $validacao_formulario))
                {
                    Sessao::setFormulario($_POST);
                    Sessao::setValidacaoFormulario($validacao_formulario);
                    $this->redirecionar('/venda/iniciarVenda' .
                    (isset($_POST['produto']) ? 'Individual/' . $_POST['produto'] . '/' .
                    $_POST['quantidade'] . '/' . $_POST['estoque'] : 'Carrinho'));
                    exit;
                }
                
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
                (isset($_POST['produto']) ? 'Individual/' . $_POST['produto'] . '/' . $_POST['quantidade'] .
                '/' . $_POST['estoque'] : 'Carrinho'));
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
                            $resultado_produto->getEstoque(),
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

                $departamento = new Departamento();
                $resultado_departamento = $departamento->listar();

                if (is_array($resultado_departamento))
                    $this->setDados('departamentos', $resultado_departamento);
                else
                    Sessao::setMensagem($resultado_departamento->getMessage());
                
                $this->renderizar('venda/pagamento');
                Sessao::setMensagem(null);
            }
            else
            {
                Sessao::setMensagem($resultado->getMessage());
                $this->redirecionar('/venda/iniciarVenda' . 
                (isset($_POST['produto']) ? 'Individual/' . $_POST['produto'] . '/' . $_POST['quantidade'] .
                '/' . $_POST['estoque'] : 'Carrinho'));
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
        $idProdutos = [];
        $qtdProdutos = [];
        
        if (!empty($token))
        {
            $endereco = new Endereco($_POST['endereco']);
            $resultado = $endereco->localizar();
            
            if ($resultado instanceof Endereco)
            {   
                if (isset($_POST['produto']))
                {
                    $idProdutos[] = $_POST['produto'];
                    $qtdProdutos[] = $_POST['quantidade'];
                }
                else
                {
                    $produtoCarrinho = new ProdutoCarrinho(0, Sessao::getCodigoConta());
                    $resultado_produto = $produtoCarrinho->listar();
                    
                    if (is_array($resultado_produto))
                    {
                        foreach ($resultado_produto as $produto)
                        {
                            $idProdutos[] = $produto->getCodigo();
                            $qtdProdutos[] = $produto->getQuantidade();
                        }
                    }
                    else
                    {
                        Sessao::setMensagem($resultado_produto->getMessage());
                        $this->redirecionar('/');
                        exit;
                    }
                }

                $respostaPedido = $pagamento->createOrder($token, $totalVenda, $resultado, $idProdutos, $qtdProdutos);
                $objetoPedido = $respostaPedido->result;
                
                $urlPedido = $objetoPedido->links[1]->href;
                header("Location: " . $urlPedido);
            }
            else
            {
                Sessao::setMensagem($resultado->getMessage());
                $this->redirecionar('/');
            }
        }
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
                $this->redirecionar("/venda/encaminharConclusao?token=" . $_GET['token'] .
                "&endereco=" . $_GET['endereco'] . "&produtos=" . $_GET['produtos'] . "&quantidades=" . $_GET['quantidades']
                );
            }
            else
            {
                Sessao::setMensagem("Erro ao capturar pagamento");
                $this->redirecionar('/venda/indexCompras');
            }
        }
    }

    public function encaminharConclusao()
    {
        $venda = new Venda(0, "", 0.0, "", $_GET['token']);
        $resultado = $venda->localizar();

        if (!$resultado instanceof Venda)
        {
            $venda = new Venda(0, '', 0.0,
            'Pagamento efetuado, entrega em andamento.',
            $_GET['token'],
            Sessao::getCodigoConta(),
            '',
            $_GET['endereco']
            );
            $resultado = $venda->cadastrar();

            if (is_array($resultado) && $resultado['resultado'])
            {
                $arrayProdutos = explode(",", $_GET['produtos']);
                $arrayQuantidades = explode(",", $_GET['quantidades']);

                for ($i = 0; $i < count($arrayProdutos); $i++)
                {
                    $produtoVenda = new ProdutoVenda($arrayProdutos[$i], $resultado['codigo'], $arrayQuantidades[$i]);
                    $resultado_produto = $produtoVenda->cadastrar();

                    if ($resultado_produto instanceof Exception)
                        Sessao::setMensagem($resultado_produto->getMessage());
                }

                $resultado = $venda->localizar();
                $carrinho = new Carrinho(Sessao::getCodigoConta());
                $resultado_carrinho = $carrinho->limpar();
            }
            else
                Sessao::setMensagem($resultado->getMessage());
        }
    
        $produtoVenda = new ProdutoVenda(0, $resultado->getCodigo());
        $resultado_produto = $produtoVenda->listar();

        if ($resultado instanceof Venda && is_array($resultado_produto))
        {
            $this->setDados('venda', $resultado);
            $this->setDados('produtos', $resultado_produto);
        }
        else if ($resultado instanceof Exception)
            Sessao::setMensagem($resultado->getMessage());
        else
            Sessao::setMensagem($resultado_produto->getMessage());
    
        $departamento = new Departamento();
        $resultado_departamento = $departamento->listar();
        
        if (is_array($resultado_departamento))
            $this->setDados('departamentos', $resultado_departamento);
        else
            Sessao::setMensagem($resultado_departamento->getMessage());
        
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
                "venda v INNER JOIN endereco e ON e.codigo = v.cod_endereco AND v.cod_cliente = " . Sessao::getCodigoConta(),
                "v.data LIKE '%$data%' AND v.total LIKE '%$busca%'
                OR v.data LIKE '%$data%' AND v.situacao LIKE '%$busca%'
                OR v.data LIKE '%$data%' AND e.rua LIKE '%$busca%'
                OR v.data LIKE '%$data%' AND e.numero LIKE '%$busca%'
                OR v.data LIKE '%$data%' AND e.bairro LIKE '%$busca%'
                OR v.data LIKE '%$data%' AND e.cidade LIKE '%$busca%'
                OR v.data LIKE '%$data%' AND e.estado LIKE '%$busca%'
                OR v.data LIKE '%$data%' AND e.cep LIKE '%$busca%'
            ");
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
}