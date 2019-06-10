<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Parceiros extends CI_Controller {
	function __construct() {
        parent::__construct();
        $logged = $this->nativesession->get('logged');
        if (!isset($logged) || $logged != true) {
            redirect(base_url('/app/login/index'));
        }
    }
    public function index()
    {
        $dados["active"] = "assinatura";
        $dados["title"] = "Listagem de Parceiros";
        $dados["list"] = Parceiro::where("status", "!=", "R")->get()->toArray();
        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/parceiros/index', $dados);
        $this->load->view('layout/app/footer');
    }
    public function add()
    {
        $dados["active"] = "assinatura";
        $dados["title"] = "Novo Parceiro";
        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/parceiros/add', $dados);
        $this->load->view('layout/app/footer');
    }

    public function editar() {

        $id = $this->uri->segment(4);

        if (is_null($id)) {
            redireciona(base_url("/app/parceiros/index"));
        }
        $dados          = Parceiro::where('id', "=", $id)->first()->toArray();
        $dados["title"] = "Editar Parceiro";
        $dados['id'] = $id;
        $dados['active'] = 'assinatura';
        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/parceiros/add', $dados);
        $this->load->view('layout/app/footer');
    }



    public function update() {
        $dados["active"] = "assinatura";
        $dados["title"] = "Editar Parceiro";
         if ($this->input->post()) {

            $retorno = $this->valida($this->input->post());

            if (isset($retorno["msg"]) && count($retorno["msg"]) > 0) {
                $dados             = $this->input->post();
                $dados["active"] = "assinatura";
                $dados["msg_erro"] = $retorno["msg"];
                $dados["title"]    = "Editar  Parceiro";
                $this->load->view('layout/app/header', $dados);
                $this->load->view('layout/app/menu', $dados);
                $this->load->view('app/parceiros/add', $dados);
                $this->load->view('layout/app/footer');
            } else {

                $dadosSave      = $this->input->post();
                $dados          = Parceiro::where('id', "=", $dadosSave["id"])->first()->toArray();
                $retorno        = Parceiro::where([["cpf_cnpj", "=", $dadosSave["cpf_cnpj"]], ['id', "!=", $dadosSave["id"]]])->first();
                if (!empty($retorno)) {
                    $retorno = $retorno->toArray();
                    $dados["active"] = "assinatura";
                    $dados             = $this->input->post();
                    $dados["msg_erro"] = ["Já existe um Parceiro cadastrado com esse CPF/CNPJ"];
                    $dados["title"]    = "Editar  Parceiro";
                    $this->load->view('layout/app/header', $dados);
                    $this->load->view('layout/app/menu', $dados);
                    $this->load->view('app/parceiros/add', $dados);
                    $this->load->view('layout/app/footer');
                    redireciona(base_url("/app/parceiros/index"),1);
                } else {

                    $linha                   = Parceiro::find($dadosSave["id"]);
                    $linha->nome             = $dadosSave["nome"];
                    $linha->email            = $dadosSave["email"];
                    $linha->status           = $dadosSave["status"];
                    $linha->fone             = $dadosSave["fone"];
                    $linha->celular          = $dadosSave["celular"];
                    $linha->nome_contato     = $dadosSave["nome_contato"];
                    $linha->cep              = $dadosSave["cep"];
                    $linha->endereco         = $dadosSave["endereco"];
                    $linha->numero           = $dadosSave["numero"];
                    $linha->bairro           = $dadosSave["bairro"];
                    $linha->cidade           = $dadosSave["cidade"];
                    $linha->uf               = $dadosSave["uf"];
                    $linha->obs              = $dadosSave["obs"];
                    $linha->rg               = $dadosSave["rg"];
                    $linha->cpf_cnpj         = $dadosSave["cpf_cnpj"];
                    $linha->tipo         = $dadosSave["tipo"];
                    $linha->id_club          = 1;
                    $linha->senha            = md5(trim($dadosSave["senha"]));

                    if ($_FILES["imagem"]["error"] == 0) {
                        $imagem =  $this->uploadFoto();
                        $linha->imagem   = $imagem;
                    }
                    $ok             = $linha->save($dadosSave);
                    if ($ok) {
                        $dados["active"] = "assinatura";
                        $dados["msg_success"]   = ["Parceiro atualizado com sucesso"];
                        $dados["title"]         = "Editar Parceiro";
                        $this->load->view('layout/app/header', $dados);
                        $this->load->view('layout/app/menu', $dados);
                        $this->load->view('app/parceiros/add', $dados);
                        $this->load->view('layout/app/footer');
                        redireciona(base_url("/app/parceiros/index"),1);
                    }
                }
            }
        } else {
            redirect('/app/parceiros/index');
        }
    }

    public function create()
    {
        $dados["active"] = "assinatura";
        $dados["title"] = "Novo Parceiro";

        if ($this->input->post()) {

            $retorno = $this->valida($this->input->post());

            if (isset($retorno["msg"]) && count($retorno["msg"]) > 0) {
                $dados             = $this->input->post();
                $dados["msg_erro"] = $retorno["msg"];
                $dados["title"]    = "Novo Parceiro";
                $dados["active"] = "assinatura";
                $this->load->view('layout/app/header', $dados);
                $this->load->view('layout/app/menu', $dados);
                $this->load->view('app/parceiros/add', $dados);
                $this->load->view('layout/app/footer');
            } else {

                $dadosSave      = $this->input->post();
                $retorno = Parceiro::where("cpf_cnpj", "=", $dadosSave["cpf_cnpj"])->first();
                if (!empty($retorno)) {
                    $retorno = $retorno->toArray();
                    $dados             = $this->input->post();
                    $dados["msg_erro"] = ["Já existe um Parceiro cadastrado com esse CPF/CNPJ"];
                    $dados["title"]    = "Novo Parceiro";
                    $this->load->view('layout/app/header', $dados);
                    $this->load->view('layout/app/menu', $dados);
                    $this->load->view('app/parceiros/add', $dados);
                    $this->load->view('layout/app/footer'); 
                    redireciona(base_url("/app/parceiros/index"),1);

                } else {

                    $linha                   = new Parceiro;
                    $linha->nome             = $dadosSave["nome"];
                    $linha->email            = $dadosSave["email"];
                    $linha->status           = $dadosSave["status"];
                    $linha->fone             = $dadosSave["fone"];
                    $linha->celular          = $dadosSave["celular"];
                    $linha->nome_contato     = $dadosSave["nome_contato"];
                    $linha->cep              = $dadosSave["cep"];
                    $linha->endereco         = $dadosSave["endereco"];
                    $linha->numero           = $dadosSave["numero"];
                    $linha->bairro           = $dadosSave["bairro"];
                    $linha->cidade           = $dadosSave["cidade"];
                    $linha->uf               = $dadosSave["uf"];
                    $linha->obs              = $dadosSave["obs"];
                    $linha->rg               = $dadosSave["rg"];
                    $linha->tipo         = $dadosSave["tipo"];
                    $linha->cpf_cnpj         = $dadosSave["cpf_cnpj"];
                    $linha->id_club          = 1;
                    $linha->senha            = md5(trim($dadosSave["senha"]));
                    if ($_FILES["imagem"]["error"] == 0) {
                        $imagem =  $this->uploadFoto();
                        $linha->imagem   = $imagem;
                    }
                    $ok             = $linha->save($dadosSave);
                    if ($ok) {
                        $dados["msg_success"]   = ["Parceiro cadastrado com sucesso"];
                        $dados["title"]         = "Novo Parceiro";
                        $this->load->view('layout/app/header', $dados);
                        $this->load->view('layout/app/menu', $dados);
                        $this->load->view('app/parceiros/add', $dados);
                        $this->load->view('layout/app/footer');
                        redireciona(base_url("/app/parceiros/index"),1);
                    }
                }
            }
        } else {
            redirect('/app/parceiros/index');
        }
    }

    public function valida($dados)
    {
        $msg_erro = [];
        if (strlen($dados["tipo"]) == 0) {
            $msg_erro['msg'][] = "O campo TIPO é obrigatório";
        }
        if (strlen($dados["nome"]) == 0) {
            $msg_erro['msg'][] = "O campo NOME é obrigatório";
        }
        if (strlen($dados["email"]) == 0) {
            $msg_erro['msg'][] = "O campo E-MAIL é obrigatório";
        }
        if (strlen($dados["fone"]) == 0) {
            $msg_erro['msg'][] = "O campo TELEFONE é obrigatório";
        }
        if (strlen($dados["cpf_cnpj"]) == 0) {
            $msg_erro['msg'][] = "O campo CPF/CNPJ é obrigatório";
        }
        if (strlen($dados["nome_contato"]) == 0) {
            $msg_erro['msg'][] = "O campo NOME DO CONTATO é obrigatório";
        }
        if (strlen($dados["senha"]) == 0) {
            $msg_erro['msg'][] = "O campo SENHA é obrigatório";
        }
        if (strlen($dados["cep"]) == 0) {
            $msg_erro['msg'][] = "O campo CEP é obrigatório";
        }
        if (strlen($dados["endereco"]) == 0) {
            $msg_erro['msg'][] = "O campo ENDEREÇO é obrigatório";
        }
        if (strlen($dados["numero"]) == 0) {
            $msg_erro['msg'][] = "O campo NÚMERO é obrigatório";
        }
        if (strlen($dados["bairro"]) == 0) {
            $msg_erro['msg'][] = "O campo BAIRRO é obrigatório";
        }
        if (strlen($dados["cidade"]) == 0) {
            $msg_erro['msg'][] = "O campo CIDADE é obrigatório";
        }
        if (strlen($dados["uf"]) == 0) {
            $msg_erro['msg'][] = "O campo UF é obrigatório";
        }
        return $msg_erro;
    }


    public function uploadFoto() {
        $pasta = 'assets/template/images/';
        if ($_FILES["imagem"]["error"] == UPLOAD_ERR_OK) {
            $tmp_name   = $_FILES["imagem"]["tmp_name"];
            $nome_foto  = date('dmy') . '_parceiro_' . $_FILES["imagem"]["name"];
            $uploadfile = $pasta . basename($nome_foto);
            if (move_uploaded_file($tmp_name, $uploadfile)) {
                return $nome_foto;
            }
        }
    }

    public function status() {
        $data['active'] = 'assinatura';
        
        $id = $this->uri->segment(4);
        
        if (is_null($id)) {
            redireciona("/app/parceiros/index");
        }
        $retorno = Parceiro::where("id", "=", $id)->first()->toArray();
        if ($retorno["status"] == "N") {
            $novoStatus = "S";
        } else {
            $novoStatus = "N";
        }
        $user = Parceiro::find($id);
        $user->status   = $novoStatus;
        $ok = $user->save();
        if ($ok) {
            redireciona(base_url("/app/parceiros/index"));
        } else {
            redireciona(base_url("/app/parceiros/index"));
        }

    }

    public function remover() {
        $data['active'] = 'assinatura';
        
        $id = $this->uri->segment(4);
        
        if (is_null($id)) {
            redireciona("/app/parceiros/index");
        }
        $novoStatus = "R";
        $user = Parceiro::find($id);
        $user->status   = $novoStatus;
        $ok = $user->save();
        if ($ok) {
            redireciona(base_url("/app/parceiros/index"));
        } else {
            redireciona(base_url("/app/parceiros/index"));
        }

    }

}

