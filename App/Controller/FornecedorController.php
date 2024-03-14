<?php

namespace App\Controller;

use App\Lib\Paginacao;
use App\Lib\Sessao;
use App\Lib\Validador;
use App\Model\DAO\FornecedorDAO;
use App\Model\Entidades\Fornecedor;
use Exception;

class FornecedorController extends BaseController
{

    public function index()
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $paginaSelecionada = (isset($_GET['paginaSelecionada'])) ? $_GET['paginaSelecionada'] : 1;
            $busca = (isset($_GET['busca'])) ? $_GET['busca'] : "";
            $departamento = (isset($_GET['departamento'])) ? $_GET['departamento'] : "";
            $indice = Paginacao::calcularIndice($paginaSelecionada);
            
            $fornecedor = new Fornecedor();
            $resultado = $fornecedor->listarPaginacao($indice, Paginacao::$limitePorPagina, $busca, $departamento);

            $fornecedorDAO = new FornecedorDAO();
            $resultado_departamento = $fornecedorDAO->listarDepartamentos();

            $totalRegistros = $fornecedor->contarTotalRegistros(
                "fornecedor f INNER JOIN departamento d ON d.codigo = f.cod_departamento",
                "f.cnpj LIKE '%$busca%' AND d.nome LIKE '%$departamento%'
                OR f.nome LIKE '%$busca%' AND d.nome LIKE '%$departamento%'");
            $totalPaginas = ceil($totalRegistros / Paginacao::$limitePorPagina);
            $paginacao = Paginacao::criarPaginacao('/fornecedor', $paginaSelecionada, $totalPaginas, $busca, $departamento);

            if(is_array($resultado) && is_array($resultado_departamento))
            {
                $this->setDados('fornecedores', $resultado);
                $this->setDados('paginacao', $paginacao);
                $this->setDados('departamentos', $resultado_departamento);
            }
            else
                Sessao::setMensagem($resultado->getMessage());
            
            $this->renderizar('fornecedor/index');

            Sessao::setMensagem(null);
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function encaminharCadastro()
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $fornecedorDAO = new FornecedorDAO();
            $resultado = $fornecedorDAO->listarDepartamentos();
            
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
            
            $this->renderizar('fornecedor/cadastro');
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
            $cnpj_validado = Validador::validarCnpj($_POST['cnpj']);
            $nome_validado = Validador::validarNomeFornecedor($_POST['nome']);

            $validacao_formulario = [
                'cnpj_validado' => $cnpj_validado,
                'nome_validado' => $nome_validado
            ];

            if (in_array(false, $validacao_formulario))
            {
                Sessao::setFormulario($_POST);
                Sessao::setValidacaoFormulario($validacao_formulario);
                $this->redirecionar('/fornecedor/encaminharCadastro');
                exit;
            }
            
            $fornecedor = new Fornecedor(
                0 ,
                $_POST['cnpj'],
                $_POST['nome'],
                $_POST['departamento']
            );

            $resultado = $fornecedor->cadastrar();

            if (is_bool($resultado) && $resultado)
                Sessao::setMensagem("Dados inseridos com sucesso!");
            else
                Sessao::setMensagem($resultado->getMessage());

            $this->redirecionar('/fornecedor');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function encaminharEdicao($parametros)
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $codigo = $parametros[0];
            $fornecedor = new Fornecedor($codigo);
            $resultado_fornecedor = $fornecedor->localizar();

            $fornecedorDAO = new FornecedorDAO();
            $resultado_departamento = $fornecedorDAO->listarDepartamentos();

            if ($resultado_fornecedor instanceof Fornecedor && is_array($resultado_departamento))
            {
                $this->setDados('departamentos', $resultado_departamento);
                $this->setDados('fornecedor', $resultado_fornecedor);
                Sessao::setMensagem(null);
            }
            else if ($resultado_fornecedor instanceof Exception)
                Sessao::setMensagem($resultado_fornecedor->getMessage());
            else
                Sessao::setMensagem($resultado_departamento->getMessage());

            if (Sessao::getFormulario() && Sessao::getValidacaoFormulario())
            {
                $this->setDados('formulario', Sessao::getFormulario());
                $this->setDados('validacao', Sessao::getValidacaoFormulario());
            }
            
            $this->renderizar('fornecedor/edicao');
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
            $cnpj_validado = Validador::validarCnpj($_POST['cnpj']);
            $nome_validado = Validador::validarNomeFornecedor($_POST['nome']);

            $validacao_formulario = [
                'cnpj_validado' => $cnpj_validado,
                'nome_validado' => $nome_validado
            ];

            if (in_array(false, $validacao_formulario))
            {
                Sessao::setFormulario($_POST);
                Sessao::setValidacaoFormulario($validacao_formulario);
                $this->redirecionar('/fornecedor/encaminharEdicao/' . $_POST['codigo']);
                exit;
            }
            
            $fornecedor = new Fornecedor(
                $_POST['codigo'],
                $_POST['cnpj'],
                $_POST['nome'],
                $_POST['departamento']
            );

            $resultado = $fornecedor->atualizar();

            if (is_bool($resultado) && $resultado)
                Sessao::setMensagem("Dados atualizados com sucesso!");
            else
                Sessao::setMensagem($resultado->getMessage());

            $this->redirecionar('/fornecedor');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function encaminharExclusao($parametros)
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $codigo = $parametros[0];

            $fornecedor = new Fornecedor($codigo);
            $resultado = $fornecedor->localizar();

            if ($resultado instanceof Fornecedor)
            {
                $this->setDados('fornecedor', $resultado);
                Sessao::setMensagem(null);
            }
            else
                Sessao::setMensagem($resultado->getMessage());

            $this->renderizar('fornecedor/exclusao');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function excluir()
    {
        if (Sessao::verificarAcesso('administrador'))
        {
            $codigo = $_POST['codigo'];
            $fornecedor = new Fornecedor($codigo);
            $resultado = $fornecedor->excluir();

            if (is_bool($resultado) && $resultado)
                Sessao::setMensagem("Dados excluídos com sucesso!");
            else
                Sessao::setMensagem($resultado->getMessage());

            $this->redirecionar('/fornecedor');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }
}