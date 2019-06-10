var regex = function (val) {
    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
},
options = {
    onKeyPress: function (val, e, field, options) {
        field.mask(regex.apply({}, arguments), options);
    }
};
$(document).ready(function() {

    $('.date').mask('00/00/0000');
    $('.time').mask('00:00:00');
    $('.date_time').mask('00/00/0000 00:00:00');
    $('.cep').mask('00000-000');
    $('.phone').mask('0000-0000');
    $('.phone_with_ddd').mask('(00) 0000-0000');
    $('.phone_us').mask('(000) 000-0000');
    $('.mixed').mask('AAA 000-S0S');
    $('.cpf').mask('000.000.000-00', {reverse: true});
    $('.money').mask('000.000.000.000.000,00', {reverse: true});


    $(".datepicker").datepicker({
        inline: true,
        minDate: "01/01/2016",
        dateFormat: "dd/mm/yy"
    });
    

    $(".datepickerfim").datepicker({
        inline: true,
        dateFormat: "dd/mm/yy"
    });
    

    $('.telefone').mask(regex, options);
    $("select[name=tipo]").on("change", function() {

        if ($(this).val() == "T") {
            $('input[name=campo_filtro]').val('');
            $('input[name=campo_filtro]').mask(regex, options);
        } else {
            $('input[name=campo_filtro]').unmask();
        }
    });


    $(".select2").select2({width: "100%"});

     $('[data-toggle="popover"]').popover();
     setTimeout(function(){
        jQuery('#alertas').hide('hide');
        jQuery('#alertas').html('');
    }, 3000);

    $(".btn-ver-detalhe-pedido").on("click", function(){
        var posicao = $(this).data("posicao");
        if( $(".detalhes_pedido_"+posicao).is(":visible")){
          $(".detalhes_pedido_"+posicao).hide();
        }else{
          $(".detalhes_pedido_"+posicao).show();
        }
    });

    
    $(document).on("click",".btn-add-pedido", function(){
        var id_produto       = $(this).data("id");
        var preco             = $(this).data("preco");
        var nome             = $(this).data("nome");
        var qtde_item        = $("input[name=qtde_item]").val();
        var obs_pedido_item  = $("textarea[name=obs_pedido_item]").val();
       
        if (id_produto != "" && qtde_item != "") {
       
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: URL_BASE+"home/add_carrinho",
                data: {id_produto:id_produto, preco:preco, nome:nome, qtde_item:qtde_item, obs_item:obs_pedido_item},
                success: function(data)
                {
                    if (data.erro == true) {
                        alert("Erro ao adicionar");
                        return false;
                    } else {
                        alert("Adicionado no carrinho");
                        $('#modal_add_carrinho').modal('hide');
                        location.reload();
                        
                    }
                    
                }
            });
        } else {
            alert("Erro ao adicionar");
            return false;
        } 
    });

     
    $(document).on("click",".btn-fecha-pedido", function(){
        var forma_envio         = $("select[name=forma_envio]").val();
        var id_forma_pagamento  = $("select[name=id_forma_pagamento]").val();
        var total_item  = $("select[name=total_item]").val();

        if (total_item == '' || total_item == '0') {

            alert('Adicione ao menos um produto no carrinho');
            return false;

        } else if (forma_envio == '') {

            alert('Selecione a Forma de entrega');
            $("select[name=forma_envio]").focus();
            return false;

        } else if (id_forma_pagamento == '') {

            alert('Selecione a Forma de pagamento');
            $("select[name=id_forma_pagamento]").focus();
            return false;

        } else {
            $("form[name=form_finaliza]").submit();
        } 
    });

     
    $(document).on("click",".btn-remove-item-carrinho", function(){
        var posicao       = $(this).data("posicao");
        if (posicao != '' || posicao == '0') {
       
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: URL_BASE+"home/delete_carrinho",
                data: {posicao:posicao},
                success: function(data)
                {
                    if (data.erro == true) {
                        alert("Erro ao remover");
                        return false;
                    } else {
                        alert("Removido item do carrinho");
                        location.reload();
                        
                    }
                    
                }
            });
        } else {
            alert("Erro ao remover");
            return false;
        } 
    });

    
    var inputsCEP = $('.endereco,.bairro,.uf,.cidade');
    var validacep = /^[0-9]{8}$/;
    $('.cep').on('blur', function(e) {

      var cep = $('.cep').val().replace(/\D/g, '');

      if (cep !== "" && validacep.test(cep)) {

        inputsCEP.val('...');
        get('https://viacep.com.br/ws/' + cep + '/json/');

      } else {
        limpa_formulario_cep(cep == "" ? undefined : "Formato de CEP inválido.");
      }
    });

     

});

function preview_images() {
    var total_file=document.getElementById("upload_file").files.length;
    for(var i=0;i<total_file;i++) {
          $('#image_preview').append("<div class='col-xs-4 col-sm-4 col-md-3'><img class='img-responsive' style='margin-bottom:20px;height:100px' src='"+URL.createObjectURL(event.target.files[i])+"'></div>");
    }
}
