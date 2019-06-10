checked=false;
function checkedAll (frm1) {
    var aa= document.getElementById('frm1');
     if (checked == false) {
           checked = true
    } else {
        checked = false
    }
    for (var i =0; i < aa.elements.length; i++) {
        aa.elements[i].checked = checked;
    }
  }




function validaFormsRelatorios(parametro, dados, urlreferencia) {

    if (urlreferencia == 'produtos') {
        if ($("#tipo").val() == '') {
            alert('Escolha um Tipo');
            $("#tipo").focus();
            return false;
        }

        if ($("#tipo_relatorio").val() == '') {
            alert('Escolha um Tipo de RelatÛrio');
            $("#tipo_relatorio").focus();
            return false;
        }
    }

    if (urlreferencia == 'pdv') {
        if ($("#data_inicio_es_pdv").val() == '') {
            alert('Escolha uma Data Inicial');
            $("#data_inicio_es_pdv").focus();
            return false;
        }

        if ($("#data_fim_es_pdv").val() == '') {
            alert('Escolha uma Final');
            $("#data_fim_es_pdv").focus();
            return false;
        }
        
    }
    return true;


    
    
}


/* M·scaras ER 
function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}
function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}
function mcep(v){
    v=v.replace(/\D/g,"")                    //Remove tudo o que n„o È dÌgito
    v=v.replace(/^(\d{5})(\d)/,"$1-$2")         //Esse È t„o f·cil que n„o merece explicaÁıes
    return v
}
function mtel(v){
    v=v.replace(/\D/g,"");             //Remove tudo o que n„o È dÌgito
    v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parÍnteses em volta dos dois primeiros dÌgitos
    v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca hÌfen entre o quarto e o quinto dÌgitos
    return v;
}
function mcel(v){
    v=v.replace(/\D/g,"");             //Remove tudo o que n„o È dÌgito
    v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parÍnteses em volta dos dois primeiros dÌgitos
    v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca hÌfen entre o quarto e o quinto dÌgitos
    return v;
}
//onkeypress="mascara(this,mtel)" maxlength="14"
function cnpj(v){
    v=v.replace(/\D/g,"")                           //Remove tudo o que n„o È dÌgito
    v=v.replace(/^(\d{2})(\d)/,"$1.$2")             //Coloca ponto entre o segundo e o terceiro dÌgitos
    v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3") //Coloca ponto entre o quinto e o sexto dÌgitos
    v=v.replace(/\.(\d{3})(\d)/,".$1/$2")           //Coloca uma barra entre o oitavo e o nono dÌgitos
    v=v.replace(/(\d{4})(\d)/,"$1-$2")              //Coloca um hÌfen depois do bloco de quatro dÌgitos
    return v
}
function mcpf(v){
    v=v.replace(/\D/g,"")                    //Remove tudo o que n„o È dÌgito
    v=v.replace(/(\d{3})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto dÌgitos
    v=v.replace(/(\d{3})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto dÌgitos
                                             //de novo (para o segundo bloco de n˙meros)
    v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2") //Coloca um hÌfen entre o terceiro e o quarto dÌgitos
    return v
}
function mdata(v){
    v=v.replace(/\D/g,"");                    //Remove tudo o que n„o È dÌgito
    v=v.replace(/(\d{2})(\d)/,"$1/$2");
    v=v.replace(/(\d{2})(\d)/,"$1/$2");

    v=v.replace(/(\d{2})(\d{2})$/,"$1$2");
    return v;
}
function mtempo(v){
    v=v.replace(/\D/g,"");                    //Remove tudo o que n„o È dÌgito
    v=v.replace(/(\d{1})(\d{2})(\d{2})/,"$1:$2.$3");
    return v;
}
function mhora(v){
    v=v.replace(/\D/g,"");                    //Remove tudo o que n„o È dÌgito
    v=v.replace(/(\d{2})(\d)/,"$1h$2");
    return v;
}
function mrg(v){
    v=v.replace(/\D/g,"");                                      //Remove tudo o que n„o È dÌgito
        v=v.replace(/(\d)(\d{7})$/,"$1.$2");    //Coloca o . antes dos ˙ltimos 3 dÌgitos, e antes do verificador
        v=v.replace(/(\d)(\d{4})$/,"$1.$2");    //Coloca o . antes dos ˙ltimos 3 dÌgitos, e antes do verificador
        v=v.replace(/(\d)(\d)$/,"$1-$2");               //Coloca o - antes do ˙ltimo dÌgito
    return v;
}
function mnum(v){
    v=v.replace(/\D/g,"");                                      //Remove tudo o que n„o È dÌgito
    return v;
}
function mvalor(v){
    v=v.replace(/\D/g,"");//Remove tudo o que n„o È dÌgito
    v=v.replace(/(\d)(\d{8})$/,"$1.$2");//coloca o ponto dos milhıes
    v=v.replace(/(\d)(\d{5})$/,"$1.$2");//coloca o ponto dos milhares

    v=v.replace(/(\d)(\d{2})$/,"$1,$2");//coloca a virgula antes dos 2 ˙ltimos dÌgitos
    return v;
}

*/


