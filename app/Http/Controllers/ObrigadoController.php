<?php

namespace App\Http\Controllers;

use App\Helpers\Help;
use GuzzleHttp\Client as GuzzleHttpClient;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ObrigadoController extends Controller
{
   protected $header;
   protected $api;

   public function __construct()
   {
      parent::__construct();

      $this->header = [
         'accept'       => 'application/json',
         'access_token' => $this->token
      ];

      $this->api = new GuzzleHttpClient();
   }


   public function index(Request $request)
   {
      $response = $this->api->request('GET', 'https://sandbox.asaas.com/api/v3/payments/'.Help::syscrypt('D98', $request->id_pagamento), [
         'headers' => $this->header,
      ]);

      $pedido = json_decode($response->getBody());
      
      if ($pedido->billingType == 'PIX') {
         $response = $this->api->request('GET', 'https://sandbox.asaas.com/api/v3/payments/'.$pedido->id.'/pixQrCode', [
            'headers' => $this->header
         ]);
         
         $pix = json_decode($response->getBody());
      }

      return view('obrigado', [
         'pedido' => $pedido,
         'img'    => ($pix->encodedImage) ?? null,
         'cod'    => ($pix->payload) ?? null
      ]);
   }

}