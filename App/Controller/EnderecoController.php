<?php

namespace App\Controller;

use App\Lib\Paginacao;
use App\Lib\Sessao;
use App\Lib\Validador;
use App\Model\Entidades\Endereco;
use App\Model\Entidades\Departamento;
use Exception;

class EnderecoController extends BaseController
{

    public function index()
    {
        if (Sessao::verificarAcesso('cliente'))
        {
            $departamento = new Departamento();
            $resultado_departamento = $departamento->listar();
            
            $paginaSelecionada = (isset($_GET['paginaSelecionada'])) ? $_GET['paginaSelecionada'] : 1;
            $busca = (isset($_GET['busca'])) ? $_GET['busca'] : "";
            $indice = Paginacao::calcularIndice($paginaSelecionada);
            
            $endereco = new Endereco(0,"",0,"","","","", Sessao::getCodigoConta());
            $resultado = $endereco->listarPaginacao($indice, Paginacao::$limitePorPagina, $busca);

            $totalRegistros = $endereco->contarTotalRegistros("endereco",
            "cod_cliente = " . Sessao::getCodigoConta() . "
            AND rua LIKE '%$busca%' OR numero LIKE '%$busca%'
            OR bairro LIKE '%$busca%' OR cidade LIKE '%$busca%'
            OR estado LIKE '%$busca%' OR cep LIKE '%$busca%'");
            $totalPaginas = ceil($totalRegistros / Paginacao::$limitePorPagina);
            $paginacao = Paginacao::criarPaginacao('/endereco', $paginaSelecionada, $totalPaginas, $busca);

            if(is_array($resultado) && is_array($resultado_departamento))
            {
                $this->setDados('enderecos', $resultado);
                $this->setDados('paginacao', $paginacao);
                $this->setDados('departamentos', $resultado_departamento);
            }
            else
                Sessao::setMensagem($resultado->getMessage());
            
            $this->renderizar('endereco/index');

            Sessao::setMensagem(null);
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function encaminharCadastro()
    {
        if (Sessao::verificarAcesso('cliente'))
        {
            $departamento = new Departamento();
            $resultado_departamento = $departamento->listar();
            
            if (Sessao::getFormulario() && Sessao::getValidacaoFormulario() && is_array($resultado_departamento))
            {
                $this->setDados('formulario', Sessao::getFormulario());
                $this->setDados('validacao', Sessao::getValidacaoFormulario());
                $this->setDados('departamentos', $resultado_departamento);                
            }
            else
                Sessao::setMensagem($resultado_departamento->getMessage());
            
            $this->renderizar('endereco/cadastro');
            Sessao::setMensagem(null);
            Sessao::setFormulario(null);
            Sessao::setValidacaoFormulario(null);
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function cadastrar()
    {
        if (Sessao::verificarAcesso('cliente'))
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
                $this->redirecionar('/endereco/encaminharCadastro');
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
                $_POST['cliente']
            );

            $resultado = $endereco->cadastrar();

            if (is_bool($resultado['resultado']) && $resultado['resultado'])
                Sessao::setMensagem("Dados inseridos com sucesso!");
            else
                Sessao::setMensagem($resultado['resultado']->getMessage());

            $this->redirecionar('/endereco');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function encaminharEdicao($parametros)
    {
        if (Sessao::verificarAcesso('cliente'))
        {
            $codigo = $parametros[0];
            $endereco = new Endereco($codigo);
            $resultado = $endereco->localizar();

            $departamento = new Departamento();
            $resultado_departamento = $departamento->listar();

            if ($resultado instanceof Endereco && is_array($resultado_departamento))
            {
                $this->setDados('endereco', $resultado);
                $this->setDados('departamentos', $resultado_departamento);
                Sessao::setMensagem(null);
            }
            else if ($resultado instanceof Exception)
                Sessao::setMensagem($resultado->getMessage());
            else
                Sessao::setMensagem($resultado_departamento->getMessage());

            if (Sessao::getFormulario() && Sessao::getValidacaoFormulario())
            {
                $this->setDados('formulario', Sessao::getFormulario());
                $this->setDados('validacao', Sessao::getValidacaoFormulario());
            }
            
            $this->renderizar('endereco/edicao');
            Sessao::setMensagem(null);
            Sessao::setFormulario(null);
            Sessao::setValidacaoFormulario(null);
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function atualizar()
    {
        if (Sessao::verificarAcesso('cliente'))
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
                $this->redirecionar('/endereco/encaminharEdicao/' . $_POST['codigo']);
                exit;
            }
            
            $endereco = new Endereco(
                $_POST['codigo'],
                $_POST['rua'],
                $_POST['numero'],
                $_POST['bairro'],
                $_POST['cidade'],
                $_POST['estado'],
                $_POST['cep'],
                $_POST['cliente']
            );

            $resultado = $endereco->atualizar();

            if (is_bool($resultado) && $resultado)
                Sessao::setMensagem("Dados atualizados com sucesso!");
            else
                Sessao::setMensagem($resultado->getMessage());

            $this->redirecionar('/endereco');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function encaminharExclusao($parametros)
    {
        if (Sessao::verificarAcesso('cliente'))
        {
            $codigo = $parametros[0];
            $endereco = new Endereco($codigo);
            $resultado = $endereco->localizar();

            $departamento = new Departamento();
            $resultado_departamento = $departamento->listar();

            if ($resultado instanceof Endereco && is_array($resultado_departamento))
            {
                $this->setDados('endereco', $resultado);
                $this->setDados('departamentos', $resultado_departamento);
                Sessao::setMensagem(null);
            }
            else if ($resultado instanceof Exception)
                Sessao::setMensagem($resultado->getMessage());
            else
                Sessao::setMensagem($resultado_departamento->getMessage());

            $this->renderizar('endereco/exclusao');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function excluir()
    {
        if (Sessao::verificarAcesso('cliente'))
        {
            $codigo = $_POST['codigo'];
            $endereco = new Endereco($codigo);
            $resultado = $endereco->excluir();

            if (is_bool($resultado) && $resultado)
                Sessao::setMensagem("Dados excluídos com sucesso!");
            else
                Sessao::setMensagem($resultado->getMessage());

            $this->redirecionar('/endereco');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }
}