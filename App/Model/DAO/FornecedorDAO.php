<?php

namespace App\Model\DAO;

use PDO;
use App\Model\Entidades\Fornecedor;

class FornecedorDAO extends BaseDAO
{
    public function listar()
    {
        $resultado = $this->select("SELECT * FROM fornecedor");
        $fornecedores = $resultado->fetchAll();

        $listaFornecedores = [];
        
        if($fornecedores) {
            foreach($fornecedores as $umFornecedor) {
                
                $fornecedor = new Fornecedor();
                $fornecedor->setCodigo($umFornecedor['codigo']);
                $fornecedor->setCnpj($umFornecedor['CNPJ']);
                $fornecedor->setNome($umFornecedor['nome']);
                $fornecedor->setCategoria($umFornecedor['categoria']);
                $listaFornecedores[] = $fornecedor;
                
            }
        }

        return $listaFornecedores;
    }
}