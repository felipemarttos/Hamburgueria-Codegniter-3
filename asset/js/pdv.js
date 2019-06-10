jQuery(function() {

        var produtoQtd      = jQuery('#qtd'),
            cons            = jQuery('#consulta'),
            produtoCod      = jQuery('#cod'),
            produtoUnidade  = jQuery('#produtoUnidade'),
            produtoValor    = jQuery('#valor'),
            produtoTotal    = jQuery('#total'),
            produtoNome     = jQuery('#pdv_descricao_produto'),    
            MAX             = jQuery('#MAX'),
            cliente         = jQuery('#cliente'),
            res             = jQuery('#result'),
            empresa_id      = jQuery('#empresa_id'),
            subempresa_id   = jQuery('#subempresa_id'),
            usuario         = jQuery('#usuario'),
            ONGID           = jQuery('#ONGID'),
            VENDAID         = jQuery('#VENDAID'),
            token           = jQuery('#token');

        jQuery('#qtd').focus();

        produtoQtd.on('change keyup', function() {
            var q = parseInt(produtoQtd.val().replace(' ', ''));

            if (isNaN(q) || q <= 0) {
                cons.attr('disabled', 'disabled');
                produtoCod.val('');
                produtoNome.text('Escolha um Produto');
                produtoValor.val('');
                produtoUnidade.val('');
                produtoTotal.val('');
            } else {
                cons.removeAttr('disabled');
                setTimeout(function() {
                    cons.focus();
                }, 1750);
            }
        });

        cons.on('change', function() {
            if (this.value.length === 13) {
                jQuery.post(URL_BASE+'classes/pdv/ajax.php?tipo=busca_produto',
                {
                    token: token.val(), 
                    busca: this.value 
                },
                function(data) {
                    var objRetorno = JSON.parse(data);
                    produtoCod.val(objRetorno.produto.cod);
                    token.val(token.val());
                    produtoNome.text(objRetorno.produto.nome);
                    produtoUnidade.val(objRetorno.produto.unidade);
                    produtoValor.val( parseFloat(objRetorno.produto.valor).toFixed(2));

                    var t = parseFloat(parseFloat(produtoValor.val()) * parseFloat(produtoQtd.val())).toFixed(2);

                    if(isNaN(t)) {
                        produtoTotal.val('');
                    } else {
                        produtoTotal.val(t);
                    }
                    res.trigger('insere_produto_na_venda');

                },'html');
                return false;
            }
        });

        res.on('insere_produto_na_venda', function() {
            jQuery.post(URL_BASE+'classes/pdv/ajax.php?tipo=insere_produto_na_venda', {
                token: token.val(),
                cod: produtoCod.val(),
                VENDAID: VENDAID.val(),
                valor: parseFloat(produtoValor.val()).toFixed(2), 
                qtd: produtoQtd.val(),
                usuario: usuario.val(),
                empresa_id: empresa_id.val(),
                subempresa_id: subempresa_id.val(),
            },function (r) {
                    res.html(r);
                    setTimeout(function() {
                        produtoQtd.val('').focus();
                        cons.val('').attr('disabled', 'disabled');
                        produtoCod.val('');
                        cliente.val('');
                        produtoNome.val('Escolha um Produto');
                        produtoValor.val('');
                        produtoUnidade.val('');
                        produtoTotal.val('');
                    }, 1000);
            });
        });
    });
   
    //EXIBE E OCULTA BANCOS DO BOLETO
    jQuery('body').on('change', '#forma_recebimento', function() {

        if (jQuery('#forma_recebimento option:selected').val() == 5) {
            jQuery("#mostra_conta_bancaria").show("slow");
        } else {
            jQuery("#mostra_conta_bancaria").hide("slow");
        }
  
        if (jQuery('#forma_recebimento option:selected').val() == 5 || jQuery('#forma_recebimento option:selected').val() == 2 || jQuery('#forma_recebimento option:selected').val() == 4) {
            jQuery("#mostra_parcelas").show("slow");
            jQuery("#mostra_primeiro_vencimento").show("slow");
        } else {
            jQuery("#mostra_parcelas").hide("slow");
            jQuery("#mostra_primeiro_vencimento").hide("slow");
        }
        

    });

