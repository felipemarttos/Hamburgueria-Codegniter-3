<?php 

if (!function_exists('retornaDddFone')) {
    
    function retornaDddFone($fone, $retorno = 'fone') {
        $vetor = str_replace('(', '', $fone);
        $vetor = str_replace(')', '', $vetor);
        $vetor = str_replace('-', '', $vetor);
        $vetor = explode(' ', $vetor);
        if ($retorno == 'ddd') {
            $ddd = $vetor[0];
        }
        if ($retorno == 'fone') {
            $ddd = $vetor[1];
        }
        return $ddd;
    }

}


if (!function_exists('geraDataNormal')) {

    function geraDataNormal($data) {
        $vetor = explode('-', $data);
        $dataTratada = $vetor[2] . '/' . $vetor[1] . '/' . $vetor[0];
        return $dataTratada;
    }
    
}

if (!function_exists('trata_data')) {

    function trata_data($campo) {
        $qtd = strlen($campo);
        $campoTratado = ($qtd == 1) ? '0'.$campo : $campo;
        return $campoTratado;
    }

}

if (!function_exists('geraDataBD')) {

    function geraDataBD($data) {
        $vetor = explode('/', $data);
        $dataTratada = $vetor[2] . '-' . $vetor[1] . '-' . $vetor[0];
        return $dataTratada;
    }

}


function redireciona($url, $tempo = 0) {
    echo '<meta http-equiv="refresh" content="'.$tempo.';URL='.$url.'" />'; 
}

function geraDataTimeBD($data) {
    $vetor = explode('/', $data);
    $vetor2 = explode(' ', $vetor[2]);
    $dataTratada = $vetor2[0] . '-' . $vetor[1] . '-' . $vetor[0] . ' ' . $vetor2[1] . ':00';
    return $dataTratada;
}

function geraDataTimeNormal($data) {
    $vetor = explode('-', $data);
    $vetor2 = explode(' ', $vetor[2]);
    $dataTratada = $vetor2[0] . '/' . $vetor[1] . '/' . $vetor[0] . ' ' . $vetor2[1];
    return $dataTratada;
}
// Fun��o de porcentagem: Quanto � X% de N?
function porcentagem_xn ( $porcentagem, $total ) {
    return ( $porcentagem / 100 ) * $total;
}
// Fun��o de porcentagem: N � X% de N
function porcentagem_nx ( $valor, $total ) {
    if ($valor <= 0) {
        return 0;
    }
    $res = ( $valor * 100 ) / $total;
    if ($res <= 0) {
        $res = 0;
    }
    return $res;
}
 
// Fun��o de porcentagem: N � N% de X
function porcentagem_nnx ( $parcial, $porcentagem ) {
    return ( $parcial / $porcentagem ) * 100;
}


/// valores formatados
function geraValorReais($valor) {
    $valorTratado = 'R$ '.number_format($valor, 2, ',', '.');
    return $valorTratado;
}

function geraValorReaisSem($valor) {
    $valorTratado = number_format($valor, 2, ',', '.');
    return $valorTratado;
}

function geraValorBD($valor) {
    $valorTratado = str_replace(",",".",str_replace(".","",$valor));
    return $valorTratado;
}

function corta_texto($texto, $qtd, $terminador='...') {
    if (strlen($texto)>$qtd) {
            $texto = (substr($texto,0,$qtd)).($terminador);
    }
    return $texto;
}

