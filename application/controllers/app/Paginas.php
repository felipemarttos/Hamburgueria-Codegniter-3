<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paginas extends CI_Controller {
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
        $dados["title"] = "Listagem de Páginas Estáticas";
        $dados["list"] = Pagina::where("status", "!=", "R")->get()->toArray();
        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/paginas/index', $dados);
        $this->load->view('layout/app/footer');
    }
 

    public function editar() {

        $id = $this->uri->segment(4);

        if (is_null($id)) {
            redireciona(base_url("/app/paginas/index"));
        }
        $dados          = Pagina::where('id', "=", $id)->first()->toArray();
        $dados["title"] = "Editar Página";
        $dados['id'] = $id;
        $dados['active'] = 'cadastros';
        $this->load->view('layout/app/header', $dados);
        $this->load->view('layout/app/menu', $dados);
        $this->load->view('app/paginas/add', $dados);
        $this->load->view('layout/app/footer');
    }



    public function update() {
        $dados["active"] = "cadastros";
        $dados["title"] = "Editar Página";
         if ($this->input->post()) {

            $retorno = $this->valida($this->input->post());

            if (isset($retorno["msg"]) && count($retorno["msg"]) > 0) {
                $dados             = $this->input->post();
                $dados["active"] = "cadastros";
                $dados["msg_erro"] = $retorno["msg"];
                $dados["title"]    = "Editar Página";
                $this->load->view('layout/app/header', $dados);
                $this->load->view('layout/app/menu', $dados);
                $this->load->view('app/paginas/add', $dados);
                $this->load->view('layout/app/footer');
            } else {

                $dadosSave                  = $this->input->post();
                $dados                      = Pagina::where('id', "=", $dadosSave["id"])->first()->toArray();
                $pagina                     = Pagina::find($dadosSave["id"]);
                $pagina->nome_pagina        = $dadosSave["nome_pagina"];
                $pagina->titulo_pagina      = $dadosSave["titulo_pagina"];
                $pagina->conteudo           = $dadosSave["conteudo"];
                $pagina->status             = $dadosSave["status"];
                $pagina->meta_title         = $dadosSave["meta_title"];
                $pagina->meta_description   = $dadosSave["meta_description"];
                $pagina->meta_key           = $dadosSave["meta_key"];
                $pagina->id_club            = 1;
                $ok                         = $pagina->save();
                if ($ok) {
                    $dados["active"] = "cadastros";
                    $dados["msg_success"]   = ["Página atualizado com sucesso"];
                    $dados["title"]         = "Editar Página";
                    $this->load->view('layout/app/header', $dados);
                    $this->load->view('layout/app/menu', $dados);
                    $this->load->view('app/paginas/add', $dados);
                    $this->load->view('layout/app/footer');
                    redireciona(base_url("/app/paginas/index"),1);
                }
            }
        } else {
            redirect('/app/paginas/index');
        }
    }

    public function valida($dados)
    {
        $msg_erro = [];
        if (strlen($dados["nome_pagina"]) == 0) {
            $msg_erro['msg'][] = "O campo NOME DA PAGINA é obrigatório";
        }
        if (strlen($dados["titulo_pagina"]) == 0) {
            $msg_erro['msg'][] = "O campo TITULO DA PAGINA é obrigatório";
        }
        if (strlen($dados["conteudo"]) == 0) {
            $msg_erro['msg'][] = "O campo CONTEÚDO é obrigatório";
        }
        return $msg_erro;
    }


    public function uploadFoto() {
        $pasta = 'assets/template/images/';
        if ($_FILES["imagem"]["error"] == UPLOAD_ERR_OK) {
            $tmp_name   = $_FILES["imagem"]["tmp_name"];
            $nome_foto  = date('dmy') . '_Pagina_' . $_FILES["imagem"]["name"];
            $uploadfile = $pasta . basename($nome_foto);
            if (move_uploaded_file($tmp_name, $uploadfile)) {
                return $nome_foto;
            }
        }
    }


    public function status() {
        $data['active'] = 'cadastros';
        
        $id = $this->uri->segment(4);
        
        if (is_null($id)) {
            redireciona("/app/paginas/index");
        }
        $retorno = Pagina::where("id", "=", $id)->first()->toArray();
        if ($retorno["status"] == "N") {
            $novoStatus = "S";
        } else {
            $novoStatus = "N";
        }
        $user = Pagina::find($id);
        $user->status   = $novoStatus;
        $ok = $user->save();
        if ($ok) {
            redireciona(base_url("/app/paginas/index"));
        } else {
            redireciona(base_url("/app/paginas/index"));
        }

    }

}