/* M·scaras ER */
function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}
function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}
function mtel(v){
    v=v.replace(/\D/g,"");             //Remove tudo o que n„o È dÌgito
    v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parÍnteses em volta dos dois primeiros dÌgitos
    v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca hÌfen entre o quarto e o quinto dÌgitos
    return v;
}
function id( el ){
    return document.getElementById( el );
}

function confirmaExclusao(aURL) {
    if(confirm('VocÍ tem certeza que deseja excluir?')) {
        document.frm1.submit();
    }
}
function confirmaUpdatePlano(aURL) {
    if(confirm('VocÍ tem certeza que deseja alterar seu plano?')) {
        location.href=aURL;
    }
}

function confirmaFinalizaChamado(aURL, IDCHAMADO) {
    if(confirm('VocÍ tem certeza que deseja finalizar o chamado N∫ '+IDCHAMADO)) {
        location.href=aURL;
    }
}

function confirmaFaturarComissao(aURL) {
    var checado =  jQuery('#frm1').find("input[class='checkboxc']:checked").length > 0;
    if (checado) {
        if (confirm('VocÍ tem certeza que deseja Faturar as Comissıes Selecionadas?')) {
            document.frm1.submit();
        }
    } else {
        alert('Selecione pelo menos uma Comiss„o!');
        return false;
    }
}

function incrementaMeses(n) {
    var data = "01/"+$('#mes').val();
    $('#mes').val(incMeses(data, n).substring(3));
    var data2 = "01/" + $('#mes').val();
    $('#dataIni').val(getDataInicialMes(data2));
    $('#dataFim').val(getDataFinalMes(data2));
}
function getDataInicialMes(dataServ){ // dd/mm/yyyy
    var dataInicial = Date.fromString('01/' + dataServ.substring(3));
    return dataInicial.asString();
}

function getDataFinalMes(dataServ){ // dd/mm/yyyy
    var dataFinal = Date.fromString('01/' + dataServ.substring(3)).addMonths(1).addDays(-1);
    return dataFinal.asString();
}



function incMeses(dataServ, n){ // dd/mm/yyyy

    if ((n == 0) && (dataServ !="")){
            while ((dataServ.substr(2,1) != "/") && (dataServ.length < 10)) {
                dataServ = "0" + dataServ;
            }

            while ((dataServ.substr(5,1) != "/") && (dataServ.length < 10)) {
                    dataServ = (dataServ.substr(0, 3) + "0" + dataServ.substr(3));
            }

            while (dataServ.length < 10) {
                dataServ += "0";
            }
    }

    var data = Date.fromString(dataServ);
    data.addMonths(n);
    return data.asString();
    /*
    var data = Date.fromString('01/' + inputField.val());
    data.addMonths(n);
    inputField.val(data.asString().substring(3));
    */
}

function incDias(dataServ, n){ // dd/mm/yyyy
    data = dataServ.split("/");
    var dia = data[0];
    var mes = data[1];
    var ano = data[2];
    data = Date.UTC(ano, mes-1, dia);
    data += n * 24 * 60 * 60 * 1000;
    data = new Date(data);
    dia = data.getUTCDate();
    if (dia < 10){
        dia = "0" + dia;
    }
    mes = data.getUTCMonth()+1;
    if (mes < 10){
        mes = "0" + mes;
    }
    ano = data.getUTCFullYear();
    return dia + "/" + mes + "/" + ano;
    /*data = Date.fromString(dataServ);
    data.addDays(n);
    return data.asString();*/
}

function formatReal( int ) {
    var tmp = int+'';
    tmp = tmp.replace(/([0-9]{2})$/g, ",$1");
    if( tmp.length > 6 )
    tmp = tmp.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");
    return tmp;
}

function formatdate(date){
    var result;
    result = date.substr(3,2) + '/'+date.substr(0,2) + '/' + date.substr(6,4);
    return(result.toString());
}

