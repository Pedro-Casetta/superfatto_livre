<?php

namespace App\Model\DAO;

use App\Lib\Conexao;
use Exception;

abstract class BaseDAO
{
    private $conexao;

    public function __construct()
    {
        $this->conexao = Conexao::getConexao();
    }

    public function select($sql) 
    {
        return $this->conexao->query($sql);
    }

    public function insert($tabela, $colunas, $valores) 
    {
        $parametros = $colunas;
        $colunas = str_replace(":", "", $colunas);
        $pdoStatement = $this->conexao->prepare("INSERT INTO $tabela ($colunas) VALUES ($parametros)");
        $resultado = $pdoStatement->execute($valores);

        return $resultado;
    }

    public function update($tabela, $colunas, $valores, $where = null)
    {
        if($where)
        {
            $where = " WHERE " . $where;
        }

        $pdoStatement = $this->conexao->prepare("UPDATE $tabela SET $colunas $where");
        $resultado = $pdoStatement->execute($valores);
        
        return $resultado;
    }

    public function delete($tabela, $where = null)
    {
        if($where)
        {
            $where = " WHERE " . $where;
        }

        $pdoStatement = $this->conexao->prepare("DELETE FROM $tabela $where");
        $resultado = $pdoStatement->execute();
        
        return $resultado;
    }

    public function contarTotalRegistros($coluna, $where = null)
    {
        if ($where)
        {
            $where = " WHERE " . $where;
        }
        
        $pdoStatement = $this->select("SELECT * FROM $coluna $where");
        $resultado = $pdoStatement->rowCount();
        
        return $resultado;
    }

    public function getConexao()
    {
        return $this->conexao;
    }
    
}