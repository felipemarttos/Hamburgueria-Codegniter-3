<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Planos extends CI_Controller {
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
        $dados["title"] = "Listagem de Planos";

        $dados["list"] = Plano::join('tb_produtos', 'tb_produtos.id', '=', 'tb_planos.id_produto')
                               ->join('tb_produtos_valores', 'tb_produtos.id', '=', 'tb_produtos_valores.id_produto')
                               ->where("tb_planos.status", "!=", "R")
                               ->get([
                                    'tb_planos.*',
                                    'tb_produtos.nome AS nome_produto',
                                    'tb_produtos.codigo AS codigo_produto',
                                    'tb_produtos_valores.valor_mensal',
                                    'tb_produtos_valores.valor_trimestral',
                                    'tb_produtos_valores.valor_semestral',
                                    'tb_produtos_valores.valor_anual'
                                ])
                               ->toArray();
        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/planos/index', $dados);
        $this->load->view('layout/app/footer');
    }
    public function add()
    {
        $dados["active"]   = "assinatura";
        $dados["title"]    = "Novo Plano";
        $dados["produtos"] = Produto::where("status", "!=", "R")->get()->toArray();
        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/planos/add', $dados);
        $this->load->view('layout/app/footer');
    }

    public function editar() {

        $id = $this->uri->segment(4);

        if (is_null($id)) {
            redireciona(base_url("/app/planos/index"));
        }
        $dados              = Plano::where('id', "=", $id)->first()->toArray();
        $dados["title"]     = "Editar Plano";
        $dados['id']        = $id;
        $dados['active']    = 'assinatura';
        $dados["produtos"]  = Produto::where("status", "!=", "R")->get()->toArray();
        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/planos/add', $dados);
        $this->load->view('layout/app/footer');
    }



    public function update() {
        $dados["active"] = "assinatura";
        $dados["title"] = "Editar Plano";
        $dados["produtos"]  = Produto::where("status", "!=", "R")->get()->toArray();
         if ($this->input->post()) {

            $retorno = $this->valida($this->input->post());

            if (isset($retorno["msg"]) && count($retorno["msg"]) > 0) {
                $dados             = $this->input->post();
                $dados["active"] = "assinatura";
                $dados["msg_erro"] = $retorno["msg"];
                $dados["title"]    = "Editar  Plano";
                $this->load->view('layout/app/header', $dados);
                $this->load->view('layout/app/menu', $dados);
                $this->load->view('app/planos/add', $dados);
                $this->load->view('layout/app/footer');
            } else {

                $dadosSave      = $this->input->post();
                $user           = Plano::find($dadosSave["id"]);
                $user->id_produto     = $dadosSave["id_produto"];
                $user->nome     = $dadosSave["nome"];
                $user->recorrencia     = $dadosSave["recorrencia"];
                $user->status   = strlen($dadosSave["status"]) == 0 ? "N" : "S";
                $user->id_club  = 1;
                $ok             = $user->save();
                if ($ok) {
                    $dados["active"] = "assinatura";
                    $dados["msg_success"]   = ["Plano atualizado com sucesso"];
                    $dados["title"]         = "Editar Plano";
                    $this->load->view('layout/app/header', $dados);
                    $this->load->view('layout/app/menu', $dados);
                    $this->load->view('app/planos/add', $dados);
                    $this->load->view('layout/app/footer');
                    redireciona(base_url("/app/planos/index"),1);
                }
            }
        } else {
            redirect('/app/planos/index');
        }
    }

    public function create()
    {
        $dados["active"] = "assinatura";
        $dados["title"] = "Novo Plano";

        if ($this->input->post()) {

            $retorno = $this->valida($this->input->post());

            if (isset($retorno["msg"]) && count($retorno["msg"]) > 0) {
                $dados             = $this->input->post();
                $dados["msg_erro"] = $retorno["msg"];
                $dados["title"]    = "Novo Plano";
                 $dados["active"] = "assinatura";
                $this->load->view('layout/app/header', $dados);
                $this->load->view('layout/app/menu', $dados);
                $this->load->view('app/planos/add', $dados);
                $this->load->view('layout/app/footer');
            } else {

                $dadosSave      = $this->input->post();
               
                    $user           = new Plano;
                    $user->id_produto     = $dadosSave["id_produto"];
                    $user->nome     = $dadosSave["nome"];
                    $user->recorrencia     = $dadosSave["recorrencia"];
                    $user->status   = (!isset($dadosSave["status"]) || strlen($dadosSave["status"]) == 0) ? "N" : "S";
                    $user->id_club  = 1;
                    $ok             = $user->save();
                    if ($ok) {
                        $dados["msg_success"]   = ["Plano cadastrado com sucesso"];
                        $dados["title"]         = "Novo Plano";
                         $dados["active"] = "assinatura";
                        $this->load->view('layout/app/header', $dados);
                        $this->load->view('layout/app/menu', $dados);
                        $this->load->view('app/planos/add', $dados);
                        $this->load->view('layout/app/footer');
                        redireciona(base_url("/app/planos/index"),1);
                    }
                
            }
        } else {
            redirect('/app/planos/index');
        }
    }

    public function valida($dados)
    {
        $msg_erro = [];
        if (strlen($dados["id_produto"]) == 0) {
            $msg_erro['msg'][] = "O campo PRODUTO é obrigatório";
        }
        if (strlen($dados["nome"]) == 0) {
            $msg_erro['msg'][] = "O campo NOME é obrigatório";
        }
        if (strlen($dados["recorrencia"]) == 0) {
            $msg_erro['msg'][] = "O campo RECORRÊNCIA é obrigatório";
        }
        return $msg_erro;
    }

    public function status() {
        $data['active'] = 'assinatura';
        
        $id = $this->uri->segment(4);
        
        if (is_null($id)) {
            redireciona("/app/planos/index");
        }
        $retorno = Plano::where("id", "=", $id)->first()->toArray();
        if ($retorno["status"] == "N") {
            $novoStatus = "S";
        } else {
            $novoStatus = "N";
        }
        $user = Plano::find($id);
        $user->status   = $novoStatus;
        $ok = $user->save();
        if ($ok) {
            redireciona(base_url("/app/planos/index"));
        } else {
            redireciona(base_url("/app/planos/index"));
        }

    }

    public function remover() {
        $data['active'] = 'assinatura';
        
        $id = $this->uri->segment(4);
        
        if (is_null($id)) {
            redireciona("/app/planos/index");
        }
        $novoStatus = "R";
        $user = Plano::find($id);
        $user->status   = $novoStatus;
        $ok = $user->save();
        if ($ok) {
            redireciona(base_url("/app/planos/index"));
        } else {
            redireciona(base_url("/app/planos/index"));
        }

    }

}

