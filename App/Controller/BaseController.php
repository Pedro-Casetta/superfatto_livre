<?php


namespace App\Controller;

use App\Lib\Sessao;


abstract class BaseController
{
    protected array $dados;

    public function __construct()
    {
        $this->dados = [];
    }

    public function renderizar(string $view)
    {
        $dados = $this->getDados();
        $sessao = Sessao::class;
        
        require_once PATH . '/App/View/layout/header.php';
        require_once PATH . '/App/View/layout/menu.php';
        require_once PATH . '/App/View/' . $view . '.php';
        require_once PATH . '/App/View/layout/footer.php';

    }

    public function redirecionar($caminho)
    {
        header('Location: http://' . APP_HOST . $caminho);
    }

    public function getDados()
    {
        return $this->dados;
    }

    public function setDados($nomeChave, $valorDado)
    {
        if ($nomeChave != "" && $valorDado != "") {
            $this->dados[$nomeChave] = $valorDado;
        }
    }
}