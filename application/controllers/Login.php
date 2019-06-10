<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	function __construct() {
        parent::__construct();
         $this->load->model('configuracao');
         $this->load->model('expediente');
         $this->load->model('cliente');
    }

   	public function index()
    {

        $dados = $this->input->post();
        if ($this->input->post()) {

            $validaCamposVazios = $this->valida($dados);

            if (isset($validaCamposVazios["msg"]) && count($validaCamposVazios["msg"]) > 0) {

            	$this->nativesession->set('error', implode("<br>", $validaCamposVazios["msg"]));
                redirect('login/index');

            } else {

                $cliente = Cliente::where([
                                        ["status", "=", "A"],
                                        ["email",  "=", $this->input->post('username')],
                                        ["senha",  "=", md5(trim($this->input->post('password')))],
                                    ])->first();

                if (!empty($cliente)) {
                    
                    $cliente      = $cliente->toArray();
                  
                    $_SESSION["cliente"]["username"] = $cliente["nome"];
                    $_SESSION["cliente"]["id"]       = $cliente["id"];
                    $_SESSION["cliente"]["nome"]     = $cliente["nome"];
                    $_SESSION["cliente"]["email"]    = $cliente["email"];
                    $_SESSION["cliente"]["telefone"] = $cliente["telefone"];
                    $_SESSION["cliente"]["logged"]   = true;
                    redirect('/clientes/index');
                } else {
                    $this->nativesession->set('error', 'E-mail não encontrado.');
                    redirect('login/index');
                }

            }
        } else {
	        $dados["title"]  		= "Login";
	        $dados["active"] 		= "dashboard";
			$dados["configuracoes"] = Configuracao::first()->toArray();
			$dados["expedientes"] 	= Expediente::first()->toArray();

			$this->load->view('layout/site/header', $dados);
			$this->load->view('layout/site/menu', $dados);
	        $this->load->view('site/login/index', $dados);
	        $this->load->view('layout/site/footer');
        }
    }

    public function valida($dados)
    {
        $msg_erro = [];

        if (strlen($dados["username"]) == 0) {
            $msg_erro['msg'][] = "O campo E-MAIL é obrigatório";
        } else {
            if (!validaEmail($dados["username"])) {
                $msg_erro['msg'][] = "O campo E-MAIL é invalido";
            }
        }
        if (strlen($dados["password"]) == 0) {
            $msg_erro['msg'][] = "O campo SENHA é obrigatório";
        }
        return $msg_erro;
    }

    public function logout() {
        session_destroy();
        redirect('/login/index');
    }

}