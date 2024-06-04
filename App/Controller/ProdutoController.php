<?php

namespace App\Controller;

use App\Lib\Paginacao;
use App\Lib\Sessao;
use App\Lib\Upload;
use App\Lib\Validador;
use App\Model\Entidades\Produto;
use App\Model\Entidades\Departamento;
use Exception;

class ProdutoController extends BaseController
{

    public function index()
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $paginaSelecionada = (isset($_GET['paginaSelecionada'])) ? $_GET['paginaSelecionada'] : 1;
            $busca = (isset($_GET['busca'])) ? $_GET['busca'] : "";
            $departamento = (isset($_GET['departamento'])) ? $_GET['departamento'] : "";
            $indice = Paginacao::calcularIndice($paginaSelecionada);
            
            $produto = new Produto();
            $resultado = $produto->listarPaginacao($indice, Paginacao::$limitePorPagina, $busca, $departamento);

            $departamento_objeto = new Departamento();
            $resultado_departamento = $departamento_objeto->listar();

            $totalRegistros = $produto->contarTotalRegistros(
                "produto p, departamento d",
                "d.codigo = p.cod_departamento
            AND p.nome LIKE '%$busca%' AND d.nome LIKE '%$departamento%'");
            $totalPaginas = ceil($totalRegistros / Paginacao::$limitePorPagina);
            $paginacao = Paginacao::criarPaginacao('/produto', $paginaSelecionada, $totalPaginas, $busca, $departamento);

            if(is_array($resultado) && is_array($resultado_departamento))
            {
                $this->setDados('produtos', $resultado);
                $this->setDados('paginacao', $paginacao);
                $this->setDados('departamentos', $resultado_departamento);
            }
            else if($resultado instanceof Exception)
                Sessao::setMensagem($resultado->getMessage());
            else
                Sessao::setMensagem($resultado_departamento->getMessage());
            
            $this->renderizar('produto/index');

            Sessao::setMensagem(null);
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function encaminharCadastro()
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $departamento_objeto = new Departamento();
            $resultado = $departamento_objeto->listar();
            
            if (is_array($resultado))
            {
                $this->setDados('departamentos', $resultado);
                Sessao::setMensagem(null);
            }
            else
                Sessao::setMensagem($resultado->getMessage());
            
            if (Sessao::getFormulario() && Sessao::getValidacaoFormulario())
            {
                $this->setDados('formulario', Sessao::getFormulario());
                $this->setDados('validacao', Sessao::getValidacaoFormulario());
            }
            
            $this->renderizar('produto/cadastro');
            Sessao::setFormulario(null);
            Sessao::setValidacaoFormulario(null);
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function cadastrar()
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $nome_validado = Validador::validarNomeProduto($_POST['nome']);
            $preco_validado = Validador::validarMonetario($_POST['preco']);

            $validacao_formulario = [
                'nome_validado' => $nome_validado,
                'preco_validado' => $preco_validado
            ];



            if (in_array(false, $validacao_formulario))
            {
                Sessao::setFormulario($_POST);
                Sessao::setValidacaoFormulario($validacao_formulario);
                $this->redirecionar('/produto/encaminharCadastro');
                exit;
            }
            
            $upload = new Upload();
            $resultado_upload = $upload->subirImagem('produto');
            
            if ($resultado_upload)
            {
                $produto = new Produto(
                    0,
                    $_POST['nome'],
                    $_POST['preco'],
                    $_POST['estoque'],
                    $resultado_upload,
                    $_POST['departamento'],
                    ""
                );

                $resultado = $produto->cadastrar();

                if (is_bool($resultado) && $resultado)
                    Sessao::setMensagem("Dados inseridos com sucesso!");
                else
                    Sessao::setMensagem($resultado->getMessage());
            }
            else
                Sessao::setMensagem("Erro ao subir imagem no sistema.");

            $this->redirecionar('/produto');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function encaminharEdicao($parametros)
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $codigo = $parametros[0];
            $produto = new Produto($codigo);
            $resultado_produto = $produto->localizar();

            $departamento_objeto = new Departamento();
            $resultado_departamento = $departamento_objeto->listar();

            if ($resultado_produto instanceof Produto && is_array($resultado_departamento))
            {
                $this->setDados('departamentos', $resultado_departamento);
                $this->setDados('produto', $resultado_produto);
                Sessao::setMensagem(null);
            }
            else if ($resultado_produto instanceof Exception)
                Sessao::setMensagem($resultado_produto->getMessage());
            else
                Sessao::setMensagem($resultado_departamento->getMessage());

            if (Sessao::getFormulario() && Sessao::getValidacaoFormulario())
            {
                $this->setDados('formulario', Sessao::getFormulario());
                $this->setDados('validacao', Sessao::getValidacaoFormulario());
            }
            
            $this->renderizar('produto/edicao');
            Sessao::setFormulario(null);
            Sessao::setValidacaoFormulario(null);
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function atualizar()
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $nome_validado = Validador::validarNomeProduto($_POST['nome']);
            $preco_validado = Validador::validarMonetario($_POST['preco']);

            $validacao_formulario = [
                'nome_validado' => $nome_validado,
                'preco_validado' => $preco_validado
            ];

            if (in_array(false, $validacao_formulario))
            {
                Sessao::setFormulario($_POST);
                Sessao::setValidacaoFormulario($validacao_formulario);
                $this->redirecionar('/produto/encaminharEdicao/' . $_POST['codigo']);
                exit;
            }
            
            if ($_FILES['imagem']['error'] === UPLOAD_ERR_NO_FILE)
            {
                $produto = new Produto(
                    $_POST['codigo'],
                    $_POST['nome'],
                    $_POST['preco'],
                    $_POST['estoque'],
                    $_POST['imagem_atual'],
                    $_POST['departamento']
                );

                $resultado = $produto->atualizar();
            }
            else if ($_FILES['imagem']['error'] !== UPLOAD_ERR_NO_FILE)
            {
                $upload = new Upload();
                $upload->removerImagem('produto/' . $_POST['imagem_atual']);
                $resultado_upload = $upload->subirImagem('produto');
                
                if ($resultado_upload)
                {
                    $produto = new Produto(
                        $_POST['codigo'],
                        $_POST['nome'],
                        $_POST['preco'],
                        $_POST['estoque'],
                        $resultado_upload,
                        $_POST['departamento']
                    );

                    $resultado = $produto->atualizar();
                }
                else
                    Sessao::setMensagem("Erro ao subir imagem no sistema.");
            }

            if (is_bool($resultado) && $resultado)
                Sessao::setMensagem("Dados atualizados com sucesso!");    
            else
                Sessao::setMensagem($resultado->getMessage());

            $this->redirecionar('/produto');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function encaminharExclusao($parametros)
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $codigo = $parametros[0];

            $produto = new Produto($codigo);
            $resultado = $produto->localizar();

            if ($resultado instanceof Produto)
            {
                $this->setDados('produto', $resultado);
                Sessao::setMensagem(null);
            }
            else
                Sessao::setMensagem($resultado->getMessage());

            $this->renderizar('produto/exclusao');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function excluir()
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $codigo = $_POST['codigo'];
            $produto = new Produto($codigo);
            $resultado = $produto->excluir();

            if (is_bool($resultado) && $resultado)
            {
                $upload = new Upload();
                $resultado_upload = $upload->removerImagem('produto/' . $_POST['imagem_atual']);

                if ($resultado_upload)
                    Sessao::setMensagem("Dados excluídos com sucesso!");
                else
                    Sessao::setMensagem("Erro ao excluir imagem do sistema.");
            }
            else
                Sessao::setMensagem($resultado->getMessage());

            $this->redirecionar('/produto');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function detalhesProduto($parametros)
    {
        if (!Sessao::verificarAcesso('administrador'))
        {
            $codigo = $parametros[0];
            $produto = new Produto($codigo);
            $resultado = $produto->localizar();

            $departamento_objeto = new Departamento();
            $resultado_departamento = $departamento_objeto->listar();

            if ($resultado instanceof Produto && is_array($resultado_departamento))
            {
                $this->setDados('produto', $resultado);
                $this->setDados('departamentos', $resultado_departamento);
            }
            else if($resultado instanceof Exception)
                Sessao::setMensagem($resultado->getMessage());
            else
                Sessao::setMensagem($resultado_departamento->getMessage());

            if (Sessao::getFormulario() && Sessao::getValidacaoFormulario())
            {
                $this->setDados('formulario', Sessao::getFormulario());
                $this->setDados('validacao', Sessao::getValidacaoFormulario());
            }
            
            $this->renderizar('produto/detalhes');
            Sessao::setMensagem(null);
            Sessao::setFormulario(null);
            Sessao::setValidacaoFormulario(null);
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function diminuirQuantidade()
    {
        if (Sessao::verificarAcesso('cliente'))
        {
            $quantidade = $_POST['quantidade'];
            
            if ($quantidade > 1)
                $quantidade = $quantidade - 1;
            
            $formulario = ['quantidade' => $quantidade];
            $validacao = ['quantidade_validada' => true];
            
            Sessao::setFormulario($formulario);
            Sessao::setValidacaoFormulario($validacao);
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function aumentarQuantidade()
    {
        if (Sessao::verificarAcesso('cliente'))
        {
            $quantidade = intval($_POST['quantidade']);
            
            if ($quantidade > 1)
                $quantidade = $quantidade - 1;
            
            $formulario = ['quantidade' => $quantidade];
            $validacao = ['quantidade_validada' => true];
            
            Sessao::setFormulario($formulario);
            Sessao::setValidacaoFormulario($validacao);
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }
}