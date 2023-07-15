<?php

namespace App\Http\Controllers;

use App\Helpers\Help;
use App\Models\tb_pagamentos;
use Exception;
use GuzzleHttp\Client as GuzzleHttpClient;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PagamentosController extends Controller
{
   protected $header;
   protected $api;

   public function __construct()
   {
      parent::__construct();

      $this->header = [
         'accept'       => 'application/json',
         'access_token' => $this->token,
         'content-type' => 'application/json',
      ];

      $this->api = new GuzzleHttpClient();
   }


   public function index()
   {
      //View::render();
   }


   public function cartao(Request $request)
   {

      try{

         $validate = Validator::make($request->all(), [
            'nomeCard'        => 'required',
            'numeroCard'      => 'required',
            'mes'             => 'required|max:2',
            'ano'             => 'required|max:4',
            'cvv'             => 'required|max:4',
            'nomeTitularCard' => 'required',
            'emailCard'       => 'required|email',
            'cpfCard'         => 'required|',
            'celularCard'     => 'required',
            'cepCard'         => 'required',
            'numEndCard'      => 'required',
         ]);

         if($validate->fails()){
            echo json_encode(['status' => false, 'msg' => "Favor preencher todos os campos corretamente!"]);
            return;
         }

         $cliente = ClientesController::cadastrarCliente($request, $this->token);

      }catch(Exception $e){

         echo json_encode(['status' => false, 'msg' => "Erro no cadastro do cliente! \n Favor verificar os dados!"]);
         return;

      }
      
      try{

         $response = $this->api->request('POST', 'https://sandbox.asaas.com/api/v3/payments/', [
            'body' => '{
               "billingType":"CREDIT_CARD",
               "creditCard":{
                  "holderName":"'.$request->nomeCard.'",
                  "number":"'.preg_replace("/\D/", "", $request->numeroCard).'",
                  "expiryMonth":"'.preg_replace("/\D/", "", $request->mes).'",
                  "expiryYear":"'.preg_replace("/\D/", "", $request->ano).'",
                  "ccv":"'.preg_replace("/\D/", "", $request->cvv).'"
               },
               "creditCardHolderInfo":{
                  "name":"'.$request->nomeTitularCard.'",
                  "email":"'.$request->emailCard.'",
                  "cpfCnpj":"'.preg_replace("/\D/", "", $request->cpfCard).'",
                  "postalCode":"'.preg_replace("/\D/", "", $request->cepCard).'",
                  "addressNumber":"'.$request->numEndCard.'",
                  "phone":"'.preg_replace("/\D/", "", $request->celularCard).'"
               },
               "customer":"'.$cliente.'",
               "value":89.90,
               "dueDate":"'.date('Y-m-d').'",
               "description":"Camiseta PHP",
               "externalReference":"000134"
            }',
            'headers' => $this->header
         ]);

         $cartao =  json_decode($response->getBody());

         $this->cadastrarPagamento($cliente, $cartao);

         echo json_encode([
            'status' => true, 
            'pag'    => 'cartao',
            'id'     => Help::syscrypt('E89',$cartao->id)
         ]);

      }catch(Exception $e){

         if($e->getCode() == '400'){
            echo json_encode(['status' => false, 'msg' => "Cartão de Crédito não autorizado!"]);
         }else{
            echo json_encode(['status' => false, 'msg' => "Algum erro interno! \n Entre em contato com o suporte!"]);
         }

      }
   }


   public function boleto(Request $request)
   {
      
      try{

         $validate = Validator::make($request->all(), [
            'nome' => 'required',
            'cpf'  => 'required',
         ]);
   
         if($validate->fails()){
            echo json_encode(['status' => false, 'msg' => "Favor preencher todos os campos corretamente!"]);
            return;
         }

         $cliente = ClientesController::cadastrarCliente($request, $this->token);

      }catch(Exception $e){

         echo json_encode(['status' => false, 'msg' => "Erro no cadastro do cliente! \n Favor verificar os dados!"]);
         return;

      }

      try{
         $response = $this->api->request('POST', 'https://sandbox.asaas.com/api/v3/payments', [
            'body' => '{
               "billingType":"BOLETO",
               "customer":"'.$cliente.'",
               "value":89.90,
               "dueDate":"'.date('Y-m-d').'",
               "description":"Camiseta PHP",
               "externalReference":"000134"
            }',
            'headers' => $this->header
         ]);

         $boleto =  json_decode($response->getBody());

         $this->cadastrarPagamento($cliente, $boleto);

         echo json_encode([
            'status' => true, 
            'pag'    => 'boleto',
            'id'     => Help::syscrypt('E89', $boleto->id)
         ]);

      }catch(Exception $e){

         echo json_encode(['status' => false, 'msg' => "Algum erro interno! \n Entre em contato com o suporte!"]);

      }
       
   }


   public function pix(Request $request)
   {

      try{

         $validate = Validator::make($request->all(), [
            'nome' => 'required',
            'cpf'  => 'required',
         ]);
   
         if($validate->fails()){

            echo json_encode(['status' => false, 'msg' => "Favor preencher todos os campos corretamente!"]);
            return;
         
         }

         $cliente = ClientesController::cadastrarCliente($request, $this->token);

      }catch(Exception $e){

         echo json_encode(['status' => false, 'msg' => "Erro no cadastro do cliente! \n Favor verificar os dados!"]);
         return;
     
      }   

      try{

         $response = $this->api->request('POST', 'https://sandbox.asaas.com/api/v3/payments', [
            'body' => '{
               "billingType":"PIX",
               "customer":"'.$cliente.'",
               "value":89.90,
               "dueDate":"'.date('Y-m-d').'",
               "description":"Camiseta PHP",
               "externalReference":"000134"
            }',
            'headers' => $this->header
         ]);

         $pix =  json_decode($response->getBody());

         $this->cadastrarPagamento($cliente, $pix);

         echo json_encode([
            'status' => true, 
            'pag'    => 'pix',
            'id'     => Help::syscrypt('E89', $pix->id)
         ]);

      }catch(Exception $e){

         echo json_encode(['status' => false, 'msg' => "Algum erro interno! \n Entre em contato com o suporte!"]);

      }

   }


   public function cadastrarPagamento($id_cliente, $dados)
   {
      try{

         switch ($dados->status) {
            case 'PENDING':
               $dados->status = 'Pendente';
               break;
            case 'CONFIRMED':
               $dados->status = 'Aprovado';
               break;
         }

         tb_pagamentos::create([
            'id_cliente'       => $id_cliente,
            'id_pagamento'     => $dados->id,
            'status_pagamento' => $dados->status
         ]);

      }catch(Exception $e){
         
         return $e->getMessage();
         
      }
      
   }

}