// ABRE CAIXA //
    jQuery('body').on('click', '#btn-abre-caixa', function(e){
        if (jQuery('#tipo_conta').val() == '') {
            alert('Escolha uma Conta!');
            jQuery('#tipo_conta').focus();
            return false;
        }
        if (jQuery('#saldo').val() == '') {
            alert('Digite um Saldo Inicial!');
            jQuery('#saldo').focus();
            return false;
        }
        var $btn          = $(this).button('loading');
        var saldo         = jQuery('#saldo').val();
        var tipo_conta    = jQuery('#tipo_conta').val();
        var empresa_id    = jQuery('#empresa_id').val();
        var subempresa_id = jQuery('#subempresa_id').val();
        var usuario       = jQuery('#usuario').val();
        var token         = jQuery('#ONGID').val();

        jQuery.post(URL_BASE+'classes/pdv/ajax.php?tipo=abre_caixa',
            {
            saldo: saldo, 
            tipo_conta: tipo_conta, 
            empresa_id: empresa_id, 
            subempresa_id: subempresa_id, 
            usuario: usuario, 
            token: btoa(token) 
            },
            function(data) {
                console.log(data)
                var objRetorno = JSON.parse(data);
                jQuery('#form-abre-caixa').hide('slow')
                jQuery('#resultado-abre-caixa').fadeIn(2000).html(getMensagemAlertas(objRetorno.tipo, objRetorno.msn, objRetorno.class));
                setTimeout(function() { 
                    jQuery('#form-abre-caixa').show('slow')
                    jQuery('#resultado-abre-caixa').html('');
                    jQuery('#modal_abre_caixa').modal('hide'); 
                    location.reload();
            }, 1000);
            },'html');
        return false;

    });
  
