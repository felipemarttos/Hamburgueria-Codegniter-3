<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categorias extends CI_Controller {
    function __construct() {
        parent::__construct();
        $logged = $this->nativesession->get('logged');
        if (!isset($logged) || $logged != true) {
            redirect(base_url('/app/login/index'));
        }
    }

    public function index()
    {
        $dados["active"] = "categorias";
        $dados["title"]  = "Listagem de Categorias";
        $dados["list"]   = Categoria::where("status", "!=", "E")->get()->toArray();
        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/categorias/index', $dados);
        $this->load->view('layout/app/footer');
    }
    public function add()
    {
        $dados["active"] = "categorias";
        $dados["title"]  = "Nova Categoria";
        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/categorias/add', $dados);
        $this->load->view('layout/app/footer');
    }

    public function edit() {

        $id = $this->uri->segment(4);

        if (is_null($id)) {
            redireciona(base_url("/app/categorias/index"));
        }
        $dados           = Categoria::where('id', "=", $id)->first()->toArray();
        $dados["title"]  = "Editar Categoria";
        $dados['id']     = $id;
        $dados['active'] = 'categorias';
        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/categorias/add', $dados);
        $this->load->view('layout/app/footer');
    }

    public function update() {
        $dados["title"]  = "Editar Categoria";
         if ($this->input->post()) {

            $validaCamposVazios = $this->valida($this->input->post(), false);

            if (isset($validaCamposVazios["msg"]) && count($validaCamposVazios["msg"]) > 0) {
                $dados             = $this->input->post();
                $dados["msg_erro"] = $validaCamposVazios["msg"];
                $dados["title"]    = "Editar  Categoria";
                $dados["active"]   = "categorias";

                $this->load->view('layout/app/header', $dados);
                $this->load->view('layout/app/menu', $dados);
                $this->load->view('app/categorias/add', $dados);
                $this->load->view('layout/app/footer');
            } else {

                $dadosSave       = $this->input->post();
                $dados           = Categoria::where('id', "=", $dadosSave["id"])->first()->toArray();
                $validaDuplicado = Categoria::where([["nome", "=", $dadosSave["nome"]], ['id', "!=", $dadosSave["id"]]])->first();
                if (!empty($validaDuplicado)) {
                    $dados             = $this->input->post();
                    $dados["msg_erro"] = ["Já existe uma Categoria cadastrada com esse nome"];
                    $dados["title"]    = "Editar Categoria";
                    $dados["active"]   = "categorias";
                    $this->load->view('layout/app/header', $dados);
                    $this->load->view('layout/app/menu', $dados);
                    $this->load->view('app/categorias/add', $dados);
                    $this->load->view('layout/app/footer');


                } else {
                    $update           = Categoria::find($dadosSave["id"]);
                    $update->nome     = $dadosSave["nome"];
                    $update->ordem    = $dadosSave["ordem"];
                    $update->status   = $dadosSave["status"];
                    $response       = $update->save($dadosSave);
                    if ($response) {
                        $dados["msg_success"]   = ["Categoria atualizada com sucesso"];
                        $dados["active"]        = "categorias";
                        $dados["title"]         = "Editar Categoria";
                        $this->load->view('layout/app/header', $dados);
                        $this->load->view('layout/app/menu', $dados);
                        $this->load->view('app/categorias/add', $dados);
                        $this->load->view('layout/app/footer');
                         redireciona(base_url("/app/categorias/index"),1);
                    }
                }
            }
        } else {
            redirect('/app/categorias/index');
        }
    }

    public function create()
    {
       
        if ($this->input->post()) {

            $validaCamposVazios = $this->valida($this->input->post());

            if (isset($validaCamposVazios["msg"]) && count($validaCamposVazios["msg"]) > 0) {
                $dados              = $this->input->post();
                $dados["active"]    = "categorias";
                $dados["title"]     = "Nova Categoria";
                $dados["msg_erro"]  = $validaCamposVazios["msg"];
                $this->load->view('layout/app/header', $dados);
                $this->load->view('layout/app/menu', $dados);
                $this->load->view('app/categorias/add', $dados);
                $this->load->view('layout/app/footer');
            } else {

                $dadosSave              = $this->input->post();
                $validaDuplicado        = Categoria::where("nome", "=", $dadosSave["nome"])->first();
                if (!empty($validaDuplicado)) {
                    $dados             = $this->input->post();
                    $dados["msg_erro"] = ["Já existe uma Categoria cadastrado com esse nome"];
                    $dados["active"]   = "categorias";
                    $dados["title"]    = "Nova Categoria";
                    $this->load->view('layout/app/header', $dados);
                    $this->load->view('layout/app/menu', $dados);
                    $this->load->view('app/categorias/add', $dados);
                    $this->load->view('layout/app/footer');

                } else {
                    $insert           = new Categoria;
                    $insert->nome     = $dadosSave["nome"];
                    $insert->ordem    = $dadosSave["ordem"];
                    $insert->status   = $dadosSave["status"];
                    $response         = $insert->save($dadosSave);
                    if ($response) {
                        $dados["msg_success"]   = ["Categoria cadastrado com sucesso"];
                        $dados["title"]         = "Nova Categoria";
                        $dados["active"]        = "categorias";
                        $this->load->view('layout/app/header', $dados);
                        $this->load->view('layout/app/menu', $dados);
                        $this->load->view('app/categorias/add', $dados);
                        $this->load->view('layout/app/footer');
                        redireciona(base_url("/app/categorias/index"),1);
                    }
                }
            }
        } else {
            redirect('/app/categorias/index');
        }
    }

    public function valida($dados, $insert = true)
    {
        $msg_erro = [];
        if (strlen($dados["nome"]) == 0) {
            $msg_erro['msg'][] = "O campo NOME é obrigatório";
        }
        if (strlen($dados["ordem"]) == 0) {
            $msg_erro['msg'][] = "O campo ORDEM é obrigatório";
        }
        return $msg_erro;
    }

    public function status() {
        $data['active'] = 'categorias';
        $id = $this->uri->segment(4);
        if (is_null($id)) {
            redireciona("/app/categorias/index");
        }
        $retorno = Categoria::where("id", "=", $id)->first()->toArray();
        if ($retorno["status"] == "I") {
            $novoStatus = "A";
        } else {
            $novoStatus = "I";
        }
        $update           = Categoria::find($id);
        $update->status   = $novoStatus;
        $response         = $update->save();
        if ($response) {
            redireciona(base_url("/app/categorias/index"));
        } else {
            redireciona(base_url("/app/categorias/index"));
        }

    }

    public function delete() {
        $data['active'] = 'categorias';
        $id = $this->uri->segment(4);
        if (is_null($id)) {
            redireciona("/app/categorias/index");
        }
        $update           = Categoria::find($id);
        $update->status   = "E";
        $response         = $update->save();
        if ($response) {
            redireciona(base_url("/app/categorias/index"));
        } else {
            redireciona(base_url("/app/categorias/index"));
        }

    }

}