function dataPorExtenso($data){

    $p = explode('-', $data);
    $dia = $p[2];
    $mes = $p[1];
    $ano = $p[0];
    $semana = date('w');

    switch ($mes){

        case 1: $mes = "Janeiro"; break;
        case 2: $mes = "Fevereiro"; break;
        case 3: $mes = "Março"; break;
        case 4: $mes = "Abril"; break;
        case 5: $mes = "Maio"; break;
        case 6: $mes = "Junho"; break;
        case 7: $mes = "Julho"; break;
        case 8: $mes = "Agosto"; break;
        case 9: $mes = "Setembro"; break;
        case 10: $mes = "Outubro"; break;
        case 11: $mes = "Novembro"; break;
        case 12: $mes = "Dezembro"; break;

    }

    switch ($semana) {

        case 0: $semana = "DOMINGO"; break;
        case 1: $semana = "SEGUNDA-FEIRA"; break;
        case 2: $semana = "TERÇA-FEIRA"; break;
        case 3: $semana = "QUARTA-FEIRA"; break;
        case 4: $semana = "QUINTA-FEIRA"; break;
        case 5: $semana = "SEXTA-FEIRA"; break;
        case 6: $semana = "SÁBADO"; break;

    }
    $data_extenso = $dia . ' de ' . $mes . ' de ' . $ano;

    return $data_extenso;
}
function mesPorExtenso($mes, $ano){

    switch ($mes){

        case 1: $mes = "Janeiro"; break;
        case 2: $mes = "Fevereiro"; break;
        case 3: $mes = "Março"; break;
        case 4: $mes = "Abril"; break;
        case 5: $mes = "Maio"; break;
        case 6: $mes = "Junho"; break;
        case 7: $mes = "Julho"; break;
        case 8: $mes = "Agosto"; break;
        case 9: $mes = "Setembro"; break;
        case 10: $mes = "Outubro"; break;
        case 11: $mes = "Novembro"; break;
        case 12: $mes = "Dezembro"; break;

    }

    $data_extenso = $mes . ' de ' . $ano;

    return $data_extenso;
}
function mesExtenso($mes){

    switch ($mes){

        case 1: $mes = "Janeiro"; break;
        case 2: $mes = "Fevereiro"; break;
        case 3: $mes = "Março"; break;
        case 4: $mes = "Abril"; break;
        case 5: $mes = "Maio"; break;
        case 6: $mes = "Junho"; break;
        case 7: $mes = "Julho"; break;
        case 8: $mes = "Agosto"; break;
        case 9: $mes = "Setembro"; break;
        case 10: $mes = "Outubro"; break;
        case 11: $mes = "Novembro"; break;
        case 12: $mes = "Dezembro"; break;

    }

    $data_extenso = $mes ;

    return $data_extenso;
}

function numeroExtenso($valor){
    $singular = array("CENTAVO", "REAL", "MIL", "MILHÃO", "BILHÃO", "TRILHÃO", "QUATRILHÃO");
    $plural = array("CENTAVOS", "REAIS", "MIL", "MILHÕES", "BILHÕES", "TRILHÕES",
    "QUATRILHÕES");

    $c = array("", "CEM", "DUZENTOS", "TREZENTOS", "QUATROCENTOS",
    "QUINHENTOS", "SEISCENTOS", "SETECENTOS", "OITOCENTOS", "NOVECENTOS");
    $d = array("", "DEZ", "VINTE", "TRINTA", "QUARENTA", "CINQUENTA",
    "SESSENTA", "SETENTA", "OITENTA", "NOVENTA");
    $d10 = array(
                    "", 
                    "UM", 
                    "DOIS", 
                    "TRÊS", 
                    "QUATRO", 
                    "CINCO", 
                    "SEIS",
                    "SETE", 
                    "OITO", 
                    "NOVE",
                    "DEZ", 
                    "ONZE", 
                    "DOZE", 
                    "TREZE", 
                    "QUATORZE", 
                    "QUINZE",
                    "DEZESSEIS", 
                    "DEZESETE", 
                    "DEZOITO", 
                    "DEZENOVE"
    );
    return mb_strtolower($d10[$valor]);
}
function valorExtenso($valor = 0, $maiusculas = false) {

    $singular = array("CENTAVO", "REAL", "MIL", "MILHÃO", "BILHÃO", "TRILHÃO", "QUATRILHÃO");
    $plural = array("CENTAVOS", "REAIS", "MIL", "MILHÕES", "BILHÕES", "TRILHÕES",
    "QUATRILHÕES");

    $c = array("", "CEM", "DUZENTOS", "TREZENTOS", "QUATROCENTOS",
    "QUINHENTOS", "SEISCENTOS", "SETECENTOS", "OITOCENTOS", "NOVECENTOS");
    $d = array("", "DEZ", "VINTE", "TRINTA", "QUARENTA", "CINQUENTA",
    "SESSENTA", "SETENTA", "OITENTA", "NOVENTA");
    $d10 = array("DEZ", "ONZE", "DOZE", "TREZE", "QUATORZE", "QUINZE",
    "DEZESSEIS", "DEZESETE", "DEZOITO", "DEZENOVE");
    $u = array("", "UM", "DOIS", "TRÊS", "QUATRO", "CINCO", "SEIS",
    "SETE", "OITO", "NOVE");

    $z = 0;
    $rt = "";

    $valor = number_format($valor, 2, ".", ".");
    $inteiro = explode(".", $valor);
    for($i=0;$i<count($inteiro);$i++)
    for($ii=strlen($inteiro[$i]);$ii<3;$ii++)
    $inteiro[$i] = "0".$inteiro[$i];

    $fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2);
    for ($i=0;$i<count($inteiro);$i++) {
        $valor = $inteiro[$i];
        $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
        $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
        $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

        $r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd &&
        $ru) ? " e " : "").$ru;
        $t = count($inteiro)-1-$i;
        $r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
        if ($valor == "000")$z++; elseif ($z > 0) $z--;
        if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t];
        if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) &&
        ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
    }

    if(!$maiusculas){
        return($rt ? mb_strtolower($rt) : "zero");
    } else {

    if ($rt) $rt=ereg_replace(" E "," e ",ucwords($rt));
        return (($rt) ? (mb_strtolower($rt)) : "Zero");
    }

}




