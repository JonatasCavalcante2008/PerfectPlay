$('#cpf').mask('000.000.000-00', {reverse: true});
$('#celular').mask('(00) 00000-0000');


$(document).on('keyup', 'input', function(e) {
    if ($(this).val() != '') {
        $('#'+$(this).attr('id')).text('');
        $('#'+$(this).attr('id')).removeClass("box_error");
    }
});


$(document).on('click', 'input[name="pagamento"]', function(e) {
    if ( $("input[name='pagamento']:checked").val() ) {
        $(".mPagamento").css("border-color", "#c9c9c9");
    }
});


$(document).on('click', 'input[name="pagamento"]', function(e) {
    if( $(this).val() == 1 ){
        $('.pagCartao').show();
        $('.pagCartao').css('display','block');
        $('.pagCartao').html(pagCard);
        $('#cpfCard').mask('000.000.000-00', {reverse: true});
        $('#cepCard').mask('00.000-000', {reverse: true});
        $('#celularCard').mask('(00) 00000-0000');
    }else{
        $('.pagCartao').hide();
        $('.pagCartao').html('');
    }
});


$("#formPagamento").submit(function(e) {
    e.preventDefault();

    if(camposObrigatorios()){
        return;
    }

    $('.loader').show();

    if($('input[name="pagamento"]:checked').val() == 1){
        var pag = './cartao';
    }else if($('input[name="pagamento"]:checked').val() == 2){
        var pag = './boleto';
    }else{
        var pag = './pix';
    }

    $.ajax({
        type: "POST",
        url: pag,
        dataType: 'json',
        data: $(this).serialize(),
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function(result) {
            $('.loader').hide();

            if(result.status) {
                if(result.pag == 'cartao'){
                    var titulo = 'Pagamento realizado com sucesso!';
                }else if(result.pag == 'boleto'){
                    var titulo = 'Boleto gerado com sucesso!';
                }else{
                    var titulo = 'PIX gerado com sucesso!';
                }

                Toast.fire({
                    icon: 'success',
                    title: titulo
                }).then((data) => {
                    window.location.href = './obrigado/' + result.id
                });
            }else{
                Toast.fire({
                    icon: 'error',
                    title: result.msg
                });
            }

        },
        error: function(result) {
            jsonResponse = (result.responseJSON);

            Toast.fire({
                icon: 'error',
                title: jsonResponse.msg
            });
        }
    });
});


function camposObrigatorios(){
    error = false;

    if ($("#nome").val() == '') {
        $("#nome").addClass("box_error");
        error = true;
    }

    if ($("#cpf").val() == '' ) {
        $("#cpf").addClass("box_error");
        error = true;
    }

    
    if ( !$("input[name='pagamento']:checked").val() ) {
        $(".mPagamento").css("border-color", "red");
        error = true;
    }


    if ($("#nomeCard").val() == '' ) {
        $("#nomeCard").addClass("box_error");
        error = true;
    }

    if ($("#numeroCard").val() == '' ) {
        $("#numeroCard").addClass("box_error");
        error = true;
    }

    /*if ($("#mes").val() == '' ) {
        $("#mes").addClass("box_error");
        error = true;
    }*/

    if ($("#ano").val() == '' ) {
        $("#ano").addClass("box_error");
        error = true;
    }

    /*if ($("#cvv").val() == '' ) {
        $("#cvv").addClass("box_error");
        error = true;
    }*/

    if ($("#nomeTitularCard").val() == '' ) {
        $("#nomeTitularCard").addClass("box_error");
        error = true;
    }

    if ($("#emailCard").val() == '' ) {
        $("#emailCard").addClass("box_error");
        error = true;
    }

    if ($("#cpfCard").val() == '' ) {
        $("#cpfCard").addClass("box_error");
        error = true;
    }

    if ($("#celularCard").val() == '' ) {
        $("#celularCard").addClass("box_error");
        error = true;
    }
    
    if ($("#cepCard").val() == '' ) {
        $("#cepCard").addClass("box_error");
        error = true;
    }

    if ($("#numEndCard").val() == '' ) {
        $("#numEndCard").addClass("box_error");
        error = true;
    }

    return error;
}


var pagCard = '<div class="mb-2">'+
                '<input type="text" name="nomeCard" placeholder="Nome impresso no cartão" id="nomeCard" >'+
              '</div>'+

              '<div class="mb-2">'+
                '<input type="text" name="numeroCard" placeholder="Número do cartão" id="numeroCard" >'+
              '</div>'+

              '<div class="row">'+
                '<div class="col mb-2 pr-0">'+
                    '<input type="text" name="mes" placeholder="Mês" id="mes" class="text-center" maxlength="2" >'+
                '</div>'+
                '<div class="col mb-2 pr-0">'+
                    '<input type="text" name="ano" placeholder="Ano" id="ano" class="text-center" maxlength="4" >'+
                '</div>'+
                '<div class="col mb-2">'+
                    '<input type="text" name="cvv" placeholder="CVV" id="cvv" class="text-center" maxlength="4" >'+
                '</div>'+
              '</div>'+  

              '<div class="mb-2">'+
                '<input type="text" name="nomeTitularCard" placeholder="Nome do titular" id="nomeTitularCard" >'+
              '</div>'+

              '<div class="mb-2">'+
                '<input type="text" name="emailCard" placeholder="Email do titular" id="emailCard" >'+
              '</div>'+
              
              '<div class="row">'+
                '<div class="col mb-2 pr-0">'+
                  '<input type="text" name="cpfCard" placeholder="CPF do titular" id="cpfCard" maxlength="14" >'+
                '</div>'+
                '<div class="col mb-2">'+
                  '<input type="text" name="celularCard" placeholder="Celular titular" id="celularCard" maxlength="15" >'+
                '</div>'+
              '</div>'+

              '<div class="row">'+
                '<div class="col mb-2 pr-0">'+
                  '<input type="text" name="cepCard" placeholder="CEP do titular" id="cepCard" maxlength="7" >'+
                '</div>'+

                '<div class="col mb-2">'+
                  '<input type="text" name="numEndCard" placeholder="Num. do endereço" id="numEndCard" maxlength="6" >'+
                '</div>'+
              '</div>';