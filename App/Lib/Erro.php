<?php

namespace App\Lib;

use App\Controller\BaseController;

class Erro extends BaseController
{
    public function __construct($mensagem)
    {
        $this->setDados('erro', $mensagem);
    }

    public function index()
    {
        $this->renderizar('erro/index');
    }
}