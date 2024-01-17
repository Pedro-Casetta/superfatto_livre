<?php

namespace App\Controller;

use App\Lib\Sessao;
use App\Lib\Upload;
use App\Model\DAO\ProdutoDAO;
use App\Model\Entidades\Produto;
use Exception;

class ProdutoController extends BaseController
{

    public function index()
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $produto = new Produto();
            $resultado = $produto->listar();

            if(is_array($resultado))
                $this->setDados('produtos', $resultado);
            else
                Sessao::setMensagem($resultado->getMessage());
            
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
            $produtoDAO = new ProdutoDAO();
            $resultado = $produtoDAO->listarDepartamentos();
            
            if (is_array($resultado))
            {
                $this->setDados('departamentos', $resultado);
                Sessao::setMensagem(null);
            }
            else
                Sessao::setMensagem($resultado->getMessage());
        
            $this->renderizar('produto/cadastro');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function cadastrar()
    {
        if (Sessao::verificarAcesso('administrador'))
        {
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

            $produtoDAO = new ProdutoDAO();
            $resultado_departamento = $produtoDAO->listarDepartamentos();

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

            $this->renderizar('produto/edicao');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function atualizar()
    {
        if (Sessao::verificarAcesso('administrador'))
        {
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
}