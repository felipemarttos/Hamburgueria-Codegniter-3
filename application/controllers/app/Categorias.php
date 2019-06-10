<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categorias extends CI_Controller {
    function __construct() {
        parent::__construct();
        $logged = $this->nativesession->get('logged');
        if (!isset($logged) || $logged != true) {
            redirect(base_url('/app/login/index'));
        }
         $this->load->model('categoria');
    }
    /*
    ** METODO RESPONSAVEL PELA LISTAGEM DAS CATEGORIAS
    **
    */
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

    /*
    ** METODO RESPONSAVEL PELA CRIAÇÃO DA TELA DE CADASTRO DAS CATEGORIAS
    **
    */
    public function add()
    {
        $dados["active"] = "categorias";
        $dados["title"]  = "Nova Categoria";
        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/categorias/add', $dados);
        $this->load->view('layout/app/footer');
    }

    /*
    ** METODO RESPONSAVEL PELA CRIAÇÃO DA TELA DE EDIÇÃO DAS CATEGORIAS
    **
    */

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

    /*
    ** METODO RESPONSAVEL PELA GRAVAÇÃO DE EDIÇÃO DAS CATEGORIAS
    **
    */

    public function update() {

        $msg_erro       = [];
        $msg_success    = [];  
        $dados          = [];  

        if ($this->input->post()) {
            $dadosSave = $this->input->post();
            $validaCamposVazios = $this->valida($dadosSave, false);

            if (isset($validaCamposVazios["msg"]) && count($validaCamposVazios["msg"]) > 0) {
                $msg_erro = $validaCamposVazios["msg"];
            } else {

                $validaDuplicado = Categoria::where([["nome", "=", $dadosSave["nome"]], ['id', "!=", $dadosSave["id"]]])->first();
                if (!empty($validaDuplicado)) {
                    $msg_erro = ["Já existe uma Categoria cadastrada com esse nome"];

                } else {
                    $update           = Categoria::find($dadosSave["id"]);
                    $update->nome     = $dadosSave["nome"];
                    $update->ordem    = $dadosSave["ordem"];
                    $update->status   = $dadosSave["status"];
                    $response       = $update->save();
                    if ($response) {
                        $msg_success   = ["Categoria atualizada com sucesso"];
                    }
                }
            }

            $dados                  = Categoria::where("id", "=", $dadosSave["id"])->first()->toArray();
            $dados["active"]        = "categorias";
            $dados["title"]         = "Editar Categoria";
            $dados["msg_success"]   = $msg_success;
            $dados["msg_erro"]      = $msg_erro;

            $this->load->view('layout/app/header', $dados);
            $this->load->view('layout/app/menu', $dados);
            $this->load->view('app/categorias/add', $dados);
            $this->load->view('layout/app/footer');
            redireciona(base_url("/app/categorias/index"),1);

        } else {
            redirect('/app/categorias/index');
        }
    }
    /*
    ** METODO RESPONSAVEL PELA GRAVAÇÃO DE INSERÇÃO DAS CATEGORIAS
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

                $validaDuplicado        = Categoria::where("nome", "=", $dadosSave["nome"])->first();

                if (!empty($validaDuplicado)) {
                   
                    $msg_erro = ["Já existe uma Categoria cadastrado com esse nome"];

                } else {
                    $insert           = new Categoria;
                    $insert->nome     = $dadosSave["nome"];
                    $insert->ordem    = $dadosSave["ordem"];
                    $insert->status   = $dadosSave["status"];
                    $response         = $insert->save($dadosSave);
                    if ($response) {
                        unset($dados);
                        $msg_success   = ["Categoria cadastrado com sucesso"];
                    }
                }
            }

            $dados["active"]        = "categorias";
            $dados["title"]         = "Nova Categoria";
            $dados["msg_success"]   = $msg_success;
            $dados["msg_erro"]      = $msg_erro;

            $this->load->view('layout/app/header', $dados);
            $this->load->view('layout/app/menu', $dados);
            $this->load->view('app/categorias/add', $dados);
            $this->load->view('layout/app/footer');
        } else {
            redirect('/app/categorias/index');
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
        if (strlen($dados["ordem"]) == 0) {
            $msg_erro['msg'][] = "O campo ORDEM é obrigatório";
        }
        return $msg_erro;
    }

    /*
    ** METODO RESPONSAVEL POR ATIVAR E INATIVAR CATEGORIAS
    **
    */

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
    /*
    ** METODO RESPONSAVEL POR REMOVER CATEGORIAS
    **
    */

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