function tirarAcentos($string){
    return preg_replace(array("/(�|�|�|�|�)/","/(�|�|�|�|�)/","/(�|�|�|�)/","/(�|�|�|�)/","/(�|�|�|�)/","/(�|�|�|�)/","/(�|�|�|�|�)/","/(�|�|�|�|�)/","/(�|�|�|�)/","/(�|�|�|�)/","/(�)/","/(�)/","/(�)/","/(�)/"),explode(" ","a A e E i I o O u U n N c C"),$string);
}

function removeAcentos($string, $slug = false) {
    $string2 = tirarAcentos($string);
    $string = strtolower($string2);
    // Código ASCII das vogais
    $ascii['a'] = range(224, 230);
    $ascii['e'] = range(232, 235);
    $ascii['i'] = range(236, 239);
    $ascii['o'] = array_merge(range(242, 246), array(240, 248));
    $ascii['u'] = range(249, 252);

    // Código ASCII dos outros caracteres
    $ascii['b'] = array(223);
    $ascii['c'] = array(231);
    $ascii['d'] = array(208);
    $ascii['n'] = array(241);
    $ascii['y'] = array(253, 255);

    foreach ($ascii as $key=>$item) {
        $acentos = '';
        foreach ($item AS $codigo) $acentos .= chr($codigo);
        $troca[$key] = '/['.$acentos.']/i';
    }

    $string = preg_replace(array_values($troca), array_keys($troca), $string);

    // Slug?
    if ($slug) {
        // Troca tudo que não for letra ou número por um caractere ($slug)
        $string = preg_replace('/[^a-z0-9]/i', $slug, $string);
        // Tira os caracteres ($slug) repetidos
        $string = preg_replace('/' . $slug . '{2,}/i', $slug, $string);
        $string = trim($string, $slug);
    }

   $string = eregi_replace('( )','-',$string);
    //tirando outros caracteres invalidos
    $string = eregi_replace('[^a-z0-9\-]','',$string);
    $string = eregi_replace('--','-',$string);
    return $string;
}

