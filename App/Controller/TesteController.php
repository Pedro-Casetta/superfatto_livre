<?php

namespace App\Controller;

class TesteController extends BaseController
{

    public function index()
    {
        $numero = floatval('2500.50');
        echo $numero;
    }
}