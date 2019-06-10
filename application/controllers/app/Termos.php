<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Termos extends CI_Controller {
	function __construct() {
        parent::__construct();
        $logged = $this->nativesession->get('logged');
        if (!isset($logged) || $logged != true) {
            redirect(base_url('/app/login/index'));
        }
    }
    public function index()
    {
        $dados["active"] = "cadastros";
        $dados["title"] = "Listagem de Termos do Site";
        $dados["list"] = Termo::where("status", "!=", "R")->get()->toArray();
        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/termos/index', $dados);
        $this->load->view('layout/app/footer');
    }
 

    public function editar() {

        $id = $this->uri->segment(4);

        if (is_null($id)) {
            redireciona(base_url("/app/termos/index"));
        }
        $dados          = Termo::where('id', "=", $id)->first()->toArray();
        $dados["title"] = "Editar Termo";
        $dados['id'] = $id;
        $dados['active'] = 'cadastros';
        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/termos/add', $dados);
        $this->load->view('layout/app/footer');
    }



    public function update() {
        $dados["active"] = "cadastros";
        $dados["title"] = "Editar Termo";
         if ($this->input->post()) {

            $retorno = $this->valida($this->input->post());

            if (isset($retorno["msg"]) && count($retorno["msg"]) > 0) {
                $dados             = $this->input->post();
                $dados["active"] = "cadastros";
                $dados["msg_erro"] = $retorno["msg"];
                $dados["title"]    = "Editar Termo";
                $this->load->view('layout/app/header', $dados);
                $this->load->view('layout/app/menu', $dados);
                $this->load->view('app/termos/add', $dados);
                $this->load->view('layout/app/footer');
            } else {

                $dadosSave                  = $this->input->post();
                $dados                      = Termo::where('id', "=", $dadosSave["id"])->first()->toArray();
                $termo                     = Termo::find($dadosSave["id"]);
                $termo->nome               = $dadosSave["nome"];
                $termo->conteudo           = $dadosSave["conteudo"];
                $termo->status             = $dadosSave["status"];
                $termo->meta_title         = $dadosSave["meta_title"];
                $termo->meta_description   = $dadosSave["meta_description"];
                $termo->meta_key           = $dadosSave["meta_key"];
                $termo->id_club            = 1;
                $ok                        = $termo->save();
                if ($ok) {
                    $dados["active"] = "cadastros";
                    $dados["msg_success"]   = ["Termo atualizado com sucesso"];
                    $dados["title"]         = "Editar Termo";
                    $this->load->view('layout/app/header', $dados);
                    $this->load->view('layout/app/menu', $dados);
                    $this->load->view('app/termos/add', $dados);
                    $this->load->view('layout/app/footer');
                    redireciona(base_url("/app/termos/index"),1);
                }
            }
        } else {
            redirect('/app/termos/index');
        }
    }

    public function valida($dados)
    {
        $msg_erro = [];
        if (strlen($dados["nome"]) == 0) {
            $msg_erro['msg'][] = "O campo NOME DO TERMO é obrigatório";
        }
        if (strlen($dados["conteudo"]) == 0) {
            $msg_erro['msg'][] = "O campo CONTEÚDO é obrigatório";
        }
        return $msg_erro;
    }

    public function status() {
        $data['active'] = 'cadastros';
        
        $id = $this->uri->segment(4);
        
        if (is_null($id)) {
            redireciona("/app/termos/index");
        }
        $retorno = Termo::where("id", "=", $id)->first()->toArray();
        if ($retorno["status"] == "N") {
            $novoStatus = "S";
        } else {
            $novoStatus = "N";
        }
        $user = Termo::find($id);
        $user->status   = $novoStatus;
        $ok = $user->save();
        if ($ok) {
            redireciona(base_url("/app/termos/index"));
        } else {
            redireciona(base_url("/app/termos/index"));
        }

    }

}

