jQuery(document).ready(function(){
    // AJAX MODAL CLIENTE CRM
    jQuery('#btn-cliente-crm').click(function(){
        var dados = jQuery('#busc-cliente-crm').serialize();
        jQuery.ajax({
            type: "POST",
            url: URL_BASE+"classes/clientes/ajax.php?tipo=cliente_crm&token="+jQuery("#token").val()+"&empresa_id="+jQuery("#empresa_id").val()+"&subempresa_id="+jQuery("#subempresa_id").val(),
            data: dados,
            success: function(data)
            {
                jQuery('#resultado-cliente-crm').html(data);
            }
        });

        return false;
    });


});