function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = true) {
    $lmin = 'abcdefghijklmnopqrstuvwxyz';
    $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $num = '1234567890';
    $simb = '!@#$%*-';
    $retorno = '';
    $caracteres = '';

    $caracteres .= $lmin;
    if ($maiusculas) $caracteres .= $lmai;
    if ($numeros) $caracteres .= $num;
    if ($simbolos) $caracteres .= $simb;

    $len = strlen($caracteres);
    for ($n = 1; $n <= $tamanho; $n++) {
        $rand = mt_rand(1, $len);
        $retorno .= $caracteres[$rand-1];
    }
    return $retorno;
}



function dataTimeExtenso($input) {
    $minute = 60; // seconds
    $hour = 3600; // seconds
    $day = 86400; // seconds
    $week = 604800; // seconds
    $month = 2629743; // seconds
    $year = 31556926; // seconds
     
    $localtime = time();
    $time = strtotime($input); // transform input to timestamp
    $diff = $localtime - $time; // get difference in seconds
     
    switch (true) {
                  
        // seconds
        case ($diff < $minute); // if difference less them a minute
        $count = $diff; // hold the value
        if ($count == 0) {
            $count = 1;
            $suffix = "segundo";
        } elseif ($count == 1) {
            $suffix = "segundo";
        } else {
            $suffix = "segundos";
        }
        break;
         
        // minute
        case ($diff > $minute && $diff < $hour); /* if difference greater them a minute and if diff less them an hour */
        $count = floor($diff / $minute); // here i divided by minute in order to get 1
        if ($count == 1) {
            $suffix = "minuto";
        } else {
            $suffix = "minutos";
        }
        break;

        // hour
        case ($diff > $hour && $diff < $day); /* if difference greater them an hour and if diff less them a day */
        $count = floor($diff / $hour); // here i divided by hour in order to get 1
        if ($count == 1) {
            $suffix = "hora";
        } else {
            $suffix = "horas";
        }
        break;
         
        // day
        case ($diff > $day && $diff < $week); /* if difference greater them a day and if diff less them a week */
        $count = floor($diff / $day); // here i divided by day in order to get 1
        if ($count == 1) {
            $suffix = "dia";
        } else {
            $suffix = "dias";
        }
        break;

        // week
        case ($diff > $week && $diff < $month); /* if difference greater them a week and if diff less them a month */
        $count = floor($diff / $week); // here i divided by week in order to get 1
        if ($count == 1) {
            $suffix = "semana";
        } else {
            $suffix = "semanas";
        }
        break;
         
        // month
        case ($diff > $month && $diff < $year); /* if difference greater them a month and if diff less them a year */
        $count = floor($diff / $month); // here i divided by month in order to get 1
        if ($count == 1) {
            $suffix = "m�s";
        } else {
            $suffix = "m�ses";
        }
        break;

        // year
        case ($diff > $year); /* if difference greater them a year */
        $count = floor($diff / $year); // here i divided by year in order to get 1
        if ($count == 1) {
            $suffix = "ano";
        } else {
            $suffix = "anos";
        }
        break;
    }
    return "Postado " . $count . " " . $suffix . " atr�s";
}



//$pw = "T3sT@.-T3lecontrol3123";

/**
 * $pw string
 * $key random_bytes(32)
 */
function passwordCrypt($pw, $key) {
    $enc = openssl_encrypt($pw, 'aes-128-cbc', $key);
    $key = bin2hex($key);
    $keyI = substr($key, 0, strlen($key) / 2);
    $keyF = substr($key, strlen($key) / 2);
    return $keyF."/".$enc."/".$keyI;
}

function passwordDecrypt($enc) {
    $key1 = preg_replace("/\/.+/", "", $enc);
    $key2 = preg_replace("/.+\//", "", $enc);
    $key = $key2.$key1;
    $key = hex2bin($key);
    $enc = str_replace($key1."/", "", $enc);
    $enc = str_replace("/".$key2, "", $enc);
    return openssl_decrypt($enc, 'aes-128-cbc', $key);
}
/*
$enc = passwordCrypt($pw, openssl_random_pseudo_bytes(32));
echo $enc."\n";
$dec = passwordDecrypt($enc);
echo $dec."\n";
*/