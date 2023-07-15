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
    <link rel="stylesheet" href="{{ asset('css/steps.css') }}">
    <link rel="stylesheet" href="{{ asset('css/loading.css') }}">
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
        <span class="loader"></span>

        <form id="formPagamento">
            <div class="row mt-3 mt-md-5">
                <div class="col-12 col-md-4 mb-3">
                    <div class="coluna1">
                        <div class="titulo">Informações Pessoais</div>
                        <div class="cont">
                            <div class="mb-3">
                                <input type="text" name="nome" placeholder="Nome Completo" id="nome" >
                            </div>
                            <div class="mb-3">
                                <input type="text" name="cpf" placeholder="CPF" id="cpf" >
                            </div>
                            <div class="mb-3">
                                <input type="text" name="celular" placeholder="Celular" id="celular">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4 mb-3">
                    <div class="coluna2">
                        <div class="titulo">Meios de Pagamento</div>
                        <div class="cont">
                            <div class="mPagamento mb-3">
                                <input type="radio" id="cartao" name="pagamento" value="1">
                                <label for="cartao">Cartão de Crédito</label>

                                <i class="fa fa-credit-card-alt" aria-hidden="true"></i>

                                <span class="pagCartao"></span>
                            </div>
                            
                            <div class="mPagamento mb-3">
                                <input type="radio" id="boleto" name="pagamento" value="2">
                                <label for="boleto">Boleto</label>

                                <i class="fa fa-barcode" aria-hidden="true"></i>
                            </div>
                            <div class="mPagamento mb-3">
                                <input type="radio" id="pix" name="pagamento" value="3">
                                <label for="pix">PIX</label>

                                <i class="fa fa-qrcode" aria-hidden="true"></i>
                            </div>

                            <div class="msgError"></div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4 mb-3">
                    <div class="coluna3">
                        <div class="titulo">Revisão do Pedido</div>
                        <div class="row cont">
                            <div class="col p-0" style="height: 110px; background: url({{ asset('img/camiseta.png') }}) center no-repeat; background-size: cover" >
                            </div>
                            <div class="col" style="font-size: 12px;">
                                <span style="font-size: 15px; font-weight: bold;">Camiseta PHP</span>
                                <br>
                                <span style="font-weight: bold;">SKU:</span> 000134
                                <br>
                                <span style="font-weight: bold;">Marca:</span> PHP Laravel

                                <br>
                                <br>
                                <span style="font-size: 15px; font-weight: bold;">R$ 89,90</span>
                            </div>
                            <button type="submit" class="btn action-button w-100 mt-3"> Finalizar Pedido </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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
        const Toast = Swal.mixin({
            toast: true,
            position: 'center',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
    </script>
    
    
</body>

</html>