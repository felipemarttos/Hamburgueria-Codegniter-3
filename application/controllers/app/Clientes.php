<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends CI_Controller {
    function __construct() {
        parent::__construct();
        $logged = $this->nativesession->get('logged');
        if (!isset($logged) || $logged != true) {
            redirect(base_url('/app/login/index'));
        }
    }

    public function index()
    {
        $dados["active"] = "clientes";
        $dados["title"]  = "Listagem de Clientes";
        if ($this->input->post()) {
            $dadosBusca = $this->input->post();
            if ($dadosBusca["tipo"] == "N") {
                $condBusca[] = ["nome", "LIKE", "%".$dadosBusca["campo_filtro"]."%"];
            }
            if ($dadosBusca["tipo"] == "T") {

                $condBusca[] = ["telefone", "=", $dadosBusca["campo_filtro"]];
            }
            $condBusca[] = ["status", "!=", "E"];




            $dados["list"]   = Cliente::where($condBusca)->get()->toArray();
        } else {
            $dados["list"]   = Cliente::where("status", "!=", "E")->get()->toArray();
        }
        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/clientes/index', $dados);
        $this->load->view('layout/app/footer');
    }
    public function add()
    {
        $dados["active"] = "clientes";
        $dados["title"]  = "Novo Cliente";
        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/clientes/add', $dados);
        $this->load->view('layout/app/footer');
    }

    public function edit() {

        $id = $this->uri->segment(4);

        if (is_null($id)) {
            redireciona(base_url("/app/clientes/index"));
        }
        $dados           = Cliente::where('id', "=", $id)->first()->toArray();
        $dados["title"]  = "Editar Cliente";
        $dados['id']     = $id;
        $dados['active'] = 'clientes';
        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/clientes/add', $dados);
        $this->load->view('layout/app/footer');
    }

    public function update() {
        $dados["title"]  = "Editar Cliente";
         if ($this->input->post()) {

            $validaCamposVazios = $this->valida($this->input->post(), false);

            if (isset($validaCamposVazios["msg"]) && count($validaCamposVazios["msg"]) > 0) {
                $dados             = $this->input->post();
                $dados["msg_erro"] = $validaCamposVazios["msg"];
                $dados["title"]    = "Editar  Cliente";
                $dados["active"]   = "clientes";

                $this->load->view('layout/app/header', $dados);
                $this->load->view('layout/app/menu', $dados);
                $this->load->view('app/clientes/add', $dados);
                $this->load->view('layout/app/footer');
            } else {

                $dadosSave       = $this->input->post();
                $dados           = Cliente::where('id', "=", $dadosSave["id"])->first()->toArray();
                $validaDuplicado = Cliente::where([["email", "=", $dadosSave["email"]], ['id', "!=", $dadosSave["id"]]])->first();
                if (!empty($validaDuplicado)) {
                    $dados             = $this->input->post();
                    $dados["msg_erro"] = ["Já existe um Cliente cadastrado com esse email"];
                    $dados["title"]    = "Editar Cliente";
                    $dados["active"]   = "clientes";
                    $this->load->view('layout/app/header', $dados);
                    $this->load->view('layout/app/menu', $dados);
                    $this->load->view('app/clientes/add', $dados);
                    $this->load->view('layout/app/footer');


                } else {
                    $update           = Cliente::find($dadosSave["id"]);
                    $update->nome     = $dadosSave["nome"];
                    $update->email    = $dadosSave["email"];
                    $update->telefone = $dadosSave["telefone"];
                    $update->status   = $dadosSave["status"];
                    $response         = $update->save($dadosSave);
                    if ($response) {
                        $dados["msg_success"]   = ["Cliente atualizado com sucesso"];
                        $dados["active"]        = "clientes";
                        $dados["title"]         = "Editar Cliente";
                        $this->load->view('layout/app/header', $dados);
                        $this->load->view('layout/app/menu', $dados);
                        $this->load->view('app/clientes/add', $dados);
                        $this->load->view('layout/app/footer');
                         redireciona(base_url("/app/clientes/index"),1);
                    }
                }
            }
        } else {
            redirect('/app/clientes/index');
        }
    }

    public function create()
    {
       
        if ($this->input->post()) {

            $validaCamposVazios = $this->valida($this->input->post());

            if (isset($validaCamposVazios["msg"]) && count($validaCamposVazios["msg"]) > 0) {
                $dados              = $this->input->post();
                $dados["active"]    = "clientes";
                $dados["title"]     = "Novo Cliente";
                $dados["msg_erro"]  = $validaCamposVazios["msg"];
                $this->load->view('layout/app/header', $dados);
                $this->load->view('layout/app/menu', $dados);
                $this->load->view('app/clientes/add', $dados);
                $this->load->view('layout/app/footer');
            } else {

                $dadosSave              = $this->input->post();
                $validaDuplicado        = Cliente::where("email", "=", $dadosSave["email"])->first();
                if (!empty($validaDuplicado)) {
                    $dados             = $this->input->post();
                    $dados["msg_erro"] = ["Já existe um Cliente cadastrado com esse email"];
                    $dados["active"]   = "clientes";
                    $dados["title"]    = "Novo Cliente";
                    $this->load->view('layout/app/header', $dados);
                    $this->load->view('layout/app/menu', $dados);
                    $this->load->view('app/clientes/add', $dados);
                    $this->load->view('layout/app/footer');

                } else {
                    $insert             = new Cliente;
                    $insert->nome       = $dadosSave["nome"];
                    $insert->status     = $dadosSave["status"];
                    $insert->telefone   = $dadosSave["telefone"];
                    $insert->email      = $dadosSave["email"];
                    $response           = $insert->save($dadosSave);
                    if ($response) {
                        $dados["msg_success"]   = ["Cliente cadastrado com sucesso"];
                        $dados["title"]         = "Novo Cliente";
                        $dados["active"]        = "clientes";
                        $this->load->view('layout/app/header', $dados);
                        $this->load->view('layout/app/menu', $dados);
                        $this->load->view('app/clientes/add', $dados);
                        $this->load->view('layout/app/footer');
                        redireciona(base_url("/app/clientes/index"),1);
                    }
                }
            }
        } else {
            redirect('/app/clientes/index');
        }
    }

    public function valida($dados, $insert = true)
    {
        $msg_erro = [];
        if (strlen($dados["nome"]) == 0) {
            $msg_erro['msg'][] = "O campo NOME é obrigatório";
        }
        return $msg_erro;
    }

    public function status() {
        $data['active'] = 'clientes';
        $id = $this->uri->segment(4);
        if (is_null($id)) {
            redireciona("/app/clientes/index");
        }
        $retorno = Cliente::where("id", "=", $id)->first()->toArray();
        if ($retorno["status"] == "I") {
            $novoStatus = "A";
        } else {
            $novoStatus = "I";
        }
        $user           = Cliente::find($id);
        $user->status   = $novoStatus;
        $response       = $user->save();
        if ($response) {
            redireciona(base_url("/app/clientes/index"));
        } else {
            redireciona(base_url("/app/clientes/index"));
        }

    }

    public function delete() {
        $data['active'] = 'clientes';
        $id = $this->uri->segment(4);
        if (is_null($id)) {
            redireciona("/app/clientes/index");
        }
        $user           = Cliente::find($id);
        $user->status   = "E";
        $response       = $user->save();
        if ($response) {
            redireciona(base_url("/app/clientes/index"));
        } else {
            redireciona(base_url("/app/clientes/index"));
        }

    }

}
