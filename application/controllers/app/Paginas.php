<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paginas extends CI_Controller {
	function __construct() {
        parent::__construct();
        $logged = $this->nativesession->get('logged');
        if (!isset($logged) || $logged != true) {
            redirect(base_url('/app/login/index'));
        }
        $this->load->model('pagina');
    }
    /*
    ** METODO RESPONSAVEL POR  LISTAR PAGINAS
    **
    */
    public function index()
    {
        $dados["active"] = "paginas";
        $dados["title"]  = "Listagem de Páginas Estáticas";
        $dados["list"]   = Pagina::where("status", "!=", "E")->get()->toArray();
        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/paginas/index', $dados);
        $this->load->view('layout/app/footer');
    }
    /*
    ** METODO RESPONSAVEL POR CRIAR A TELA DE EDIÇÃO PAGINA
    **
    */
    public function edit() {

        $id = $this->uri->segment(4);

        if (is_null($id)) {
            redireciona(base_url("/app/paginas/index"));
        }
        $dados          = Pagina::where([['id', "=", $id],['status', "!=", "E"]])->first()->toArray();
        $dados["title"] = "Editar Página";
        $dados['id'] = $id;
        $dados['active'] = 'cadastros';
        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/paginas/add', $dados);
        $this->load->view('layout/app/footer');
    }
    /*
    ** METODO RESPONSAVEL POR GRAVAR A EDIÇÃO DA PAGINA
    **
    */
    public function update() {

        if ($this->input->post()) {

            $validaCamposVazios = $this->valida($this->input->post());

            if (isset($validaCamposVazios["msg"]) && count($validaCamposVazios["msg"]) > 0) {
                $dados             = $this->input->post();
                $dados["msg_erro"] = $validaCamposVazios["msg"];
              
            } else {

                $dadosSave           = $this->input->post();
                $update              = Pagina::find($dadosSave["id"]);
                $update->nome_pagina = $dadosSave["nome_pagina"];
                $update->conteudo    = $dadosSave["conteudo"];
                $update->status      = $dadosSave["status"];
                $response            = $update->save();
                if ($response) {
                    $dados = Pagina::where([['id', "=", $dadosSave["id"]],['status', "!=", "E"]])->first()->toArray();
                    $dados["msg_success"]   = ["Página atualizada com sucesso"];
                }
            }
        } 

        $dados["title"]    = "Editar Página";
        $dados["active"]   = "paginas";
        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/paginas/add', $dados);
        $this->load->view('layout/app/footer');
    }

    /*
    ** METODO RESPONSAVEL PELA VALIDAÇÃO DE CAMPOS OBRIGATÓRIOS
    **
    */

    public function valida($dados)
    {
        $msg_erro = [];
        if (strlen($dados["nome_pagina"]) == 0) {
            $msg_erro['msg'][] = "O campo NOME DA PAGINA é obrigatório";
        }
        if (strlen($dados["conteudo"]) == 0) {
            $msg_erro['msg'][] = "O campo CONTEÚDO é obrigatório";
        }
        return $msg_erro;
    }
    /*
    ** METODO RESPONSAVEL POR ATIVAR E INATIVAR FORMAS
    **
    */

    public function status() {
        $data['active'] = 'paginas';
        $id = $this->uri->segment(4);
        if (is_null($id)) {
            redireciona("/app/paginas/index");
        }
        $retorno = Pagina::where("id", "=", $id)->first()->toArray();
        if ($retorno["status"] == "I") {
            $novoStatus = "A";
        } else {
            $novoStatus = "I";
        }
        $update           = Pagina::find($id);
        $update->status   = $novoStatus;
        $response         = $update->save();
        if ($response) {
            redireciona(base_url("/app/paginas/index"));
        } else {
            redireciona(base_url("/app/paginas/index"));
        }

    }
    

}

