<?php

namespace App;

use App\Controller\HomeController;
use App\Lib\Erro;
use Exception;

class App
{
    private string $controller;
    private string $acao;
    private array $parametros;

    public function __construct()
    {
        define('APP_HOST'       , $_SERVER['HTTP_HOST'] . "/superfatto_livre");
        define('PATH'           , realpath('./'));
        define('DB_HOST'        , "localhost");
        define('DB_USER'        , "root");
        define('DB_PASSWORD'    , "");
        define('DB_NAME'        , "superfatto");
        define('DB_DRIVER'      , "mysql");

        $this->controller = "";
        $this->acao = "";
        $this->parametros = [];
    }

    public function identificarController()
    {
        try
        {
            if (isset($_GET['caminho']))
            {
                $caminho = $_GET['caminho'];
                $arrayCaminho = explode('/', $caminho);

                $this->setController($arrayCaminho[0]);
                if (!empty($arrayCaminho[1]))
                    $this->setAcao($arrayCaminho[1]);
                if (isset($arrayCaminho[2]) && !empty($arrayCaminho[2]))
                {
                    unset($arrayCaminho[0]);
                    unset($arrayCaminho[1]);
                    $this->setParametros(array_values($arrayCaminho));
                }
            }
        } catch (Exception $excecao) {
            throw new Exception("Erro " . $excecao->getCode() . " Erro no processamento da URL");
        }
    }

    public function executarController()
    {
        try
        {
            if ($this->getController()){
                $nomeController = ucwords($this->getController()) . 'Controller';

                if (file_exists("App/Controller/" . $nomeController . ".php"))
                {
                    $classeController = "App\\Controller\\" . $nomeController;
                    $objetoController = new $classeController();
                    $acao = $this->getAcao();
                    $parametros = $this->getParametros();
                    if (!empty($this->getController()) && empty($this->getAcao()))
                        $objetoController->index();
                    else if (!empty($this->getAcao()) && empty($this->getParametros()))
                        $objetoController->$acao();
                    else if (!empty($this->getAcao()) && !empty($this->getParametros()))
                        $objetoController->$acao($parametros);
                }
                else {
                    $erro = new Erro("Erro de acesso aos arquivos");
                    $erro->index();
                }
            } else {
                $homeController = new HomeController();
                $homeController->index();
            }
        } catch (Exception $excecao) {
            throw new Exception("Erro " . $excecao->getCode() . ". Erro na execução dos módulos do sistema");
        }
    }

    public function getController() : string
    {
        return $this->controller;
    }

    public function setController(string $valor)
    {
        $this->controller = $valor;
    }

    public function getAcao() : string
    {
        return $this->acao;
    }

    public function setAcao(string $valor)
    {
        $this->acao = $valor;
    }

    public function getParametros() : array
    {
        return $this->parametros;
    }

    public function setParametros(array $valor)
    {
        $this->parametros = $valor;
    }

    
}