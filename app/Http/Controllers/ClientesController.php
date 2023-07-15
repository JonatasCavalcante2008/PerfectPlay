<?php

namespace App\Http\Controllers;

use App\Models\tb_clientes;
use Exception;
use GuzzleHttp\Client as GuzzleHttpClient;

class ClientesController 
{
   public function index()
   {
      //View::render();
   }


   static function cadastrarCliente($dados, $token)
   {
      $client   = new GuzzleHttpClient();
      $verifica = tb_clientes::where('cpf','=', preg_replace('/[^\d]/i', '',$dados->cpf))->first();
      
      if(!$verifica){

         try{

            if($dados->celular){
             $celular = (preg_replace('/[^\d]/i', '',$dados->celular)) ?? NULL;
             $celular = '"mobilePhone":"'.$celular.'"';
            }else{
               $celular = null;
            }

            $response = $client->request('POST', 'https://sandbox.asaas.com/api/v3/customers', [
               'body' => '{ 
                  "name":"'.$dados->nome.'",
                  "cpfCnpj":"'.preg_replace('/[^\d]/i', '',$dados->cpf).'",
                  '.$celular.'
               }',
               'headers' => [
                  'accept'       => 'application/json',
                  'access_token' => $token,
                  'content-type' => 'application/json',
               ],
            ]);

            $cliente = json_decode($response->getBody());
   
            tb_clientes::create(
               ['nome'       => $dados->nome,
                'cpf'        => preg_replace('/[^\d]/i', '',$dados->cpf),
                'celular'    => ($dados->celular) ? preg_replace('/[^\d]/i', '',$dados->celular) : NULL,
                'id_cliente' => $cliente->id
               ]
            );
               
            $id_cliente = $cliente->id;
            
         }catch(Exception $e) {

            return ['error' => true, 'msg' => "Algum erro interno! \n Entre em contato com o suporte!"];

         }

      }else{

         $id_cliente = $verifica->id_cliente;

      }

      return $id_cliente;
   }

}