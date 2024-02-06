<?php

namespace App\Model\Entidades;

use PayPalHttp\Environment;
use PayPalHttp\HttpClient;
use PayPalHttp\HttpRequest;

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

    public function createOrder($token, $totalVenda)
    {
        $total_formatado = number_format(floatval($totalVenda), 2);
        
        $request = new HttpRequest("v2/checkout/orders", "POST");
        $request->headers['Content-Type'] = "application/json";
        $request->headers['Authorization'] = "Bearer " . $token;
        $request->body = [];
        $request->body['intent'] = "CAPTURE";
        $request->body['purchase_units'] = [];
        $request->body['purchase_units'][] = [
            'amount' => ['currency_code' => "BRL", 'value' => $total_formatado],
            'shipping' => [
                'type' => "SHIPPING",
                'address' => [
                    'address_line_1' => "Rua Maria Aparecida Cuisse Cesco, 431",
                    'address_line_2' => "casa 69",
                    'admin_area_2' => "Presidente Prudente",
                    'admin_area_1' => "SP",
                    'postal_code' => "19025812",
                    'country_code' => "BR"
                ]]];
        $request->body['payment_source'] = ['paypal' => ['experience_context' => []]];
        $request->body['payment_source']['paypal']['experience_context']['return_url'] = "http://" . APP_HOST . "/";
        $request->body['payment_source']['paypal']['experience_context']['cancel_url'] = "http://" . APP_HOST . "/";

        $client = new HttpClient($this);
        
        $response = $client->execute($request);

        return $response;
    }
}