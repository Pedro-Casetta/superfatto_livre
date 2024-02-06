<?php

namespace App\Controller;

use App\Lib\Paginacao;
use App\Lib\Sessao;
use App\Model\Entidades\Endereco;

class EnderecoController extends BaseController
{

    public function index()
    {
        if (Sessao::verificarAcesso('cliente'))
        {
            $paginaSelecionada = (isset($_GET['paginaSelecionada'])) ? $_GET['paginaSelecionada'] : 1;
            $busca = (isset($_GET['busca'])) ? $_GET['busca'] : "";
            $indice = Paginacao::calcularIndice($paginaSelecionada);
            
            $endereco = new Endereco();
            $resultado = $endereco->listarPaginacao($indice, Paginacao::$limitePorPagina, $busca, Sessao::getCodigoConta());

            $totalRegistros = $endereco->contarTotalRegistros("endereco",
            "cod_cliente = " . Sessao::getCodigoConta() . "
            AND rua LIKE '%$busca%' OR numero LIKE '%$busca%'
            OR bairro LIKE '%$busca%' OR cidade LIKE '%$busca%'
            OR estado LIKE '%$busca%'");
            $totalPaginas = ceil($totalRegistros / Paginacao::$limitePorPagina);
            $paginacao = Paginacao::criarPaginacao('/endereco', $paginaSelecionada, $totalPaginas, $busca);

            if(is_array($resultado))
            {
                $this->setDados('enderecos', $resultado);
                $this->setDados('paginacao', $paginacao);
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
            $this->renderizar('endereco/cadastro');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function cadastrar()
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


            if ($resultado instanceof Endereco)
            {
                $this->setDados('endereco', $resultado);
                Sessao::setMensagem(null);
            }
            else
                Sessao::setMensagem($resultado->getMessage());

            $this->renderizar('endereco/edicao');
        }
        else
            $this->redirecionar('/conta/encaminharAcesso');
    }

    public function atualizar()
    {
        if (Sessao::verificarAcesso('cliente'))
        {
            $endereco = new Endereco(
                $_POST['codigo'],
                $_POST['rua'],
                $_POST['numero'],
                $_POST['bairro'],
                $_POST['cidade'],
                $_POST['estado'],
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

            if ($resultado instanceof Endereco)
            {
                $this->setDados('endereco', $resultado);
                Sessao::setMensagem(null);
            }
            else
                Sessao::setMensagem($resultado->getMessage());

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