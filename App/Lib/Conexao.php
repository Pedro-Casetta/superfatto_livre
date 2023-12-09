<?php


namespace App\Lib;

use PDO;

class Conexao
{
    private static $conexao;

    public static function getConexao()
    {
        $dsn = DB_DRIVER . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ";";
        
        $conexao = new PDO($dsn , DB_USER, DB_PASSWORD);
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conexao;
    }

    
}