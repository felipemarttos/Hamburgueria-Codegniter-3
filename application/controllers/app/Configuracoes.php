<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configuracoes extends CI_Controller {
    function __construct() {
        parent::__construct();
        $logged = $this->nativesession->get('logged');
        if (!isset($logged) || $logged != true) {
            redirect(base_url('/app/login/index'));
        }
         $this->load->model('configuracao');
    }

    /*
    ** METODO RESPONSAVEL PELA CRIAÇÃO DA TELA E GRAVAÇÃO DAS CONFIGURAÇÕES
    **
    */
    public function index()
    {
        $msg_erro       = [];
        $msg_success    = [];  
        $dados          = [];  

        if ($this->input->post()) {
            $dadosSave = $this->input->post();
            $validaCamposVazios = $this->valida($dadosSave);

            if (isset($validaCamposVazios["msg"]) && count($validaCamposVazios["msg"]) > 0) {
                $msg_erro = $validaCamposVazios["msg"];
            } else {

                $update                     = Configuracao::find(1);
                $update->nome_site          = $dadosSave["nome_site"];
                $update->nome_empresa       = $dadosSave["nome_empresa"];
                $update->responsavel        = $dadosSave["responsavel"];
                $update->cnpj               = $dadosSave["cnpj"];
                $update->google_analitcs    = $dadosSave["google_analitcs"];
                $update->email              = $dadosSave["email"];
                $update->telefone           = $dadosSave["telefone"];
                $update->whatsapp           = $dadosSave["whatsapp"];
                $update->instagram          = $dadosSave["instagram"];
                $update->facebook           = $dadosSave["facebook"];
                $update->youtube            = $dadosSave["youtube"];
                $update->expediente         = $dadosSave["expediente"];
                $update->endereco           = $dadosSave["endereco"];
                $update->tempo_entrega      = $dadosSave["tempo_entrega"];
                $update->taxa_entrega       = $dadosSave["taxa_entrega"];
                $response                   = $update->save();
                if ($response) {
                    $msg_success   = ["Configurações atualizada com sucesso"];
                }
            }
        } 
        $dados           = Configuracao::find(1)->toArray();
        $dados["active"] = "configuracao";
        $dados["title"]  = "Configurações gerais";
        $dados["msg_success"]  = $msg_success;
        $dados["msg_erro"]  = $msg_erro;

        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/configuracao/index', $dados);
        $this->load->view('layout/app/footer');
    }
 
     /*
    ** METODO RESPONSAVEL PELA VALIDAÇÃO DE CAMPOS OBRIGATÓRIOS
    **
    */
    public function valida($dados, $insert = true)
    {
        $msg_erro = [];
        if (strlen($dados["nome_site"]) == 0) {
            $msg_erro['msg'][] = "O campo NOME DO SITE é obrigatório";
        }

        if (strlen($dados["email"]) == 0) {
            $msg_erro['msg'][] = "O campo E-MAIL é obrigatório";
        } else {
            if (!validaEmail($dados["email"])) {
                $msg_erro['msg'][] = "O campo E-MAIL é invalido";
            }
        }

        if (strlen($dados["telefone"]) == 0) {
            $msg_erro['msg'][] = "O campo TELEFONE é obrigatório";
        }
        if (strlen($dados["nome_empresa"]) == 0) {
            $msg_erro['msg'][] = "O campo NOME DA EMPRESA é obrigatório";
        }
        return $msg_erro;
    }


}
