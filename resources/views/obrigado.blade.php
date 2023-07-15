<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PerfectPlay | Desafio PHP Laravel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/obrigado.css') }}">
</head>

<body>
    <div class="container-fluid" style="background: linear-gradient(180deg,#005B71 0%,#007C7D 100%);">
        <div class="row">
            <div class="col text-center">
                <img loading="lazy" src="https://perfectpay.com.br/images/logo-branca.png" class="mt-3 mb-3" alt="Logo PerfectPay">
            </div>
        </div>
    </div>
   
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2 text-center mt-5 box">
                <div class="mt-3">
                    <i class="fa fa-check-circle fa-2x mr-2" style="color: #666666" aria-hidden="true"></i>
                    <span class="tituloObrigado">Obrigado!</span>
                </div>

                @if($pedido->billingType == 'CREDIT_CARD')
                <div class="pl-5 pr-5 pt-4" style="font-weight: bold; color:#777">
                    Pronto, seu pagamento foi aprovado!
                    <br>
                    Número do pedido: {{ $pedido->externalReference }}
                </div>
                
                <div class="mt-5 mb-5" style="width: 70%; border-radius: 5px; border: 1px solid #bababa; background: #fff; margin:0 auto; text-align: left; padding: 20px;">
                    <div class="mb-3" style="display: flex; width: 90%; margin-left: 7%">
                        <span style="font-weight: bold; margin-right: 10px; text-align: right; width: 165px"> Forma de Pagamento: </span>
                        <span> Cartão de Crédito </span>
                    </div> 

                    <div class="mb-3" style="display: flex; width: 90%; margin-left: 7%">
                        <span style="font-weight: bold; margin-right: 10px; text-align: right; width: 165px">Número do Cartão:</span>
                        <span> {{ $pedido->creditCard->creditCardBrand }} - {{ $pedido->creditCard->creditCardNumber }} </span>
                    </div>

                    <div class="mb-3" style="display: flex; width: 90%; margin-left: 7%">
                        <span style="font-weight: bold; margin-right: 10px; text-align: right; width: 165px">Valor Pago:</span> 
                        <span> R$ {{ number_format($pedido->value,2,',','.') }} </span>
                    </div>

                    <div style="display: flex; width: 90%; margin-left: 7%">
                        <span style="font-weight: bold; margin-right: 10px; text-align: right; width: 165px">Data do Pagamento:</span> 
                        <span> {{ date('d/m/Y', strtotime($pedido->confirmedDate)) }} </span>
                    </div>
                </div>
                @endif


                @if($pedido->billingType == 'BOLETO')
                <div class="pl-5 pr-5 pt-4" style="font-weight: bold; color:#777">
                    O seu pedido será atualizado assim que o pagamento do boleto for confirmado pelo nosso banco, o que ocorre no periodo de 3 dias úteis ao pagamento.
                </div>
                
                <div class="mt-5 boxBoleto">
                    <a href="{{ $pedido->bankSlipUrl }}" target="_blank" class="btn-boleto">
                        <i class="fa fa-barcode fa-1x mr-2" aria-hidden="true"></i>
                        <span style="font-size: 13px;">Clique aqui para visualizar o boleto bancário</span>
                    </a>
                </div>
                @endif

                @if($pedido->billingType == 'PIX')
                <div class="pl-5 pr-5 pt-4" style="font-weight: bold; color:#777">
                    O seu pedido será atualizado imediatamente após o pagamento.
                </div>

                <div class="mt-4 boxPix">
                    <img src="data:image/png;base64,{{ $img }}" width="150" height="150" style="border: 1px solid #bababa;">
                </div>

                <div class="boxCopia mt-3">
                    <input type="text" readonly id="texto" style="width: 70%; height: 40px; background: #CCC; padding: 0 20px; border-radius: 5px; border: 1px solid #bababa" value="{{ $cod }}">
                    <br>
                    <button id="execCopy" class="btn btn-info mt-2 mb-4" style="font-size: 12px;"> 
                        <i class="fa fa-copy" aria-hidden="true"></i> Copiar 
                    </button>
                </div>
                @endif

            </div>
        </div>
    </div>


    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/0.9.0/jquery.mask.min.js"></script>
    <script src="{{ asset('js/steps.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.0/jquery.easing.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
    <script>
        document.getElementById('execCopy').addEventListener('click', execCopy);
        
        function execCopy() {
            document.querySelector("#texto").select();
            document.execCommand("copy");
        }
    </script>
    
    
</body>

</html>