function diaDaSemana(data){
    // 2/05/2007
    var len = data.length;
    pos = data.indexOf("/");
    day = data.substring(0,pos);
    data2 = data.substring(pos+1,len);
    pos2 = data2.indexOf("/");
    month =  data2.substring(0,pos2);
    var len2 = data2.length;
    year = data2.substring(len2-4,len2);
   var val1 = parseInt(day, 10)
   var val2 = parseInt(month, 10)
   var val2x = parseInt(month, 10)
   var val3 = parseInt(year, 10)
   if (val2 == 1) {
      val2x = 13;
      val3 = val3-1
   }
   if (val2 == 2) {
      val2x = 14;
      val3 = val3-1
   }
   var val4 = parseInt(((val2x+1)*3)/5, 10)
   var val5 = parseInt(val3/4, 10)
   var val6 = parseInt(val3/100, 10)
   var val7 = parseInt(val3/400, 10)
   var val8 = val1+(val2x*2)+val4+val3+val5-val6+val7+2
   var val9 = parseInt(val8/7, 10)
   var val0 = val8-(val9*7)
   return val0;
}

function cpfCnpj(v){
    v = v.replace(/\D/g,"");

    if (v.length <= 11) {
        v = v.replace(/(\d{3})(\d)/,"$1.$2");
        v = v.replace(/(\d{3})(\d)/,"$1.$2");
        v = v.replace(/(\d{3})(\d{1,2})$/,"$1-$2");
    } else {
        v = v.replace(/^(\d{2})(\d)/,"$1.$2");
        v = v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3");
        v = v.replace(/\.(\d{3})(\d)/,".$1/$2");
        v = v.replace(/(\d{4})(\d)/,"$1-$2");
    }

    return v;
}

var keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
function encode64(input) {
    input += "";
    var output = "";
    var chr1, chr2, chr3;
    var enc1, enc2, enc3, enc4;
    var i = 0;

    do {
        chr1 = input.charCodeAt(i++);
        chr2 = input.charCodeAt(i++);
        chr3 = input.charCodeAt(i++);

        enc1 = chr1 >> 2;
        enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
        enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
        enc4 = chr3 & 63;

        if (isNaN(chr2)) {
            enc3 = enc4 = 64;
        } else if (isNaN(chr3)) {
            enc4 = 64;
        }

        output = output + keyStr.charAt(enc1) + keyStr.charAt(enc2) + keyStr.charAt(enc3) + keyStr.charAt(enc4);
    } while (i < input.length);

    return output;
}

function decode64(input) {
    var output = "";
    var chr1, chr2, chr3;
    var enc1, enc2, enc3, enc4;
    var i = 0;

    // remove all characters that are not A-Z, a-z, 0-9, +, /, or =
    input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

    do {
        enc1 = keyStr.indexOf(input.charAt(i++));
        enc2 = keyStr.indexOf(input.charAt(i++));
        enc3 = keyStr.indexOf(input.charAt(i++));
        enc4 = keyStr.indexOf(input.charAt(i++));

        chr1 = (enc1 << 2) | (enc2 >> 4);
        chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
        chr3 = ((enc3 & 3) << 6) | enc4;

        output = output + String.fromCharCode(chr1);

        if (enc3 != 64) {
            output = output + String.fromCharCode(chr2);
        }
        if (enc4 != 64) {
            output = output + String.fromCharCode(chr3);
        }
    } while (i < input.length);

    return output;
}

function calculaIdade(nasc) {
    var sDataI = nasc.split("/");
    var nasc_dia = sDataI[0];
    var nasc_mes = sDataI[1];
    var nasc_ano = sDataI[2];
    var dat = new Date();
    var ano = dat.getFullYear();
    var dia = dat.getDate();
    var mes = dat.getMonth() + 1;
    var idade = ano - nasc_ano;

    if (mes > nasc_mes) {
        return idade;
    }
    if (dia >= nasc_dia && mes >= nasc_mes) {
        return idade;
    } else {
        idade = idade -1;
        return idade;
    }
}

function formatTime(time){
    var timef = time.replace(/\D+/g, '');
    timef = timef.substring(0,4);
    if (timef.length > 2){
        timef = timef.substring(0,2) + ":" + timef.substring(2,4);
    }
    return timef;
}

function removeAcentos(Campo){
    var Acentos = "·‡„‚‚¡¿√¬ÈÍ… ÌÕÛıÙ”‘’˙¸⁄‹Á«";
    var Traducao ="aaaaaAAAAeeEEiIoooOOOuuUUcC";
    var Posic, Carac;
    var TempLog = "";
    for (var i=0; i < Campo.length; i++){
        Carac = Campo.charAt(i);
        Posic = Acentos.indexOf(Carac);
        if(Posic > -1){
            TempLog += Traducao.charAt(Posic);
        }else{
            TempLog += Campo.charAt(i);
        }
    }
    TempLog = TempLog.replace("'", "");
    return (TempLog);
}

