<?php


namespace App\Controller;


class HomeController extends BaseController
{
    public function index()
    {
        $this->renderizar('home/index');
    }
}