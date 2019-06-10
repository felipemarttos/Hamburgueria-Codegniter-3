jQuery(document).ready(function(){
    //Efetua login no sistema
    jQuery('.btn-acessar-sistema').on('click', function(){
        var dados = jQuery('#form_login_sistema').serialize();
        jQuery.ajax({
            type: "POST",
            url: URL_BASE+"infra/security.php",
            data: dados,
            beforeSend : function() {
                        jQuery("#loading-block").css({    display:"block"   });
                        jQuery("#loading").css({    display:"block"   });
            },
            success: function(data)
            {
                jQuery('#msn_erro_login').html(data);
            },
            complete : function() {
                    jQuery("#loading-block").css({    display:"none"   });
                    jQuery("#loading").css({    display:"none"   });
                },
        });
        return false;
    });
    //Recupera senha do sistema
    jQuery('.btn-recuperar-senha-sistema').on('click', function(){
        var dados = jQuery('#form_recupera_senha_sistema').serialize();
        jQuery.ajax({
            type: "POST",
            url: URL_BASE+"infra/recover.php",
            data: dados,
            beforeSend : function() {
                        jQuery("#loading-block").css({    display:"block"   });
                        jQuery("#loading").css({    display:"block"   });
            },
            success: function(data) {
                jQuery('#form_rec').hide('slow');
                jQuery('#msn-recupera-senha-sistema').html(data).fadeIn(1500, function() {});
                setTimeout(function(){ 
                    jQuery('#form_rec').show('slow');
                    jQuery('#msn-recupera-senha-sistema').html('');
                 }, 4000);
            },
            complete : function() {
                    jQuery("#loading-block").css({    display:"none"   });
                    jQuery("#loading").css({    display:"none"   });
                },
        });
        return false;
    });
    jQuery('#btn_esqueceu_senha').on('click', function(){
        jQuery('#form_recupera_senha_sistema').show('slow');
        jQuery('#form_login_sistema').hide('slow');
    });
    jQuery('#btn_volta_tela_login_sistema').on('click', function(){
        jQuery('#form_login_sistema').show('slow');
        jQuery('#form_recupera_senha_sistema').hide('slow');
    });
});

