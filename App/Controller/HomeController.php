<?php


namespace App\Controller;

use App\Lib\Sessao;

class HomeController extends BaseController
{
    public function index()
    {
        $this->renderizar('home/index');

        Sessao::setMensagem(null);
    }
}