<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FormasPagamentos extends CI_Controller {
    function __construct() {
        parent::__construct();
        $logged = $this->nativesession->get('logged');
        if (!isset($logged) || $logged != true) {
            redirect(base_url('/app/login/index'));
        }
         $this->load->model('formaPagamento');
    }

    /*
    ** METODO RESPONSAVEL PELA LISTAGEM DAS FORMAS
    **
    */

    public function index()
    {
        $dados["active"] = "formasPagamentos";
        $dados["title"]  = "Listagem de Formas de Pagamentos";
        $dados["list"]   = FormaPagamento::where("status", "!=", "E")->get()->toArray();
        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/formas_pagamentos/index', $dados);
        $this->load->view('layout/app/footer');
    }

    /*
    ** METODO RESPONSAVEL PELA CRIAÇÃO DA TELA DE CADASTRO DAS FORMAS
    **
    */
    public function add()
    {
        $dados["active"] = "formasPagamentos";
        $dados["title"]  = "Nova Forma";
        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/formas_pagamentos/add', $dados);
        $this->load->view('layout/app/footer');
    }

    /*
    ** METODO RESPONSAVEL PELA CRIAÇÃO DA TELA DE EDIÇÃO DAS FORMAS
    **
    */
    public function edit() {

        $id = $this->uri->segment(4);

        if (is_null($id)) {
            redireciona(base_url("/app/formasPagamentos/index"));
        }
        $dados           = FormaPagamento::where('id', "=", $id)->first()->toArray();
        $dados["title"]  = "Editar Forma";
        $dados['id']     = $id;
        $dados['active'] = 'formasPagamentos';
        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/formas_pagamentos/add', $dados);
        $this->load->view('layout/app/footer');
    }

    /*
    ** METODO RESPONSAVEL PELA GRAVAÇÃO DE EDIÇÃO DAS FORMAS
    **
    */
    public function update() {

        $msg_erro       = [];
        $msg_success    = [];  
        $dados          = [];  
         if ($this->input->post()) {
            $dadosSave = $this->input->post();
            $validaCamposVazios = $this->valida($this->input->post(), false);

            if (isset($validaCamposVazios["msg"]) && count($validaCamposVazios["msg"]) > 0) {
                $msg_erro = $validaCamposVazios["msg"];
            } else {
                $validaDuplicado = FormaPagamento::where([["nome", "=", $dadosSave["nome"]], ['id', "!=", $dadosSave["id"]]])->first();
                if (!empty($validaDuplicado)) {
                    $msg_erro = ["Já existe um Forma cadastrado com esse nome"];
                } else {

                    $update           = FormaPagamento::find($dadosSave["id"]);
                    $update->nome     = $dadosSave["nome"];
                    $update->status   = $dadosSave["status"];
                    if (isset($_FILES["imagem"]["name"]) && strlen($_FILES["imagem"]["name"]) > 0) {
                        $update->imagem = $this->uploadFoto();
                    }
                    $response         = $update->save($dadosSave);
                    if ($response) {
                        $msg_success   = ["Forma atualizado com sucesso"];
                    }
                }
            }
            $dados                  = FormaPagamento::where("id", "=", $dadosSave["id"])->first()->toArray();
            $dados["active"]        = "formasPagamentos";
            $dados["title"]         = "Editar Forma";
            $dados["msg_success"]   = $msg_success;
            $dados["msg_erro"]      = $msg_erro;
            $this->load->view('layout/app/header', $dados);
            $this->load->view('layout/app/menu', $dados);
            $this->load->view('app/formas_pagamentos/add', $dados);
            $this->load->view('layout/app/footer');
            redireciona(base_url("/app/formasPagamentos/index"),1);
        } else {
            redirect('/app/formasPagamentos/index');
        }
    }

    /*
    ** METODO RESPONSAVEL PELA GRAVAÇÃO DE INSERÇÃO DAS FORMAS
    **
    */

    public function create()
    {
        $msg_erro       = [];
        $msg_success    = [];  
        $dados          = []; 
        if ($this->input->post()) {
            $dadosSave = $this->input->post();
            $dados    = $this->input->post();
            $validaCamposVazios = $this->valida($dadosSave);

            if (isset($validaCamposVazios["msg"]) && count($validaCamposVazios["msg"]) > 0) {
                $msg_erro  = $validaCamposVazios["msg"];
            } else {

                $validaDuplicado        = FormaPagamento::where("nome", "=", $dadosSave["nome"])->first();
                if (!empty($validaDuplicado)) {
                    $msg_erro = ["Já existe um Forma cadastrado com esse nome"];
                } else {
                    $insert           = new FormaPagamento;
                    $insert->nome     = $dadosSave["nome"];
                    $insert->status   = $dadosSave["status"];
                    if (isset($_FILES["imagem"]["name"]) && strlen($_FILES["imagem"]["name"]) > 0) {
                        $insert->imagem = $this->uploadFoto();
                    }
                    $response         = $insert->save($dadosSave);
                    if ($response) {
                        unset($dados);
                        $msg_success   = ["Forma cadastrada com sucesso"];
                    }
                }
            }

            $dados["title"]         = "Nova Forma";
            $dados["active"]        = "formasPagamentos";
            $dados["msg_success"]   = $msg_success;
            $dados["msg_erro"]      = $msg_erro;
            $this->load->view('layout/app/header', $dados);
            $this->load->view('layout/app/menu', $dados);
            $this->load->view('app/formas_pagamentos/add', $dados);
            $this->load->view('layout/app/footer');

        } else {
            redirect('/app/formasPagamentos/index');
        }
    }

    /*
    ** METODO RESPONSAVEL PELA VALIDAÇÃO DE CAMPOS OBRIGATÓRIOS
    **
    */

    public function valida($dados, $insert = true)
    {
        $msg_erro = [];
        if (strlen($dados["nome"]) == 0) {
            $msg_erro['msg'][] = "O campo NOME é obrigatório";
        }
        return $msg_erro;
    }

    /*
    ** METODO RESPONSAVEL POR ATIVAR E INATIVAR FORMAS
    **
    */

    public function status() {
        $data['active'] = 'formasPagamentos';
        $id = $this->uri->segment(4);
        if (is_null($id)) {
            redireciona("/app/formasPagamentos/index");
        }
        $retorno = FormaPagamento::where("id", "=", $id)->first()->toArray();
        if ($retorno["status"] == "I") {
            $novoStatus = "A";
        } else {
            $novoStatus = "I";
        }
        $update           = FormaPagamento::find($id);
        $update->status   = $novoStatus;
        $response         = $update->save();
        if ($response) {
            redireciona(base_url("/app/formasPagamentos/index"));
        } else {
            redireciona(base_url("/app/formasPagamentos/index"));
        }

    }
    /*
    ** METODO RESPONSAVEL POR REMOVER FORMAS
    **
    */

    public function delete() {
        $data['active'] = 'formasPagamentos';
        $id = $this->uri->segment(4);
        if (is_null($id)) {
            redireciona("/app/formasPagamentos/index");
        }
        $update           = FormaPagamento::find($id);
        $update->status   = "E";
        $response         = $update->save();
        if ($response) {
            redireciona(base_url("/app/formasPagamentos/index"));
        } else {
            redireciona(base_url("/app/formasPagamentos/index"));
        }

    }
    /*
    ** METODO RESPONSAVEL POR FAZER O UPLOAD DA IMAGEM PARA SERVIDOR
    **
    */

    public function uploadFoto() {
        $pasta = 'asset/img/formas/';
        if ($_FILES["imagem"]["error"] == UPLOAD_ERR_OK) {
            $tmp_name   = $_FILES["imagem"]["tmp_name"];
            $nome_foto  = date('dmy') . '_formas_' . $_FILES["imagem"]["name"];
            $uploadfile = $pasta . basename($nome_foto);
            if (move_uploaded_file($tmp_name, $uploadfile)) {
                return $nome_foto;
            }
        }
    }
}
