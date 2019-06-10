
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
   /* $("#imprimipagina").ready(function(){
        $("#imprimipagina").printElement();
    });    
    $(".btn-print-nova").click(function(){
        $("#imprimipagina").printElement();
    });*/
    $(".select2").select2({width: "100%"});
    $('#tabelas').DataTable({
        "language": {
                    "lengthMenu": "Exibindo _MENU_ registro por página",
                    "zeroRecords": "Nenhum registro encontrado.",
                    "info": "Exibindo página _PAGE_ de _PAGES_",
                    "infoEmpty": "",
                    "infoFiltered": "(filtered from _MAX_ total records)",
                    "search" : "Pesquisar",
                }
    });
     $('[data-toggle="popover"]').popover();
     setTimeout(function(){
        jQuery('#alertas').hide('hide');
        jQuery('#alertas').html('');
    }, 3000);



});

function preview_images() 
{
 var total_file=document.getElementById("upload_file").files.length;
 for(var i=0;i<total_file;i++)
 {
      $('#image_preview').append("<div class='col-xs-4 col-sm-4 col-md-3'><img class='img-responsive' style='margin-bottom:20px;height:100px' src='"+URL.createObjectURL(event.target.files[i])+"'></div>");
 }
}
