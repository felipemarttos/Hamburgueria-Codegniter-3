<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contato extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->model('configuracao');
        $this->load->model('expediente');
        $this->load->library('email');
    }

	public function index()
	{

        if ($this->input->post()) {
            $dados             = $this->input->post();
            $validaCamposVazios = $this->valida($dados);
            if (isset($validaCamposVazios["msg"]) && count($validaCamposVazios["msg"]) > 0) {

                $dados["msg_erro"] = $validaCamposVazios["msg"];

            } else {

                $corpo = $this->montaMensagem($dados);
  
                $configuracoes = Configuracao::first()->toArray();

                $this->email->from('noreply2@onsistemas.com.br');
                $this->email->to($configuracoes["email"]);
                $this->email->subject("Fale conosco via site - " . $dados["assunto"]);
                $this->email->message($corpo);
                
                if ($this->email->send()) {
                    unset($dados);
                    $dados["msg_success"]   = ["Mensagem enviada com sucesso"];
                } else {
                    $dados["msg_erro"] = ["Erro ao enviar mensagem"];
                }
            }
        }

        $dados["title"]   = "Fale Conosco";
        $dados["active"]  = "contato";

        $dados["configuracoes"] = Configuracao::first()->toArray();
        $dados["expedientes"]   = Expediente::first()->toArray();

		$this->load->view('layout/site/header', $dados);
		$this->load->view('layout/site/menu', $dados);
        $this->load->view('site/contato/index', $dados);
        $this->load->view('layout/site/footer');
	}

    public function montaMensagem($dados)
    {

        $corpo  = "Nome: ".$dados["nome"]."<br>";
        $corpo .= "E-mail: ".$dados["email"]."<br>";
        $corpo .= "Telefone: ".$dados["telefone"]."<br>";
        $corpo .= "Assunto: ".$dados["assunto"]."<br>";
        $corpo .= "Mensagem: ".$dados["texto"]."<br>";
        return $corpo;
    }

    public function valida($dados)
    {

        $msg_erro = [];
        if (strlen($dados["nome"]) == 0) {
            $msg_erro['msg'][] = "O campo NOME é obrigatório";
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
        if (strlen($dados["assunto"]) == 0) {
            $msg_erro['msg'][] = "O campo ASSUNTO é obrigatório";
        }
        if (strlen($dados["texto"]) == 0) {
            $msg_erro['msg'][] = "O campo MENSAGEM é obrigatório";
        }
    
        return $msg_erro;
    }


}