function isEmailAddress(email){
    var s = email;
    var filter=/^[A-Za-z][A-Za-z0-9_.-]*@[A-Za-z0-9_.-]+\.[A-Za-z0-9_.]+[A-za-z]$/;

    if (s.length == 0 ){
        return false;
    }

    if (filter.test(s)){
        return true;
    }else{
        return false;
    }
}

function zerosEsquerda(valor, tamanho){
    valor = '' + valor;
    var sTam = valor.length;
    while (sTam < tamanho) {
        valor = "0" + valor;
        sTam = valor.length;
    }
    return valor;
}




/*
 verifica_cpf_cnpj
 
 Verifica se È CPF ou CNPJ
 
*/
function verifica_cpf_cnpj ( valor ) {
 
    // Garante que o valor È uma string
    valor = valor.toString();
    
    // Remove caracteres inv·lidos do valor
    valor = valor.replace(/[^0-9]/g, '');
 
    // Verifica CPF
    if ( valor.length === 11 ) {
        return 'CPF';
    } 
    
    // Verifica CNPJ
    else if ( valor.length === 14 ) {
        return 'CNPJ';
    } 
    
    // N„o retorna nada
    else {
        return false;
    }
    
} // verifica_cpf_cnpj
 
/*
 calc_digitos_posicoes
 
 Multiplica dÌgitos vezes posiÁıes
 
 @param string digitos Os digitos desejados
 @param string posicoes A posiÁ„o que vai iniciar a regress„o
 @param string soma_digitos A soma das multiplicaÁıes entre posiÁıes e dÌgitos
 @return string Os dÌgitos enviados concatenados com o ˙ltimo dÌgito
*/
function calc_digitos_posicoes( digitos, posicoes = 10, soma_digitos = 0 ) {
 
    // Garante que o valor È uma string
    digitos = digitos.toString();
 
    // Faz a soma dos dÌgitos com a posiÁ„o
    // Ex. para 10 posiÁıes:
    //   0    2    5    4    6    2    8    8   4
    // x10   x9   x8   x7   x6   x5   x4   x3  x2
    //   0 + 18 + 40 + 28 + 36 + 10 + 32 + 24 + 8 = 196
    for ( var i = 0; i < digitos.length; i++  ) {
        // Preenche a soma com o dÌgito vezes a posiÁ„o
        soma_digitos = soma_digitos + ( digitos[i] * posicoes );
 
        // Subtrai 1 da posiÁ„o
        posicoes--;
 
        // Parte especÌfica para CNPJ
        // Ex.: 5-4-3-2-9-8-7-6-5-4-3-2
        if ( posicoes < 2 ) {
            // Retorno a posiÁ„o para 9
            posicoes = 9;
        }
    }
 
    // Captura o resto da divis„o entre soma_digitos dividido por 11
    // Ex.: 196 % 11 = 9
    soma_digitos = soma_digitos % 11;
 
    // Verifica se soma_digitos È menor que 2
    if ( soma_digitos < 2 ) {
        // soma_digitos agora ser· zero
        soma_digitos = 0;
    } else {
        // Se for maior que 2, o resultado È 11 menos soma_digitos
        // Ex.: 11 - 9 = 2
        // Nosso dÌgito procurado È 2
        soma_digitos = 11 - soma_digitos;
    }
 
    // Concatena mais um dÌgito aos primeiro nove dÌgitos
    // Ex.: 025462884 + 2 = 0254628842
    var cpf = digitos + soma_digitos;
 
    // Retorna
    return cpf;
    
} // calc_digitos_posicoes
 
/*
 Valida CPF
 
 Valida se for CPF
 
 @param  string cpf O CPF com ou sem pontos e traÁo
 @return bool True para CPF correto - False para CPF incorreto
*/
function valida_cpf( valor ) {
 
    // Garante que o valor È uma string
    valor = valor.toString();
    
    // Remove caracteres inv·lidos do valor
    valor = valor.replace(/[^0-9]/g, '');
 

    // Captura os 9 primeiros dÌgitos do CPF
    // Ex.: 02546288423 = 025462884
    var digitos = valor.substr(0, 9);
 
    // Faz o c·lculo dos 9 primeiros dÌgitos do CPF para obter o primeiro dÌgito
    var novo_cpf = calc_digitos_posicoes( digitos );
 
    // Faz o c·lculo dos 10 dÌgitos do CPF para obter o ˙ltimo dÌgito
    var novo_cpf = calc_digitos_posicoes( novo_cpf, 11 );
      alert(valor)
    // Verifica se o novo CPF gerado È idÍntico ao CPF enviado
    if ( novo_cpf === valor ) {
        // CPF v·lido
        return true;
    } else {
        // CPF inv·lido
        return false;
    }
    
} // valida_cpf
 
