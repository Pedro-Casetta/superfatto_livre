<?php

namespace App\Controller;

use App\Model\Entidades\Fornecedor;

class FornecedorController extends BaseController
{

    public function index()
    {
        $fornecedor = new Fornecedor();
        $fornecedores = $fornecedor->listar();

        $this->setDados('fornecedores', $fornecedores);

        $this->renderizar('fornecedor/index');
    }
}