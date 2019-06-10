<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StatusPedidos extends CI_Controller {
	function __construct() {
        parent::__construct();
        $logged = $this->nativesession->get('logged');
        if (!isset($logged) || $logged != true) {
            redirect(base_url('/app/login/index'));
        }
    }

    public function index()
    {
        $dados["active"] = "statusPedidos";
        $dados["title"]  = "Listagem de Status de Pedidos";
        $dados["list"]   = StatusPedido::where("status", "!=", "E")->get()->toArray();
        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/status_pedidos/index', $dados);
        $this->load->view('layout/app/footer');
    }
    public function add()
    {
        $dados["active"] = "statusPedidos";
        $dados["title"]  = "Novo Status";
        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/status_pedidos/add', $dados);
        $this->load->view('layout/app/footer');
    }

    public function edit() {

        $id = $this->uri->segment(4);

        if (is_null($id)) {
            redireciona(base_url("/app/statusPedidos/index"));
        }
        $dados           = StatusPedido::where('id', "=", $id)->first()->toArray();
        $dados["title"]  = "Editar Status";
        $dados['id']     = $id;
        $dados['active'] = 'statusPedidos';
        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/status_pedidos/add', $dados);
        $this->load->view('layout/app/footer');
    }

    public function update() {
        $dados["title"]  = "Editar Status";
         if ($this->input->post()) {

            $validaCamposVazios = $this->valida($this->input->post(), false);

            if (isset($validaCamposVazios["msg"]) && count($validaCamposVazios["msg"]) > 0) {
                $dados             = $this->input->post();
                $dados["msg_erro"] = $validaCamposVazios["msg"];
                $dados["title"]    = "Editar  Status";
                $dados["active"]   = "statusPedidos";

                $this->load->view('layout/app/header', $dados);
                $this->load->view('layout/app/menu', $dados);
                $this->load->view('app/status_pedidos/add', $dados);
                $this->load->view('layout/app/footer');
            } else {

                $dadosSave       = $this->input->post();
                $dados           = StatusPedido::where('id', "=", $dadosSave["id"])->first()->toArray();
                $validaDuplicado = StatusPedido::where([["nome", "=", $dadosSave["nome"]], ['id', "!=", $dadosSave["id"]]])->first();
                if (!empty($validaDuplicado)) {
                    $dados             = $this->input->post();
                    $dados["msg_erro"] = ["Já existe um Status cadastrado com esse nome"];
                    $dados["title"]    = "Editar Status";
                    $dados["active"]   = "statusPedidos";
                    $this->load->view('layout/app/header', $dados);
                    $this->load->view('layout/app/menu', $dados);
                    $this->load->view('app/status_pedidos/add', $dados);
                    $this->load->view('layout/app/footer');


                } else {
                    $update           = StatusPedido::find($dadosSave["id"]);
                    $update->nome     = $dadosSave["nome"];
                    $update->status   = $dadosSave["status"];
                    $response         = $update->save($dadosSave);
                    if ($response) {
                        $dados["msg_success"]   = ["Status atualizado com sucesso"];
                        $dados["active"]        = "statusPedidos";
                        $dados["title"]         = "Editar Status";
                        $this->load->view('layout/app/header', $dados);
                        $this->load->view('layout/app/menu', $dados);
                        $this->load->view('app/status_pedidos/add', $dados);
                        $this->load->view('layout/app/footer');
                         redireciona(base_url("/app/statusPedidos/index"),1);
                    }
                }
            }
        } else {
            redirect('/app/statusPedidos/index');
        }
    }

    public function create()
    {
       
        if ($this->input->post()) {

            $validaCamposVazios = $this->valida($this->input->post());

            if (isset($validaCamposVazios["msg"]) && count($validaCamposVazios["msg"]) > 0) {
                $dados              = $this->input->post();
                $dados["active"]    = "statusPedidos";
                $dados["title"]     = "Novo Status";
                $dados["msg_erro"]  = $validaCamposVazios["msg"];
                $this->load->view('layout/app/header', $dados);
                $this->load->view('layout/app/menu', $dados);
                $this->load->view('app/status_pedidos/add', $dados);
                $this->load->view('layout/app/footer');
            } else {

                $dadosSave              = $this->input->post();
                $validaDuplicado        = StatusPedido::where("nome", "=", $dadosSave["nome"])->first();
                if (!empty($validaDuplicado)) {
                    $dados             = $this->input->post();
                    $dados["msg_erro"] = ["Já existe um Status cadastrado com esse nome"];
                    $dados["active"]   = "statusPedidos";
                    $dados["title"]    = "Novo Status";
                    $this->load->view('layout/app/header', $dados);
                    $this->load->view('layout/app/menu', $dados);
                    $this->load->view('app/status_pedidos/add', $dados);
                    $this->load->view('layout/app/footer');

                } else {
                    $insert           = new StatusPedido;
                    $insert->nome     = $dadosSave["nome"];
                    $insert->status   = $dadosSave["status"];
                    $response         = $insert->save($dadosSave);
                    if ($response) {
                        $dados["msg_success"]   = ["Status do Pedido cadastrado com sucesso"];
                        $dados["title"]         = "Novo Status";
                        $dados["active"]        = "statusPedidos";
                        $this->load->view('layout/app/header', $dados);
                        $this->load->view('layout/app/menu', $dados);
                        $this->load->view('app/status_pedidos/add', $dados);
                        $this->load->view('layout/app/footer');
                        redireciona(base_url("/app/statusPedidos/index"),1);
                    }
                }
            }
        } else {
            redirect('/app/statusPedidos/index');
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
        $data['active'] = 'statusPedidos';
        $id = $this->uri->segment(4);
        if (is_null($id)) {
            redireciona("/app/statusPedidos/index");
        }
        $retorno = StatusPedido::where("id", "=", $id)->first()->toArray();
        if ($retorno["status"] == "I") {
            $novoStatus = "A";
        } else {
            $novoStatus = "I";
        }
        $update           = StatusPedido::find($id);
        $update->status   = $novoStatus;
        $response         = $update->save();
        if ($response) {
            redireciona(base_url("/app/statusPedidos/index"));
        } else {
            redireciona(base_url("/app/statusPedidos/index"));
        }

    }

    public function delete() {
        $data['active'] = 'statusPedidos';
        $id = $this->uri->segment(4);
        if (is_null($id)) {
            redireciona("/app/statusPedidos/index");
        }
        $update           = StatusPedido::find($id);
        $update->status   = "E";
        $response         = $update->save();
        if ($response) {
            redireciona(base_url("/app/statusPedidos/index"));
        } else {
            redireciona(base_url("/app/statusPedidos/index"));
        }

    }

}
