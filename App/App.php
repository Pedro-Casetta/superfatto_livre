<?php

namespace App;

use App\Controller\HomeController;


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
        if (isset($_GET['caminho']))
        {
            $caminho = $_GET['caminho'];
            $arrayCaminho = explode('/', $caminho);

            $this->setController($arrayCaminho[0]);
            $this->setAcao($arrayCaminho[1]);
            if (isset($arrayCaminho[2]) && !empty($arrayCaminho[2]))
            {
                unset($arrayCaminho[0]);
                unset($arrayCaminho[1]);
                $this->setParametros(array_values($arrayCaminho));
            }
        }
    }

    public function executarController()
    {
        if ($this->getController()){
            $nomeController = ucwords($this->getController()) . 'Controller';
            $classeController = "App\\Controller\\" . $nomeController;
            $objetoController = new $classeController();
            $acao = $this->getAcao();
            $parametros = $this->getParametros();
            if(!$this->getParametros())
                $objetoController->$acao();
            else
                $objetoController->$acao($parametros);
        } else {
            $homeController = new HomeController();
            $homeController->index();
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