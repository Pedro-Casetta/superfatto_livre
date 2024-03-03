<?php

namespace App\Model\Entidades;

use PayPalHttp\Environment;
use PayPalHttp\HttpClient;
use PayPalHttp\HttpRequest;
use App\Model\Entidades\Endereco;

class Pagamento implements Environment
{
    private string $base_url;

    public function __construct(string $url = "https://api-m.sandbox.paypal.com/")
    {
        $this->base_url = $url;
    }
    
    public function baseUrl()
    {
        return $this->base_url;
    }
    
    public function getAcessToken()
    {
        $request = new HttpRequest("v1/oauth2/token", "POST");
        $request->headers['Content-Type'] = "application/x-www-form-urlencoded";
        $clientId = "AbMCJarIG5B0WJMq5zite6Iij40xs6o9G4crIpY_mJs6Y8nht0DB6DkN9muIEIh3QjSG3962QiRsqREU";
        $secret = "EGNFoiENojpgZJR9z0a2yLcluROZp96eFe98SjbgRd6NR6G8xT3Y2m1znBpW-IZEwXUvKXne2lrTsT_H";
        $request->headers['Authorization'] = "Basic " . base64_encode($clientId . ":" . $secret);
        $request->body = [];
        $request->body['grant_type'] = "client_credentials";

        $client = new HttpClient($this);

        $response = $client->execute($request);

        return $response;
    }

    public function createOrder($token, $totalVenda, Endereco $endereco, $idVenda)
    {        
        $totalVenda = strval($totalVenda);
        
        $request = new HttpRequest("v2/checkout/orders", "POST");
        $request->headers['Content-Type'] = "application/json";
        $request->headers['Authorization'] = "Bearer " . $token;
        $request->body = [];
        $request->body['intent'] = "CAPTURE";
        $request->body['purchase_units'] = [];
        $request->body['purchase_units'][] = [
            'amount' => ['currency_code' => "BRL", 'value' => $totalVenda],
            'shipping' => [
                'type' => "SHIPPING",
                'address' => [
                    'address_line_1' => $endereco->getRua() . ", " . $endereco->getNumero(),
                    'address_line_2' => $endereco->getBairro(),
                    'admin_area_2' => $endereco->getCidade(),
                    'admin_area_1' => $endereco->getEstado(),
                    'postal_code' => "19025812",
                    'country_code' => "BR"
                ]]];
        $request->body['payment_source'] = ['paypal' => ['experience_context' => []]];
        $request->body['payment_source']['paypal']['experience_context']['return_url'] = "http://" . APP_HOST . "/venda/autorizarPagamento";
        $request->body['payment_source']['paypal']['experience_context']['cancel_url'] = "http://" . APP_HOST . "/venda/excluir/" . $idVenda;
        $request->body['payment_source']['paypal']['experience_context']['brand_name'] = "SUPERFATTO LIVRE";
        $request->body['payment_source']['paypal']['experience_context']['locale'] = "pt-BR";

        $client = new HttpClient($this);
        
        $response = $client->execute($request);

        return $response;
    }

    public function authorizePayment($token, $idPagamento)
    {
        $request = new HttpRequest("v2/checkout/orders/" . $idPagamento . "/capture", "POST");
        $request->headers['Content-Type'] = "application/json";
        $request->headers['Authorization'] = "Bearer " . $token;
        $request->body = "";

        $client = new HttpClient($this);
        
        $response = $client->execute($request);

        return $response;
    }

    public function getOrder($idPagamento, $token)
    {
        $request = new HttpRequest("v2/checkout/orders/" . $idPagamento, "GET");
        $request->headers['Content-Type'] = "application/json";
        $request->headers['Authorization'] = "Bearer " . $token;
        $request->body = [];

        $client = new HttpClient($this);
        
        $response = $client->execute($request);

        return $response;
    }
}