/*
 valida_cnpj
 
 Valida se for um CNPJ
 
 @param string cnpj
 @return bool true para CNPJ correto
*/
function valida_cnpj ( valor ) {

    // Garante que o valor È uma string
    valor = valor.toString();
    
    // Remove caracteres inv·lidos do valor
    valor = valor.replace(/[^0-9]/g, '');
 
    
    // O valor original
    var cnpj_original = valor;
 
    // Captura os primeiros 12 n˙meros do CNPJ
    var primeiros_numeros_cnpj = valor.substr( 0, 12 );
 
    // Faz o primeiro c·lculo
    var primeiro_calculo = calc_digitos_posicoes( primeiros_numeros_cnpj, 5 );
 
    // O segundo c·lculo È a mesma coisa do primeiro, porÈm, comeÁa na posiÁ„o 6
    var segundo_calculo = calc_digitos_posicoes( primeiro_calculo, 6 );
 
    // Concatena o segundo dÌgito ao CNPJ
    var cnpj = segundo_calculo;
 
    // Verifica se o CNPJ gerado È idÍntico ao enviado
    if ( cnpj === cnpj_original ) {
        return true;
    }
    
    // Retorna falso por padr„o
    return false;
    
} // valida_cnpj
 
/*
 valida_cpf_cnpj
 
 Valida o CPF ou CNPJ
 
 @access public
 @return bool true para v·lido, false para inv·lido
*/
function valida_cpf_cnpj ( valor ) {

    // Verifica se È CPF ou CNPJ
    var valida = verifica_cpf_cnpj( valor );

    // Garante que o valor È uma string
    valor = valor.toString();
    
    // Remove caracteres inv·lidos do valor
    valor = valor.replace(/[^0-9]/g, '');

 
    // Valida CPF
    if ( valida === 'CPF' ) {
        // Retorna true para cpf v·lido
        return valida_cpf( valor );
    } 
    
    // Valida CNPJ
    else if ( valida === 'CNPJ' ) {
        // Retorna true para CNPJ v·lido
        return valida_cnpj( valor );
    } 
    
    // N„o retorna nada
    else {
        return false;
    }
    
} // valida_cpf_cnpj
 
/*
 formata_cpf_cnpj
 
 Formata um CPF ou CNPJ
 
 @access public
 @return string CPF ou CNPJ formatado
*/
function formata_cpf_cnpj( valor ) {
 
    // O valor formatado
    var formatado = false;
    
    // Verifica se È CPF ou CNPJ
    var valida = verifica_cpf_cnpj( valor );
 
    // Garante que o valor È uma string
    valor = valor.toString();
    
    // Remove caracteres inv·lidos do valor
    valor = valor.replace(/[^0-9]/g, '');
 
 
    // Valida CPF
    if ( valida === 'CPF' ) {
    
        // Verifica se o CPF È v·lido
        if ( valida_cpf( valor ) ) {
        
            // Formata o CPF ###.###.###-##
            formatado  = valor.substr( 0, 3 ) + '.';
            formatado += valor.substr( 3, 3 ) + '.';
            formatado += valor.substr( 6, 3 ) + '-';
            formatado += valor.substr( 9, 2 ) + '';
            
        }
        
    }
    
    // Valida CNPJ
    else if ( valida === 'CNPJ' ) {
    
        // Verifica se o CNPJ È v·lido
        if ( valida_cnpj( valor ) ) {
        
            // Formata o CNPJ ##.###.###/####-##
            formatado  = valor.substr( 0,  2 ) + '.';
            formatado += valor.substr( 2,  3 ) + '.';
            formatado += valor.substr( 5,  3 ) + '/';
            formatado += valor.substr( 8,  4 ) + '-';
            formatado += valor.substr( 12, 14 ) + '';
            
        }
        
    } 
 
    // Retorna o valor 
    return formatado;
    
} // formata_cpf_cnpj


function limpa_formulario_cep(alerta) {
  if (alerta !== undefined) {
    alert(alerta);
  }

  inputsCEP.val('');
}

function get(url) {

    $.get(url, function(result) {
        $('.cep').val(result.cep);
        $('.endereco').val(result.logradouro);
        $('.bairro').val(result.bairro);
        $('.uf').val(result.uf);
        $('.cidade').val(result.localidade);
        $('.numero').focus();
    });
}

