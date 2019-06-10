<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {
	function __construct() {
        parent::__construct();
        $logged = $this->nativesession->get('logged');
        if (!isset($logged) || $logged != true) {
            redirect(base_url('/app/login/index'));
        }
        $this->load->model('usuario');
    }
    /*
    ** METODO RESPONSAVEL PELA LISTAGEM DAS CATEGORIAS
    **
    */
    public function index()
    {
        $dados["active"] = "usuarios";
        $dados["title"]  = "Listagem de Usuários";
        $dados["list"]   = Usuario::where("status", "!=", "E")->get()->toArray();
        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/usuarios/index', $dados);
        $this->load->view('layout/app/footer');
    }
      /*
    ** METODO RESPONSAVEL PELA CRIAÇÃO DA TELA DE CADASTRO
    **
    */

    public function add()
    {
        $dados["active"] = "usuarios";
        $dados["title"]  = "Novo Usuário";
        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/usuarios/add', $dados);
        $this->load->view('layout/app/footer');
    }
     /*
    ** METODO RESPONSAVEL PELA CRIAÇÃO DA TELA DE EDIÇÃO 
    **
    */
    public function edit() {

        $id = $this->uri->segment(4);

        if (is_null($id)) {
            redireciona(base_url("/app/usuarios/index"));
        }
        $dados           = Usuario::where('id', "=", $id)->first()->toArray();
        $dados["title"]  = "Editar Usuário";
        $dados['id']     = $id;
        $dados['active'] = 'usuarios';
        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/usuarios/add', $dados);
        $this->load->view('layout/app/footer');
    }
    /*
    ** METODO RESPONSAVEL PELA GRAVAÇÃO DE EDIÇÃO
    **
    */
    public function update() {
        $dados["title"]  = "Editar Usuário";
         if ($this->input->post()) {

            $retorno = $this->valida($this->input->post(), false);

            if (isset($retorno["msg"]) && count($retorno["msg"]) > 0) {
                $dados             = $this->input->post();
                $dados["msg_erro"] = $retorno["msg"];
                $dados["title"]    = "Editar  Usuário";
                $dados["active"]   = "usuarios";

                $this->load->view('layout/app/header', $dados);
                $this->load->view('layout/app/menu', $dados);
                $this->load->view('app/usuarios/add', $dados);
                $this->load->view('layout/app/footer');
            } else {

                $dadosSave      = $this->input->post();
                $dados          = Usuario::where('id', "=", $dadosSave["id"])->first()->toArray();
                $retorno        = Usuario::where([["email", "=", $dadosSave["email"]], ['id', "!=", $dadosSave["id"]]])->first();
                if (!empty($retorno)) {
                    $retorno = $retorno->toArray();
                    $dados             = $this->input->post();
                    $dados["msg_erro"] = ["Já existe um usuario cadastrado com esse e-mail"];
                    $dados["title"]    = "Editar  Usuário";
                    $dados["active"]   = "usuarios";
                    $this->load->view('layout/app/header', $dados);
                    $this->load->view('layout/app/menu', $dados);
                    $this->load->view('app/usuarios/add', $dados);
                    $this->load->view('layout/app/footer');


                } else {
                    $user           = Usuario::find($dadosSave["id"]);
                    $user->nome     = $dadosSave["nome"];
                    $user->email    = $dadosSave["email"];
                    $user->status   = $dadosSave["status"];
                    $response       = $user->save($dadosSave);
                    if ($response) {
                        $dados["msg_success"]   = ["Usuário atualizado com sucesso"];
                        $dados["active"]        = "usuarios";
                        $dados["title"]         = "Editar Usuário";
                        $this->load->view('layout/app/header', $dados);
                        $this->load->view('layout/app/menu', $dados);
                        $this->load->view('app/usuarios/add', $dados);
                        $this->load->view('layout/app/footer');
                         redireciona(base_url("/app/usuarios/index"),1);
                    }
                }
            }
        } else {
            redirect('/app/usuarios/index');
        }
    }
     /*
    ** METODO RESPONSAVEL PELA GRAVAÇÃO DE INSERÇÃO
    **
    */
    public function create()
    {
       
        if ($this->input->post()) {

            $retorno = $this->valida($this->input->post());

            if (isset($retorno["msg"]) && count($retorno["msg"]) > 0) {
                $dados             = $this->input->post();
                $dados["active"] = "usuarios";
                $dados["title"]  = "Novo Usuário";
                $dados["msg_erro"] = $retorno["msg"];
                $this->load->view('layout/app/header', $dados);
                $this->load->view('layout/app/menu', $dados);
                $this->load->view('app/usuarios/add', $dados);
                $this->load->view('layout/app/footer');
            } else {

                $dadosSave      = $this->input->post();
                $retorno = Usuario::where("email", "=", $dadosSave["email"])->first();
                if (!empty($retorno)) {
                    $retorno = $retorno->toArray();
                    $dados             = $this->input->post();
                    $dados["msg_erro"] = ["Já existe um usuario cadastrado com esse e-mail"];
                    $dados["active"]   = "usuarios";
                    $dados["title"]    = "Novo Usuário";
                    $this->load->view('layout/app/header', $dados);
                    $this->load->view('layout/app/menu', $dados);
                    $this->load->view('app/usuarios/add', $dados);
                    $this->load->view('layout/app/footer');

                } else {
                    $user           = new Usuario;
                    $user->nome     = $dadosSave["nome"];
                    $user->email    = $dadosSave["email"];
                    $user->status   = $dadosSave["status"];
                    $user->senha    = md5(trim($dadosSave["senha"]));
                    $response       = $user->save($dadosSave);
                    if ($response) {
                        $dados["msg_success"]   = ["Usuário cadastrado com sucesso"];
                        $dados["title"]         = "Novo Usuário";
                        $dados["active"]        = "usuarios";
                        $this->load->view('layout/app/header', $dados);
                        $this->load->view('layout/app/menu', $dados);
                        $this->load->view('app/usuarios/add', $dados);
                        $this->load->view('layout/app/footer');
                     redireciona(base_url("/app/usuarios/index"),1);
                    }
                }
            }
        } else {
            redirect('/app/usuarios/index');
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
        if (strlen($dados["email"]) == 0) {
            $msg_erro['msg'][] = "O campo E-MAIL é obrigatório";
        }
        if ($insert) {
            if (strlen($dados["senha"]) == 0) {
                $msg_erro['msg'][] = "O campo SENHA é obrigatório";
            }
        }
        return $msg_erro;
    }
 /*
    ** METODO RESPONSAVEL POR ATIVAR E INATIVAR 
    **
    */
    public function status() {
        $data['active'] = 'cadastros';
        $id = $this->uri->segment(4);
        if (is_null($id)) {
            redireciona("/app/usuarios/index");
        }
        $retorno = Usuario::where("id", "=", $id)->first()->toArray();
        if ($retorno["status"] == "I") {
            $novoStatus = "A";
        } else {
            $novoStatus = "I";
        }
        $user           = Usuario::find($id);
        $user->status   = $novoStatus;
        $response       = $user->save();
        if ($response) {
            redireciona(base_url("/app/usuarios/index"));
        } else {
            redireciona(base_url("/app/usuarios/index"));
        }

    }
  /*
    ** METODO RESPONSAVEL POR REMOVER FORMAS
    **
    */
    public function delete() {
        $data['active'] = 'usuarios';
        $id = $this->uri->segment(4);
        if (is_null($id)) {
            redireciona("/app/usuarios/index");
        }
        $user           = Usuario::find($id);
        $user->status   = "E";
        $response       = $user->save();
        if ($response) {
            redireciona(base_url("/app/usuarios/index"));
        } else {
            redireciona(base_url("/app/usuarios/index"));
        }

    }

}