jQuery('#modal_abre_venda').on('hidden.bs.modal', function() {
setTimeout(function() {
jQuery('#qtd').focus();
}, 1250);
});

    //---------     NOVA V E N D A -------------//
    //abre modal da abertura de venda
    shortcut.add("f2", function(){
        if (verificaAbreVenda()) {
            jQuery('#modal_abre_venda').modal({
                keyboard: false
            })
            jQuery('#modal_abre_venda').modal('show');
            jQuery('#cliente').removeAttr('disabled').focus();   
            jQuery('#vendedor').removeAttr('disabled').focus();  
        }
    }); 

    //abre a venda
    jQuery('body').on('click', '#btn-abre-venda', function(e){
        var cliente         = jQuery('#cliente').val();
        var vendedor        = jQuery('#vendedor').val();
        var empresa_id      = jQuery('#empresa_id').val();
        var subempresa_id   = jQuery('#subempresa_id').val();
        var usuario         = jQuery('#usuario').val();
        var token           = jQuery('#token').val();
        
        if (jQuery('#cliente').val() == '' || jQuery('#vendedor').val() == '') {
            alert('Escolha um Cliente e um Vendedor!');
            return false;
        }
        var $btn = $('#btn-abre-venda').button('loading');
        jQuery.post(URL_BASE+'classes/pdv/ajax.php?tipo=abre_venda',
            {
            token: token, 
            usuario: usuario, 
            empresa_id: empresa_id, 
            subempresa_id: subempresa_id, 
            cliente: cliente, 
            vendedor: vendedor 
            },
            function(data) {
                
                var objRetorno = JSON.parse(data);
                jQuery('#form_inicia_venda').hide('slow')
                jQuery('#resultado-abre-venda').fadeIn(2000).html(getMensagemAlertas(objRetorno.tipo, objRetorno.msn, objRetorno.class));
                jQuery('#VENDAID').val(objRetorno.idVenda);
                jQuery('#fild_qtd').removeAttr('disabled');
                setTimeout(function() { 
                    setaFocusQTD();
                    jQuery('#form_inicia_venda').show('slow')
                    jQuery('#resultado-abre-venda').html('');
                    jQuery('#cliente').val('');
                    jQuery('#vendedor').val('');
                    jQuery('#modal_abre_venda').modal('hide'); 
            }, 1000);
            },'html');
        return false;

    });
    
    //remove item da venda
    jQuery('body').on('click','#remove-item-produto', function(){
        var VENDAID  = jQuery('#VENDAID').val();
        var token    = jQuery('#token').val();
        var id_item  = jQuery(this).data("id");         
        
        jQuery.post(URL_BASE+'classes/pdv/ajax.php?tipo=remove_item_venda',
            {VENDAID:VENDAID,id_item: id_item, token: token},
            function(dados) {
                jQuery('#result').fadeIn(2000).html(dados);
            },'html');
        return false;
    });

    //--------- F I M   V E N D A -------------//

    //--------- B U S C A    P R O D U T O S  F7-------------//
    shortcut.add("f7", function(){
        jQuery('#modal_busca_produtos').modal({
            keyboard: false
        });
        jQuery('#modal_busca_produtos').modal('show');
        return false;
    }); 

    jQuery('#btn-busca-produto').click(function(){
        var nomeb           = jQuery('#nomeb').val();
        var token           = jQuery('#token').val();
        var empresa_id      = jQuery('#empresa_id').val();
        var subempresa_id   = jQuery('#subempresa_id').val();
        if (nomeb == '') {
            alert("Digite uma Palavra Chave");
            jQuery('#nomeb').focus();
        } else {
            jQuery.post(URL_BASE+'classes/pdv/ajax.php?tipo=busca_produto_f7',
                { token: token, empresa_id: empresa_id, subempresa_id: subempresa_id, nomeb: nomeb},
                    function(dados) {
                        jQuery('#resultado-busca-produto').fadeIn(2000).html(dados);
                        document.form_bus.reset();
             
                },'html');
        }
        return false;
    }); 

    //--------- F I M   B U S C A    P R O D U T O S -------------//

    //--------- F E C H A   V E N D A -------------//
    shortcut.add("f4", function(){
        if (verificaFinalizarVenda()) {
            jQuery('#modal_fecha_venda').modal({
                keyboard: false
            });
            jQuery('#totalgeral_fim').val(jQuery('#totalgeral2').val());
            jQuery('#modal_fecha_venda').modal('show');
            jQuery('#forma_recebimento').focus();
        }
    }); 

    jQuery('body').on('click','#bt_final_venda', function(){

        var VENDAID           = jQuery('#VENDAID').val();
        var forma_recebimento = jQuery('#forma_recebimento').val();
        var obs_pg            = jQuery('#obs_pg').val();
        var totalgeral_fim    = jQuery('#totalgeral_fim').val();
        var desconto          = jQuery('#desconto').val();
        var pagando           = jQuery('#pagando').val();
        var troco             = jQuery('#troco').val();
        var empresa_id        = jQuery('#empresa_id').val();
        var subempresa_id     = jQuery('#subempresa_id').val();
        var usuario           = jQuery('#usuario').val();
        var token             = jQuery('#token').val();
        var plano_contas      = jQuery('#plano_contas').val();
        var n_parcelas          = jQuery('#n_parcelas').val();
        var primeiro_vencimento = jQuery('#primeiro_vencimento').val();
        var banco_boleto        = jQuery('#banco_boleto').data('idcobranca');
        
        if (forma_recebimento == '') {
            alert("Escolha uma FORMA DE RECEBIMENTO");
            jQuery('#forma_recebimento').focus();
        } else if (plano_contas == '') {
            alert("Escolha um PLANO DE CONTAS");
            jQuery('#plano_contas').focus();
        } else if ((pagando == '') || (pagando == 0)) {
            alert("Digite um valor RECEBENDO");
            jQuery('#pagando').focus();
        } else {
            var $btn = $('#bt_final_venda').button('loading')
            jQuery.post(URL_BASE+'classes/pdv/ajax.php?tipo=fecha_venda',
            { 
          
                plano_contas  : plano_contas, 
                forma_recebimento  : forma_recebimento, 
                obs_pg          : obs_pg, 
                totalgeral_fim  : totalgeral_fim, 
                desconto        : desconto, 
                pagando         : pagando, 
                troco           : troco, 
                empresa_id      : empresa_id, 
                subempresa_id   : subempresa_id, 
                VENDAID         : VENDAID, 
                usuario         : usuario, 
                token           : token,
                n_parcelas      : n_parcelas,
                primeiro_vencimento    : primeiro_vencimento,
                banco_boleto    : banco_boleto,
            },
            function(data) {
              
                var objRetorno = JSON.parse(data);
                jQuery('#resultado-fecha-venda').fadeIn(2000).html(getMensagemAlertas(objRetorno.tipo, objRetorno.msn, objRetorno.class));
                jQuery('#form_finalizavenda').hide('slow');
                jQuery('.modal-footer').hide('slow');
				
				var url_nota = URL_BASE+"views/pdv/print/print.php?venda="+btoa(VENDAID)+"&t="+btoa(token);
				var url_nfce = URL_BASE+"views/pdv/print/print_nfce.php?venda="+btoa(VENDAID)+"&t="+btoa(token);
				
				var btn_nota = "<a href='"+url_nota+"' target='_blank' class='btn btn-primary btn-lg btn-block' > <i class='fa fa-print'></i> Imprimir a Nota de Venda </a>";
				var btn_nfce = "<a href='"+url_nfce+"' target='_blank' class='btn btn-primary btn-lg btn-block' > <i class='fa fa-barcode'></i> Imprimir a NFCe </a>";
				
				$(".modal-body").html("<div class='row'><div class='col-md-6'>"+btn_nota+"</div><div class='col-md-6'>"+btn_nfce+"</div></div> <br /> <br /> ");
				
				/* jQuery('#FECHAR_VENDA').ready(function(){
                    var desejaPrint = confirm("Deseja Imprimir a Venda?");
                    if (desejaPrint == true) {
                        setTimeout(function() {
                            jQuery('#FECHAR_VENDA').modal('hide');
                                window.open(URL_BASE+"views/pdv/print/print.php?venda="+btoa(VENDAID)+"&t="+btoa(token), "_blank"); 
                                location.reload();
                        }, 1000);
                    } else {
                        setTimeout(function() {
                            jQuery('#FECHAR_VENDA').modal('hide');
                             location.reload();
                        }, 1000);   
                    } 
				}); */
            },
            'html');
        }
        return false;
    });

    //--------- E X C L U I   V E N D A -------------//
    shortcut.add("f8", function(){
        if (verificaExcluirVenda()) {
            jQuery('#modal_remove_venda').modal({
                keyboard: false
            });
            jQuery('#add-VENDAID').html(jQuery('#VENDAID').val());
            jQuery('#id_venda').val(jQuery('#VENDAID').val());
            jQuery('#modal_remove_venda').modal('show');
        }
    });  

    jQuery('body').on('click','#remove-venda', function(){
        var empresa_id     = jQuery('#empresa_id').val();
        var subempresa_id  = jQuery('#subempresa_id').val();
        var usuario        = jQuery('#usuario').val();
        var token          = jQuery('#token').val();
        var id_venda       = jQuery('#id_venda').val();
        var $btn = $('#remove-venda').button('loading');

        jQuery.post(URL_BASE+'classes/pdv/ajax.php?tipo=remove_venda',
        { empresa_id: empresa_id, subempresa_id: subempresa_id, usuario: usuario, token: token, id_venda: id_venda},
        function(dados) {
            var objRetorno = JSON.parse(dados);
            jQuery('#resultado-remove-venda').fadeIn(2000).html(getMensagemAlertas(objRetorno.tipo, objRetorno.msn, objRetorno.class));
            document.form_remove_venda.reset();
            document.form_remove_venda.style.display="none"; 
            setTimeout(function() {
                jQuery('#modal_remove_venda').modal('hide');
                location.reload();
            }, 2000);
        },
        'html');
        return false;
    });
    //--------- F I M   E X C L U I   V E N D A -------------//

    ///// MODAL FECHA CAUXA /////////
    shortcut.add("f6", function(){

        jQuery('#FECHA_CAIXA').modal({
        keyboard: false
        })
        jQuery('#FECHA_CAIXA').modal('show');

    }); 

    var requisitaPost_fecha_caixa = function () {
        var tipo_conta      = jQuery('#tipo_conta').val();
        var status          = jQuery('#status').val();
        var empresa_id      = jQuery('#empresa_id').val();
        var subempresa_id   = jQuery('#subempresa_id').val();
        var usuario         = jQuery('#usuario').val();
        var token           = jQuery('#token').val();
        var ONGID           = jQuery('#ONGID').val(); 
        
            jQuery.post('ajax_fecha_caixa.php',
            { 
                token: token, 
                ONGID: ONGID, 
                usuario: usuario, 
                empresa_id: empresa_id, 
                subempresa_id: subempresa_id, 
                tipo_conta: tipo_conta, 
                status: status
            },
            function(dados) {
                jQuery('#box_resulta_frecha_caixa').fadeIn(2000).html(dados);
                    
                    document.form_bus.reset();
                 
                },
            'html');
    return false;
    };

    jQuery('#btx_fechacaixa').bind('click', requisitaPost_fecha_caixa);
	
    /////////////////////////////////////////////

    //// calcula troco no finalizar venda (modal) //////////////

    function calcula_troco() {

        var totalVenda          = parseFloat(moedaParaNumero(jQuery('#totalgeral2').val()));
        var totalDesconto       = parseFloat(moedaParaNumero(jQuery('#desconto').val()));
        var totalComDesconto    = parseFloat(totalVenda - totalDesconto);
        var totalPagando        = parseFloat(moedaParaNumero(jQuery('#pagando').val()));
        var totalTroco          = parseFloat(totalPagando - totalComDesconto);
        jQuery('#troco').val(numeroParaMoeda(totalTroco));
    }
    //// finaliza vendad (modal) //////////////

    function getMensagemAlertas(tipo, msn, classCSS) {
        var mensage =  '<div class="alert alert-'+classCSS+'"><b>'+tipo+'</b> '+msn+'</div>';
        return mensage;
    }

    function setaFocusQTD () {
        return jQuery('#qtd').focus();
    }

    function verificaFinalizarVenda() {
        //Verificamos se o boto finalizar venda pode ser acionado
        if (jQuery("#totalgeral2").val() > 0 && jQuery("#VENDAID").val() > 0) {
            jQuery("#bt_final_venda").removeAttr("disabled");
            return true;
        } else {
            jQuery("#bt_final_venda").attr("disabled", "disabled");
            alert('Não existe venda a ser finalizada!')
            return false;
        }
    }

    function verificaExcluirVenda() {
        //Verificamos se o boto finalizar venda pode ser acionado
        if (jQuery("#VENDAID").val() > 0) {
            return true;
        } else {
            alert('Não existe venda a ser excluida!')
            return false;
        }
    }

    function verificaAbreVenda() {
        //Verificamos se o boto abre venda pode ser acionado
        if (jQuery("#VENDAID").val() > 0) {
            alert('Você não pode iniciar uma nova venda antes de finalizar ou excluir a venda que esta em andamento!')
            return false;
        } else {
            return true;
        }
    }


